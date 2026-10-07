<?php

declare(strict_types=1);

namespace App\Core;

final class ImageService
{
    public function store(array $file): array
    {
        $app = require BASE_PATH . '/config/app.php';
        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            throw new \RuntimeException('Upload failed.');
        }
        if (($file['size'] ?? 0) > $app['upload_max_bytes']) {
            throw new \RuntimeException('File is too large.');
        }
        $tmp = $file['tmp_name'];
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($tmp) ?: '';
        if (!in_array($mime, $app['allowed_image_mimes'], true)) {
            throw new \RuntimeException('Invalid image type.');
        }
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $app['allowed_image_ext'], true)) {
            throw new \RuntimeException('Invalid file extension.');
        }
        $info = getimagesize($tmp);
        if ($info === false || ($info[0] ?? 0) < 1) {
            throw new \RuntimeException('Invalid image dimensions.');
        }
        $safe = bin2hex(random_bytes(16));
        $dir = PUBLIC_PATH . '/uploads/' . date('Y/m');
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        $origName = $safe . '.' . $ext;
        $dest = $dir . '/' . $origName;
        if (!move_uploaded_file($tmp, $dest)) {
            throw new \RuntimeException('Could not save file.');
        }
        $webp = $this->makeWebp($dest, $dir . '/' . $safe . '.webp');
        $thumb = $this->resize($dest, $dir . '/' . $safe . '_thumb.webp', 480);
        $medium = $this->resize($dest, $dir . '/' . $safe . '_md.webp', 960);
        $rel = 'uploads/' . date('Y/m') . '/';
        return [
            'original' => $rel . $origName,
            'webp' => $webp ? $rel . $safe . '.webp' : $rel . $origName,
            'thumb' => $thumb ? $rel . $safe . '_thumb.webp' : $rel . $origName,
            'medium' => $medium ? $rel . $safe . '_md.webp' : $rel . $origName,
            'mime' => $mime,
            'width' => $info[0],
            'height' => $info[1],
            'size' => filesize($dest) ?: 0,
            'original_name' => $file['name'],
        ];
    }

    private function makeWebp(string $src, string $dest): bool
    {
        $im = $this->load($src);
        if (!$im) {
            return false;
        }
        $ok = imagewebp($im, $dest, 80);
        imagedestroy($im);
        return $ok;
    }

    private function resize(string $src, string $dest, int $maxW): bool
    {
        $im = $this->load($src);
        if (!$im) {
            return false;
        }
        $w = imagesx($im);
        $h = imagesy($im);
        if ($w <= $maxW) {
            $ok = imagewebp($im, $dest, 80);
            imagedestroy($im);
            return $ok;
        }
        $nw = $maxW;
        $nh = (int) round($h * ($maxW / $w));
        $dst = imagecreatetruecolor($nw, $nh);
        imagecopyresampled($dst, $im, 0, 0, 0, 0, $nw, $nh, $w, $h);
        $ok = imagewebp($dst, $dest, 80);
        imagedestroy($im);
        imagedestroy($dst);
        return $ok;
    }

    private function load(string $src): \GdImage|false
    {
        $mime = mime_content_type($src);
        return match ($mime) {
            'image/jpeg' => imagecreatefromjpeg($src),
            'image/png' => imagecreatefrompng($src),
            'image/webp' => imagecreatefromwebp($src),
            default => false,
        };
    }
}

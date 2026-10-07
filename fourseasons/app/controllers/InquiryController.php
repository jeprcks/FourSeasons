<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Csrf;
use App\Core\Validator;
use App\Middleware\CsrfMiddleware;
use App\Middleware\ThrottleMiddleware;
use App\Models\Lead;
use App\Models\Service;

final class InquiryController extends Controller
{
    public function store(): void
    {
        CsrfMiddleware::handle();
        $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
        if (ThrottleMiddleware::tooMany('inquiry:' . $ip, 8, 10)) {
            $this->fail('Please wait before submitting another inquiry.', 429);
            return;
        }

        $data = [
            'full_name' => trim((string) ($_POST['full_name'] ?? '')),
            'email' => trim((string) ($_POST['email'] ?? '')),
            'phone' => trim((string) ($_POST['phone'] ?? '')),
            'whatsapp' => trim((string) ($_POST['whatsapp'] ?? '')),
            'location' => trim((string) ($_POST['location'] ?? '')),
            'service_id' => (string) ($_POST['service_id'] ?? ''),
            'preferred_contact' => (string) ($_POST['preferred_contact'] ?? 'Phone'),
            'message' => trim((string) ($_POST['message'] ?? '')),
            'consent' => $_POST['consent'] ?? null,
            'appointment_type' => trim((string) ($_POST['appointment_type'] ?? '')),
            'appointment_date' => trim((string) ($_POST['appointment_date'] ?? '')),
        ];

        $validator = new Validator();
        $ok = $validator->validate($data, [
            'full_name' => 'required|name|min:2|max:100',
            'email' => 'required|email|max:190',
            'phone' => 'phone|max:20',
            'whatsapp' => 'phone|max:20',
            'location' => 'required|min:2|max:180',
            'service_id' => 'required|integer',
            'preferred_contact' => 'in:Phone,Email,WhatsApp,Viber',
            'message' => 'max:2000',
            'consent' => 'accepted',
        ]);

        if (!$ok) {
            $this->fail('Please correct the highlighted fields.', 422, $validator->errors());
            return;
        }

        $service = (new Service())->find((int) $data['service_id']);
        if (!$service) {
            $this->fail('Please select a valid service.', 422, ['service_id' => ['Please select a service.']]);
            return;
        }

        $id = (new Lead())->insert([
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?: null,
            'whatsapp' => $data['whatsapp'] ?: null,
            'location' => $data['location'],
            'service_id' => (int) $data['service_id'],
            'preferred_contact' => $data['preferred_contact'] ?: 'Phone',
            'message' => $data['message'] ?: null,
            'source_page' => substr((string) ($_POST['source_page'] ?? ($_SERVER['HTTP_REFERER'] ?? '/')), 0, 250),
            'appointment_type' => $data['appointment_type'] ?: null,
            'appointment_date' => $data['appointment_date'] !== '' ? $data['appointment_date'] : null,
            'status' => 'New',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $this->ok('Thank you. We will contact you soon.', $id);
    }

    private function fail(string $message, int $status, array $errors = []): void
    {
        $ajax = $this->isAjax();
        if ($ajax) {
            $this->json(['ok' => false, 'message' => $message, 'errors' => $errors], $status);
            return;
        }
        \App\Core\Session::flash('error', $message);
        $this->back();
    }

    private function ok(string $message, int $id): void
    {
        if ($this->isAjax()) {
            $this->json(['ok' => true, 'message' => $message, 'id' => $id]);
            return;
        }
        \App\Core\Session::flash('message', $message);
        $this->back();
    }

    private function isAjax(): bool
    {
        return str_contains($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json')
            || ($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'XMLHttpRequest';
    }
}

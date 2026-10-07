<?php

declare(strict_types=1);

namespace App\Core;

final class Validator
{
    private array $errors = [];

    public function validate(array $data, array $rules): bool
    {
        $this->errors = [];
        foreach ($rules as $field => $ruleString) {
            $rulesList = explode('|', $ruleString);
            $value = $data[$field] ?? null;
            foreach ($rulesList as $rule) {
                $param = null;
                if (str_contains($rule, ':')) {
                    [$rule, $param] = explode(':', $rule, 2);
                }
                $this->apply($field, $value, $rule, $param, $data);
            }
        }
        return $this->errors === [];
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function first(string $field): ?string
    {
        return $this->errors[$field][0] ?? null;
    }

    private function apply(string $field, mixed $value, string $rule, ?string $param, array $data): void
    {
        $label = ucwords(str_replace('_', ' ', $field));
        $str = is_scalar($value) ? trim((string) $value) : '';

        switch ($rule) {
            case 'required':
                if ($str === '' && $value !== '0') {
                    $this->add($field, $label . ' is required.');
                }
                break;
            case 'email':
                if ($str !== '' && !filter_var($str, FILTER_VALIDATE_EMAIL)) {
                    $this->add($field, 'Please enter a valid email address.');
                }
                break;
            case 'min':
                if ($str !== '' && mb_strlen($str) < (int) $param) {
                    $this->add($field, $label . ' must be at least ' . $param . ' characters.');
                }
                break;
            case 'max':
                if ($str !== '' && mb_strlen($str) > (int) $param) {
                    $this->add($field, $label . ' must be no more than ' . $param . ' characters.');
                }
                break;
            case 'phone':
                if ($str !== '' && !preg_match('/^[0-9+\-\s().]{7,20}$/', $str)) {
                    $this->add($field, 'Please enter a valid phone number.');
                }
                break;
            case 'name':
                if ($str !== '' && !preg_match('/^[\p{L}\s.\'-]{2,100}$/u', $str)) {
                    $this->add($field, 'Please enter a valid name.');
                }
                break;
            case 'in':
                $opts = explode(',', (string) $param);
                if ($str !== '' && !in_array($str, $opts, true)) {
                    $this->add($field, $label . ' is invalid.');
                }
                break;
            case 'accepted':
                if (!in_array($value, [1, '1', true, 'on', 'yes'], true)) {
                    $this->add($field, 'You must provide consent.');
                }
                break;
            case 'integer':
                if ($str !== '' && !ctype_digit($str) && !is_int($value)) {
                    $this->add($field, $label . ' must be a number.');
                }
                break;
            case 'confirmed':
                if ($str !== ($data[$field . '_confirmation'] ?? '')) {
                    $this->add($field, $label . ' confirmation does not match.');
                }
                break;
        }
    }

    private function add(string $field, string $message): void
    {
        $this->errors[$field][] = $message;
    }
}

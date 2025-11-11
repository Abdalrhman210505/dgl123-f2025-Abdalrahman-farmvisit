<?php
function not_empty(?string $value): bool
{
    return isset($value) && trim($value) !== '';
}

function len_between(string $value, int $min, int $max): bool
{
    $len = mb_strlen($value);
    return $len >= $min && $len <= $max;
}

function is_email(string $value): bool
{
    return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
}

function is_date(string $value): bool
{
    $dt = DateTime::createFromFormat('Y-m-d', $value);
    return $dt && $dt->format('Y-m-d') === $value;
}

function is_time(string $value): bool
{
    $dt = DateTime::createFromFormat('H:i', $value);
    return $dt && $dt->format('H:i') === $value;
}

function is_int_range($value, int $min, int $max): bool
{
    if (!is_numeric($value)) {
        return false;
    }
    $intVal = (int)$value;
    return $intVal >= $min && $intVal <= $max;
}

function safe_filename(string $filename): ?string
{
    $sanitized = preg_replace('/[^A-Za-z0-9_\.-]+/', '_', $filename);
    if ($sanitized === null || $sanitized === '') {
        return null;
    }
    return $sanitized;
}

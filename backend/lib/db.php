<?php
/**
 * Database connection helper.
 * Provides a singleton PDO instance configured via environment variables.
 */
function getPDO(): PDO
{
    if (isset($GLOBALS['__farmvisit_pdo']) && $GLOBALS['__farmvisit_pdo'] instanceof PDO) {
        return $GLOBALS['__farmvisit_pdo'];
    }

    $dsn = getenv('DB_DSN');
    if (!$dsn) {
        $host = getenv('DB_HOST') ?: '127.0.0.1';
        $dbname = getenv('DB_NAME') ?: 'farm_visit_showcase';
        $dsn = "mysql:host={$host};dbname={$dbname};charset=utf8mb4";
    }

    $user = getenv('DB_USER') ?: 'root';
    $pass = getenv('DB_PASS') ?: '';

    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    $pdo = new PDO($dsn, $user, $pass, $options);
    $GLOBALS['__farmvisit_pdo'] = $pdo;

    return $pdo;
}

/**
 * Utility used by tests to override the PDO instance.
 */
function setPDO(PDO $custom): void
{
    $GLOBALS['__farmvisit_pdo'] = $custom;
}

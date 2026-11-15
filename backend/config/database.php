<?php

// Share one configured PDO connection across the API and migration runner.
$databasePath = getenv('PAYROLL_DB_PATH') ?: __DIR__ . '/../database/payroll.sqlite';

try {
    $pdo = new PDO('sqlite:' . $databasePath);
    $pdo->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    // $pdo->exec('PRAGMA foreign_keys = ON');
    // $pdo->exec('PRAGMA busy_timeout = 5000');

} catch (PDOException $e) {
    error_log('Database connection failed: ' . $e->getMessage());
    throw $e;
}

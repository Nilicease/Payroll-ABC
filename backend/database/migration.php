<?php

require_once __DIR__ . '/../config/database.php';

// Ensure a fresh checkout can create its local SQLite database directory.
if (!is_dir(dirname($databasePath)) && !mkdir(dirname($databasePath), 0775, true)) {
    throw new RuntimeException('Could not create the SQLite database directory.');
}

// Track which schema changes have already been applied so rerunning this
// script does not try to create the same tables again.
$pdo->exec("
    CREATE TABLE IF NOT EXISTS migrations (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        migration TEXT NOT NULL UNIQUE,
        executed_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
    )
");

// Each migration file returns a function that applies one database change.
$files = glob(__DIR__ . '/migrations/*.php');

foreach ($files as $file) {

    $filename = basename($file);

    // Skip migrations recorded as successful in the tracking table.
    $stmt = $pdo->prepare(
        "SELECT id FROM migrations WHERE migration = ?"
    );

    $stmt->execute([$filename]);

    if ($stmt->fetch()) {
        echo "$filename already executed.\n";
        continue;
    }

    try {
        // Keep the schema change and its tracking record atomic: if either
        // fails, the database will not report a migration as partly applied.
        $pdo->beginTransaction();

        // Load the migration function and pass it the shared PDO connection.
        $migration = require $file;
        $migration($pdo);

        // Record success only after the migration function completes.
        $stmt = $pdo->prepare(
            "INSERT INTO migrations (migration) VALUES (?)"
        );

        $stmt->execute([$filename]);

        $pdo->commit();

        echo "$filename executed successfully.\n";

    } catch (Throwable $e) {

        // Undo all database changes made by this migration before reporting
        // the failure, so the script can be safely corrected and rerun.
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }

        error_log("Migration {$filename} failed: " . $e->getMessage());
        fwrite(STDERR, "Migration {$filename} failed.\n");
        exit(1);
    }
}
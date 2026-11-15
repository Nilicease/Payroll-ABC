<?php

// Create the table used to store login accounts and their access status.
return function (PDO $pdo) {
    $sql = "
        CREATE TABLE users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            email TEXT UNIQUE NOT NULL,
            password TEXT NOT NULL,

            role TEXT NOT NULL DEFAULT 'staff'
                CHECK (role IN ('staff', 'admin')),

            status TEXT NOT NULL DEFAULT 'active'
                CHECK (status IN ('active', 'inactive')),

            -- Store timestamps as SQLite-compatible text values.
            updated_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
            created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
        );
    ";

    $pdo->exec($sql);
};
<?php

return function(PDO $pdo) {
    $sql = "
        CREATE TABLE employees (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            employee_number TEXT NOT NULL UNIQUE,
            first_name TEXT NOT NULL,
            middle_name TEXT,
            last_name TEXT NOT NULL,
            email TEXT UNIQUE,
            phone TEXT,
            sex TEXT CHECK (sex IN ('female', 'male', 'other', 'unspecified')),
            birthday TEXT,
            civil_status TEXT,
            department_id INTEGER,
            position_id INTEGER,
            hire_date TEXT NOT NULL,
            employment_status TEXT NOT NULL DEFAULT 'active'
                CHECK (employment_status IN ('active', 'inactive', 'terminated')),
            updated_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
            created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE RESTRICT,
            FOREIGN KEY (position_id) REFERENCES positions(id) ON DELETE RESTRICT
        );
    ";

    $pdo->exec($sql);
};
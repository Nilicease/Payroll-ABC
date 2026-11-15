-- Current users schema. Migration 002 upgrades existing staff roles to user.
CREATE TABLE users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    email TEXT UNIQUE NOT NULL,
    password TEXT NOT NULL,

    role TEXT NOT NULL DEFAULT 'user'
        CHECK (role IN ('user', 'admin')),

    status TEXT NOT NULL DEFAULT 'active'
        CHECK (status IN ('active', 'inactive')),

    updated_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
    created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
);
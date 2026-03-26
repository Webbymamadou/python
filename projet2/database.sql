CREATE DATABASE IF NOT EXISTS practice_db;
USE practice_db;

CREATE TABLE IF NOT EXISTS departments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    department_id INT,
    FOREIGN KEY (department_id) REFERENCES departments(id)
);

-- Insérer quelques départements par défaut (exécuter une seule fois idéalement)
INSERT IGNORE INTO departments (id, name) VALUES (1, 'Informatique'), (2, 'Ressources Humaines'), (3, 'Marketing'), (4, 'Ventes');

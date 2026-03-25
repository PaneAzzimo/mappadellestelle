<?php
try {
    $pdo = new PDO(
        "mysql:host=localhost;dbname=stelle;charset=utf8mb4",
        "root",
        "",
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    die("Errore DB: " . htmlspecialchars($e->getMessage()));
}

function e($testo) {
    echo htmlspecialchars($testo ?? '', ENT_QUOTES, 'UTF-8');
}
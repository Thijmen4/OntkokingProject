<?php
// Lokaal (jouw computer) of online (hosting)?
if (in_array($_SERVER['REMOTE_ADDR'] ?? '', ['127.0.0.1', '::1'])) {
    $servername = "localhost";
    $username   = "root";
    $password   = "";
    $database   = "104301_program";
} else {
    $servername = "localhost";
    $username   = "db_104301";
    $password   = "arda99puq12!";
    $database   = "104301_program";
}

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8mb4", $username, $password, $options);
} catch (PDOException $e) {
    error_log($e->getMessage());
    http_response_code(500);
    exit("Fout: " . $e->getMessage());
}
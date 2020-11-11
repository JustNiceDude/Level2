<?php
$dsn = "mysql:host=backend.com;dbname=test_api";
try {
    $pdo = new PDO($dsn, "root", "mironcho7");
} catch (Exception $e) {
    http_response_code(500);
    error_log($e->getMessage());
    exit('Connection to database failed!');
}
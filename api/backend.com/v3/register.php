<?php
require_once "headers.php";
require_once "database_connection.php";
require_once "input_data_handler.php";
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    die();
}
// Get input content
$input_content = json_decode(file_get_contents('php://input'), true);
$input_login = input_data_handler($input_content['login']);
$input_password = input_data_handler($input_content['pass']);
// Check for existing user
if (isset($pdo)) {
    $stmt = $pdo->prepare("SELECT * FROM users");
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $row) {
        if ($row['login'] == $input_login) {
            $response = ['ok' => false];
            echo json_encode($response);
            exit();
        }
    }
}
// Insert new user into DB
if (isset($pdo)) {
    $stmt = $pdo->prepare("INSERT INTO users (login, password) VALUES ('$input_login','$input_password')");
    $stmt->execute();
} else {
    http_response_code(500);
    echo(json_encode(['error' => 'Connection to database failed']));
    exit();
}
$response = ['ok' => true];
echo json_encode($response);
$pdo = null;
exit();

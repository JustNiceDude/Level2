<?php
require_once "headers.php";
require_once "database_connection.php";
require_once "input_data_handler.php";
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die();
}
// Get input content
$input_content = json_decode(file_get_contents('php://input'), true);
$input_login = input_data_handler($input_content['login']);
$input_password = input_data_handler($input_content['pass']);
// Get list of users from DB
if (isset($pdo)) {
    $stmt = $pdo->prepare("SELECT * FROM users");
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Verify user
    foreach ($rows as $row) {
        if ($row['login'] == $input_login && $row['password'] == $input_password) {
            // Set cookie for current user
            $cookie_params = array(
                'expires' => time() + 86400,
                'path' => '/',
                'domain' => 'backend.com',
                'secure' => true,
                'httponly' => false,
                'samesite' => 'None'
            );
            setcookie('Test', 'Some text', $cookie_params);
            // Init session
            session_start();
            $_SESSION['id'] = $row['id'];
            $response = ['ok' => true];
            echo json_encode($response);
            exit();
        }
    }
} else {
    http_response_code(500);
    echo(json_encode(['error' => 'Connection to database failed']));
    exit();
}
$response = ['ok' => false];
echo json_encode($response);
<?php
require_once "headers.php";
require_once "database_connection.php";
require_once "input_data_handler.php";
// Get input content from front part
$input_content = json_decode(file_get_contents('php://input'), true);
$current_todo_id = $input_content['id'];
settype($current_todo_id, 'integer'); // Lead to integer type for SQL security requests
$new_text = input_data_handler($input_content['text']); // Handle input text
$new_status = $input_content['checked'];
// Get id of registered user
session_start();
$current_user_id = $_SESSION['id'];
settype($current_user_id, 'integer'); // Lead to integer type for SQL security requests
// Cast boolean value to int that will working for SQL
if ($new_status == true) {
    $new_status = 1;
} else {
    $new_status = 0;
}
// Insert data changes into DB
$response = ['ok' => false];
if (isset($pdo)) {
    $stmt = $pdo->prepare("UPDATE items SET text = '$new_text', checked = '$new_status' WHERE user_id = '$current_user_id' AND id = '$current_todo_id'");
    $stmt->execute();
    if ($stmt == 1) {
        $response = ['ok' => true];
    }
} else {
    http_response_code(500);
    echo(json_encode(['error' => 'Connection to database failed']));
    exit();
}
echo(json_encode($response));
$pdo = null;    // Close PDO connection
exit();

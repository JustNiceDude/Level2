<?php
require_once "headers.php";
require_once "database_connection.php";
// Get input content from front part
$input_content = json_decode(file_get_contents('php://input'), true);
$current_id = $input_content["id"];
settype($current_id, 'integer'); // Lead to integer type for SQL security requests
// Get id of registered user
session_start();
$current_user_id = $_SESSION['id'];
settype($current_user_id, 'integer'); // Lead to integer type for SQL security requests

// Delete current data from DB
$response = ['ok' => false];
if (isset($pdo)) {
    $stmt = $pdo->prepare("DELETE FROM items WHERE id='$current_id' AND user_id='$current_user_id'");
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
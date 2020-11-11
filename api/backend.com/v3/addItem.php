<?php
require_once "headers.php";
require_once "database_connection.php";
require_once "input_data_handler.php";
// Get input content from front part
$input_content = json_decode(file_get_contents('php://input'), true);
$text = $input_content['text'];
$text = input_data_handler($text);  // Prevent special chars that could be dangerous for SQL requests
// Check data for empty input
if ($text == null) {
    exit();
}
// Get id of registered user
session_start();
$user_id = $_SESSION['id'];
settype($current_user_id, 'integer'); // Lead to integer type for SQL security requests
// Insert new data into DB
if (isset($pdo)) {
    $stmt = $pdo->prepare("INSERT INTO items (text, checked, user_id) VALUES ('$text',0,'$user_id')");
    $stmt->execute();
} else {
    http_response_code(500);
    echo(json_encode(['error' => 'Connection to database failed']));
    exit();
}
$id_of_last_record = $pdo->lastInsertId();  // Get id of the last record
$pdo = null;    // Close PDO connection
echo json_encode(array("id" => $id_of_last_record));    // Output for front_end-part
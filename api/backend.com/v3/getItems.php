<?php
require_once "headers.php";
require_once "database_connection.php";
// Get id of registered user
session_start();
$current_user_id = $_SESSION['id'];
settype($current_user_id, 'integer'); // Lead to integer type for SQL security requests
// Build output data for current user
$output_array = array('items' => []);
if (isset($pdo)) {
    $stmt = $pdo->prepare("SELECT * FROM items");
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $row){
        if ($current_user_id == $row['user_id']) {
            $output_array['items'][] = array('id' => $row['id'], 'text' => $row['text'], 'checked' => boolval($row['checked']));
        }
    }
} else {
    http_response_code(500);
    echo(json_encode(['error' => 'Connection to database failed']));
    exit();
}
echo(json_encode($output_array));
$pdo = null;    // Close PDO connection
exit();

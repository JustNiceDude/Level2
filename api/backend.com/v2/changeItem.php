<?php
require_once "headers.php";
require_once "database_config.php";
// Get input content from front part
$input_content = json_decode(file_get_contents('php://input'), true);
$current_id = $input_content['id'];
$new_text = $input_content['text'];
$new_status = $input_content['checked'];
// Cast boolean value to int that will working for SQL
if ($new_status == true) {
    $new_status = 1;
} else {
    $new_status = 0;
}
// Make connection to MySQL database
$link = mysqli_connect(HOST, USER, PASSWORD);
if ($link == false) {
    die('Connection error: ' . mysqli_connect_error());
}
// Update current data in DB
$sql_request = "UPDATE test_api.items SET text = '$new_text', checked = '$new_status' WHERE id = '$current_id'";
$result = mysqli_query($link, $sql_request);
// Output for front_end-part
if ($result == false) {
    print "Invalid operation!";
} else {
    $output_array = ['ok' => true];
    echo(json_encode($output_array));
}
mysqli_close($link);
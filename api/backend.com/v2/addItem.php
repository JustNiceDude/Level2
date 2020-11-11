<?php
require_once "headers.php";
require_once "database_config.php";
// Get input content from front part
$input_content = json_decode(file_get_contents('php://input'), true);
$text = $input_content["text"];
// Check data for empty input
if ($text == null) {
    exit();
}
// Make connection to MySQL database
$link = mysqli_connect(HOST, USER, PASSWORD);
if ($link == false) {
    die('Connection error: ' . mysqli_connect_error());
}
// Insert new data into DB
$sql_request = "INSERT INTO test_api.items (text, checked) VALUES ('$text',0)";
mysqli_query($link, $sql_request);
// Insert id of the last record
$id_of_last_record = mysqli_insert_id($link);
$id_request = "INSERT INTO test_api.items (id) VALUES ('$id_of_last_record')";
mysqli_query($link, $id_request);
mysqli_close($link);
// Output for front_end-part
echo json_encode(array("id" => $id_of_last_record));

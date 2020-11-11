<?php
require_once "headers.php";
require_once "database_config.php";
// Get input content from front part
$input_content = json_decode(file_get_contents('php://input'), true);
$current_id = $input_content["id"];
// Make connection to MySQL database
$link = mysqli_connect(HOST, USER, PASSWORD);
if ($link == false) {
    die('Connection error: ' . mysqli_connect_error());
}
// Delete current data from DB
$sql_request = "DELETE FROM test_api.items WHERE id='$current_id'";
$result = mysqli_query($link, $sql_request);
// Output for front_end-part
if ($result == false) {
    print "Invalid operation!";
} else {
    $output_array = ['ok' => true];
    echo(json_encode($output_array));
}
mysqli_close($link);
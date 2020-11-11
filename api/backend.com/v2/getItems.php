<?php
require_once "headers.php";
require_once "database_config.php";
// Make connection to MySQL database
$link = mysqli_connect(HOST, USER, PASSWORD);
if ($link == false) {
    die('Connection error: ' . mysqli_connect_error());
}
// Send request to get all content from DB
$sql_request = 'SELECT * FROM test_api.items';
$result = mysqli_query($link, $sql_request);
//Build content to output
$output_array = array('items' => []);
while ($row = mysqli_fetch_array($result)) {
    $output_array['items'][] = array('id' => $row['id'], 'text' => $row['text'], 'checked' => boolval($row['checked']));
}
mysqli_close($link);
echo(json_encode($output_array));
exit();
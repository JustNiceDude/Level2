<?php
require_once "headers.php";
// Get input content from front part
$input_content = file_get_contents('php://input');
$array_of_input_content = json_decode($input_content, true);
// Check data for empty input
if($array_of_input_content["text"] == null){
    exit();
}
// Make new id for current todo
$new_id = file_get_contents('id.txt') + 1;
file_put_contents('id.txt', $new_id);
// Write inputted data to database
$database_content = file_get_contents('database.json');
$decoded_database = json_decode($database_content, true);
$dataToInsert = array("id" => $new_id, "text" => $array_of_input_content["text"], "checked" => false);
$decoded_database["items"][] = $dataToInsert;
file_put_contents('database.json', json_encode($decoded_database));
// Output for front_end response
$output_array = ['id' => $new_id];
echo json_encode($output_array);


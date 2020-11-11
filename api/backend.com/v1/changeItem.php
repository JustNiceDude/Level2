<?php
require_once "headers.php";
// Get input content from front part
$input_content = json_decode(file_get_contents('php://input'), true);
// Get content from database
$database_content = json_decode(file_get_contents('database.json'), true);
// Try to find end change some parameter if they are different with parameter from database
foreach ($database_content['items'] as $index => $current_todo) {
    if ($current_todo['id'] == $input_content['id']) {
        $database_content['items'][$index]['text'] = $input_content['text'];
        $database_content['items'][$index]['checked'] = $input_content['checked'];
    }
}
file_put_contents('database.json', json_encode($database_content));
// Output for front_end response
$output_array = ['ok' => true];
echo (json_encode($output_array));
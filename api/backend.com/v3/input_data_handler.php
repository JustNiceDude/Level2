<?php
function input_data_handler($input_data)
{
    $result = strip_tags($input_data);
    $result = trim($result);
    $result = htmlspecialchars($result);
    return $result;
}
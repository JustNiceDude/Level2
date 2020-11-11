<?php
require_once "headers.php";
$dataFromDB = file_get_contents('database.json');
echo $dataFromDB;
exit();
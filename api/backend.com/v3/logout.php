<?php
session_start();
require_once 'headers.php';
session_unset();
session_destroy();
echo json_encode(array("ok" => true));
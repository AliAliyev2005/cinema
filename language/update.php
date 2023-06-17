<?php
header('Content-Type: application/json');
require_once "../conn.php";

$language = json_decode(file_get_contents('php://input'));
$response = new stdClass();

if (empty($language->name)) {
    $response->code = 100;
    $response->message = "Name is required";
    die(json_encode($response));
}

if (empty($language->code)) {
    $response->code = 100;
    $response->message = "Code is required";
    die(json_encode($response));
}

$sql = "INSERT INTO `languages` (`name`, `code`) VALUES (?, ?)";
$query = $conn->prepare($sql);
$query->bind_param("ss", $language->name, $language->code);

if ($query->execute() === TRUE) {
    $response->code = 0;
    $response->message = "Success";
} else {
    $response->code = 200;
    $response->message = "Error";
}

echo(json_encode($response));
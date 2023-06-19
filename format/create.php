<?php
header('Content-Type: application/json');
require_once "../conn.php";

$format = json_decode(file_get_contents('php://input'));
$response = new stdClass();

if (empty($format->name)) {
    $response->code = 100;
    $response->message = "Name is required";
    die(json_encode($response));
}

$sql = "INSERT INTO `formats` (`name`) VALUES (?)";
$query = $conn->prepare($sql);
$query->bind_param("s", $format->name);

if ($query->execute() === TRUE) {
    $response->code = 0;
    $response->message = "Success";
} else {
    $response->code = 200;
    $response->message = "Error";
}

echo(json_encode($response));
<?php
header('Content-Type: application/json');
require_once "../conn.php";

$genre = json_decode(file_get_contents('php://input'));
$response = new stdClass();

if (empty($genre->name)) {
    $response->code = 100;
    $response->message = "Name is required";
    die(json_encode($response));
}

$sql = "DELETE FROM `genres` WHERE `name` = ?";
$query = $conn->prepare($sql);
$query->bind_param("s", $genre->name);

if ($query->execute() === TRUE) {
    $response->code = 0;
    $response->message = "Success";
} else {
    $response->code = 200;
    $response->message = "Error";
}

echo(json_encode($response));
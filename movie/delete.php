<?php
header('Content-Type: application/json');
require_once "../conn.php";

$movie = json_decode(file_get_contents('php://input'));
$response = new stdClass();

if (empty($movie->id)) {
    $response->code = 100;
    $response->message = "Id is required";
    die(json_encode($response));
}

$sql = "DELETE FROM movies WHERE `id` = ?";
$query = $conn->prepare($sql);
$query->bind_param("i", $movie->id);

if ($query->execute() === TRUE) {
    $response->code = 0;
    $response->message = "Success";
} else {
    $response->code = 200;
    $response->message = "Error";
}

echo(json_encode($response));
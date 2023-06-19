<?php
header('Content-Type: application/json');
require_once "../conn.php";

$subtitle = json_decode(file_get_contents('php://input'));
$response = new stdClass();

if (empty($subtitle->name)) {
    $response->code = 100;
    $response->message = "Name is required";
    die(json_encode($response));
}

if (empty($subtitle->id)) {
    $response->code = 100;
    $response->message = "Id is required";
    die(json_encode($response));
}

if (empty($subtitle->code)) {
    $response->code = 100;
    $response->message = "Code is required";
    die(json_encode($response));
}

$sql = "UPDATE subtitles SET `name` = ?, `code` = ?  WHERE `id` = ?";
$query = $conn->prepare($sql);
$query->bind_param("ssi", $subtitle->name, $subtitle->code, $language->id);

if ($query->execute() === TRUE) {
    $response->code = 0;
    $response->message = "Success";
} else {
    $response->code = 200;
    $response->message = "Error";
}

echo(json_encode($response));
<?php
header('Content-Type: application/json');
require_once "../conn.php";

$response = new stdClass();

$sql = "SELECT * FROM `languages`";
$result = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);

if (count($result) > 0) {
    $response->code = 0;
    $response->message = "Success";
    $response->data = $result;
} else {
    $response->code = 200;
    $response->message = "Error";
}

echo(json_encode($response));
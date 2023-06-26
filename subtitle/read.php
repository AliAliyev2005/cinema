<?php
header('Content-Type: application/json');
require_once "../conn.php";

$response = new stdClass();

$sql = "SELECT * FROM `subtitles`";
$result = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);

$response->code = 0;
$response->message = "Success";
$response->data = $result;

echo(json_encode($response));
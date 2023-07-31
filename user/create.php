<?php
header('Content-Type: application/json');
require_once "../conn.php";

$user = json_decode(file_get_contents('php://input'));
$response = new stdClass();

if (empty($user->name)) {
    $response->name = 100;
    $response->message = "Name is required";
    die(json_encode($response));
}

if (empty($user->surname)) {
    $response->surname = 100;
    $response->message = "surname is required";
    die(json_encode($response));
}

if (empty($user->email)) {
    $response->email = 100;
    $response->message = "email is required";
    die(json_encode($response));
}

if (empty($user->password)) {
    $response->password = 100;
    $response->message = "password is required";
    die(json_encode($response));
}

$sql = "INSERT INTO `users` (`name`, `email`, `password`, `surname`) VALUES (?, ?, ?, ?)";
$query = $conn->prepare($sql);
$query->bind_param("ssss", $user->name, $user->email, md5($user->password), $user->surname);

if ($query->execute() === TRUE) {
    $response->code = 0;
    $response->message = "Success";
} else {
    $response->code = 200;
    $response->message = "Error";
}

echo(json_encode($response));
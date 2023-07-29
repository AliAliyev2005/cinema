<?php
header('Content-Type: application/json');
require_once "../conn.php";

$movie = json_decode(file_get_contents('php://input'));
$response = new stdClass();

if (empty($movie->id)) {
    $response->code = 100;
    $response->message = "id is required";
    die(json_encode($response));
}

if (empty($movie->name)) {
    $response->code = 100;
    $response->message = "name is required";
    die(json_encode($response));
}

if (empty($movie->description)) {
    $response->code = 100;
    $response->message = "description is required";
    die(json_encode($response));
}

if (empty($movie->poster)) {
    $response->code = 100;
    $response->message = "poster is required";
    die(json_encode($response));
}

if (empty($movie->trailer)) {
    $response->code = 100;
    $response->message = "trailer is required";
    die(json_encode($response));
}

if (empty($movie->age_limit)) {
    $response->code = 100;
    $response->message = "age_limit is required";
    die(json_encode($response));
}

if (empty($movie->duration)) {
    $response->code = 100;
    $response->message = "duration is required";
    die(json_encode($response));
}

if (empty($movie->country)) {
    $response->code = 100;
    $response->message = "country is required";
    die(json_encode($response));
}

if (empty($movie->director)) {
    $response->code = 100;
    $response->message = "director is required";
    die(json_encode($response));
}

$sql = "UPDATE movies SET  `name` = ?, `description` = ?, `poster` = ?, `trailer` = ?, `age_limit` = ?, `duration` = ?, `country` = ?, `director` = ?  WHERE `id` = ?;";
$query = $conn->prepare($sql);
$query->bind_param("ssssiissi", $movie->name, $movie->description, $movie->poster, $movie->trailer, $movie->age_limit, $movie->duration, $movie->country, $movie->director, $movie->id);
$query->execute();

$ids = array_column(array_values((array)$movie->subtitles), "id");
foreach ($ids as $id) {
    $sql = "UPDATE movie_subtitle SET subtitle_id = ? WHERE `movie_id` = ?;";
    $query = $conn->prepare($sql);
    $query->bind_param("ii", $id, $movie->id);
    $query->execute();
}

$ids = array_column(array_values((array)$movie->languages), "id");
foreach ($ids as $id) {
    $sql = "UPDATE movie_language SET language_id = ? WHERE `movie_id` = ?;";
    $query = $conn->prepare($sql);
    $query->bind_param("ii", $id, $movie->id);
    $query->execute();
}

$ids = array_column(array_values((array)$movie->genres), "id");
foreach ($ids as $id) {
    $sql = "UPDATE movie_genre SET genre_id = ? WHERE `movie_id` = ?;";
    $query = $conn->prepare($sql);
    $query->bind_param("ii", $id, $movie->id);
    $query->execute();
}

$ids = array_column(array_values((array)$movie->formats), "id");
foreach ($ids as $id) {
    $sql = "UPDATE movie_format SET format_id = ? WHERE `movie_id` = ?;";
    $query = $conn->prepare($sql);
    $query->bind_param("ii", $id, $movie->id);
    $query->execute();
}

$response->code = 0;
$response->message = "Success";

echo(json_encode($response));
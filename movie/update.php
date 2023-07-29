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


// Delete old subtitles
$sql = "DELETE FROM movie_subtitle WHERE `movie_id` = ?";
$query = $conn->prepare($sql);
$query->bind_param("i", $movie->id);
$query->execute();

// Insert new subtitles
$ids = $movie->subtitles;
foreach ($ids as $id) {
    $sql = "INSERT INTO movie_subtitle (`movie_id`, `subtitle_id`) VALUES (?, ?);";
    $query = $conn->prepare($sql);
    $query->bind_param("ii", $movie->id, $id);
    $query->execute();
}


// Delete old languages
$sql = "DELETE FROM movie_language WHERE `movie_id` = ?";
$query = $conn->prepare($sql);
$query->bind_param("i", $movie->id);
$query->execute();

// Insert new languages
$ids = $movie->languages;
foreach ($ids as $id) {
    $sql = "INSERT INTO movie_language (`movie_id`, `language_id`) VALUES (?, ?);";
    $query = $conn->prepare($sql);
    $query->bind_param("ii", $movie->id, $id);
    $query->execute();
}


// Delete old genres
$sql = "DELETE FROM movie_genre WHERE `movie_id` = ?";
$query = $conn->prepare($sql);
$query->bind_param("i", $movie->id);
$query->execute();

// Insert new genres
$ids = $movie->genres;
foreach ($ids as $id) {
    $sql = "INSERT INTO movie_genre (`movie_id`, `genre_id`) VALUES (?, ?);";
    $query = $conn->prepare($sql);
    $query->bind_param("ii", $movie->id, $id);
    $query->execute();
}


// Delete old formats
$sql = "DELETE FROM movie_format WHERE `movie_id` = ?";
$query = $conn->prepare($sql);
$query->bind_param("i", $movie->id);
$query->execute();

// Insert new formats
$ids = $movie->formats;
foreach ($ids as $id) {
    $sql = "INSERT INTO movie_format (`movie_id`, `format_id`) VALUES (?, ?);";
    $query = $conn->prepare($sql);
    $query->bind_param("ii", $movie->id, $id);
    $query->execute();
}

$response->code = 0;
$response->message = "Success";

echo(json_encode($response));
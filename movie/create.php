<?php
header('Content-Type: application/json');
require_once "../conn.php";

$movie = json_decode(file_get_contents('php://input'));
$response = new stdClass();

if (empty($movie->name)) {
    $response->code = 100;
    $response->message = "Name is required";
    die(json_encode($response));
}

// Insert Movie
$sql = "INSERT INTO `movies` (`name`, `description`, `poster`, `trailer`, `age_limit`, `country`, `director`, `duration`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$query = $conn->prepare($sql);
$query->bind_param("ssssissi", $movie->name, $movie->description, $movie->poster, $movie->trailer, $movie->ageLimit, $movie->country, $movie->director, $movie->duration);
$query->execute();
$movie_id = $query->insert_id;

// Insert Movie Languages
foreach ($movie->languages as $language_id) {
    $sql = "INSERT INTO `movie_language` (`movie_id`, `language_id`) VALUES (?, ?)";
    $query = $conn->prepare($sql);
    $query->bind_param("ii", $movie_id, $language_id);
    $query->execute();
}

// Insert Movie Genres
foreach ($movie->genres as $genre_id) {
    $sql = "INSERT INTO `movie_genre` (`movie_id`, `genre_id`) VALUES (?, ?)";
    $query = $conn->prepare($sql);
    $query->bind_param("ii", $movie_id, $genre_id);
    $query->execute();
}

// Insert Movie Subtitles
foreach ($movie->subtitles as $subtitle_id) {
    $sql = "INSERT INTO `movie_subtitle` (`movie_id`, `subtitle_id`) VALUES (?, ?)";
    $query = $conn->prepare($sql);
    $query->bind_param("ii", $movie_id, $subtitle_id);
    $query->execute();
}

// Insert Movie Formats
foreach ($movie->formats as $format_id) {
    $sql = "INSERT INTO `movie_format` (`movie_id`, `format_id`) VALUES (?, ?)";
    $query = $conn->prepare($sql);
    $query->bind_param("ii", $movie_id, $format_id);
    $query->execute();
}

$response->code = 0;
$response->message = "Success";

echo(json_encode($response));
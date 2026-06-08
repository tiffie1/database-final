<?php
require_once "db.php";

$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    try {

        if ($_POST["action"] == "insert_media") {
            $sql = "INSERT INTO Media 
                    (Title, MediaType, MinMinutes, MaxMinutes, IMDBScore, ReleaseDate)
                    VALUES 
                    (:title, :mediaType, :minMinutes, :maxMinutes, :imdbScore, :releaseDate)";

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ":title" => $_POST["title"],
                ":mediaType" => $_POST["mediaType"],
                ":minMinutes" => $_POST["minMinutes"],
                ":maxMinutes" => $_POST["maxMinutes"],
                ":imdbScore" => $_POST["imdbScore"],
                ":releaseDate" => $_POST["releaseDate"]
            ]);

            $message = "El contenido fue insertado correctamente.";
            $messageType = "success";
        }

        if ($_POST["action"] == "update_media") {
            $sql = "UPDATE Media
                    SET Title = :title,
                        IMDBScore = :imdbScore
                    WHERE MediaID = :mediaID";

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ":title" => $_POST["title"],
                ":imdbScore" => $_POST["imdbScore"],
                ":mediaID" => $_POST["mediaID"]
            ]);

            if ($stmt->rowCount() > 0) {
                $message = "El contenido fue modificado correctamente.";
                $messageType = "success";
            } else {
                $message = "No se encontró un contenido con ese MediaID.";
                $messageType = "error";
            }
        }

        if ($_POST["action"] == "insert_media_genre") {
            $sql = "INSERT INTO Has_Genre (MediaID, GenreID)
                    VALUES (:mediaID, :genreID)";

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ":mediaID" => $_POST["mediaID"],
                ":genreID" => $_POST["genreID"]
            ]);

            $message = "La relación entre Media y Genre fue insertada correctamente.";
            $messageType = "success";
        }

    } catch (PDOException $e) {
        $message = "Alerta: ocurrió una violación de integridad o error en la base de datos. " . $e->getMessage();
        $messageType = "error";
    }
}
?>
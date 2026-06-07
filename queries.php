<?php
require_once "db.php";

$queries = [
    [
        "titulo" => "Query 1: Mostrar películas y series",
        "descripcion" => "Esta consulta muestra información básica de los contenidos registrados en la tabla Media. Se usa LIMIT para mostrar solo algunos resultados.",
        "sql" => "
            SELECT MediaID, Title, MediaType, IMDbScore, ReleaseDate
            FROM Media
            LIMIT 10
        "
    ],

    [
        "titulo" => "Query 2: JOIN de tres tablas",
        "descripcion" => "Esta consulta usa JOIN para conectar Media, Has_Genre y Genre. Muestra cada contenido con su género.",
        "sql" => "
            SELECT Media.Title, Media.MediaType, Genre.GenreName
            FROM Media
            JOIN Has_Genre ON Media.MediaID = Has_Genre.MediaID
            JOIN Genre ON Has_Genre.GenreID = Genre.GenreID
            LIMIT 10
        "
    ],

    [
        "titulo" => "Query 3: Cantidad de contenidos por tipo",
        "descripcion" => "Esta consulta usa GROUP BY para contar cuántas películas y series hay en la base de datos.",
        "sql" => "
            SELECT MediaType, COUNT(*) AS Total
            FROM Media
            GROUP BY MediaType
            
        "
    ],

    [
        "titulo" => "Query 4: Géneros con más de un contenido",
        "descripcion" => "Esta consulta usa GROUP BY y HAVING para mostrar los géneros que aparecen en más de un contenido.",
        "sql" => "
            SELECT Genre.GenreName, COUNT(Has_Genre.MediaID) AS TotalContent
            FROM Genre
            JOIN Has_Genre ON Genre.GenreID = Has_Genre.GenreID
            GROUP BY Genre.GenreName
            HAVING COUNT(Has_Genre.MediaID) > 1
            
        "
    ],

    [
    "titulo" => "Query 5: Contenidos con puntuación mayor al promedio",
    "descripcion" => "Esta consulta usa una subconsulta para mostrar contenidos cuyo IMDBScore es mayor al promedio general. También muestra el promedio usado para la comparación.",
    "sql" => "
        SELECT 
            Title, 
            MediaType, 
            IMDBScore,
            (SELECT ROUND(AVG(IMDBScore), 2) FROM Media) AS AverageIMDbScore
        FROM Media
        WHERE IMDBScore > (
            SELECT AVG(IMDBScore)
            FROM Media
        )
        LIMIT 10
    "
]
];
?>
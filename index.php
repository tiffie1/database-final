<?php
//require_once "queries.php";

$projectName = "Diseño de Base de Datos para Películas y Series";
$course = "COMP4018-030";
$professor = "Prof. Cesar F. Bolanos";
$student1 = "Derek Morales Colón";
$student2 = "Emilia Couret Villafañe";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title><?php echo $projectName; ?></title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <header>
        <h1><?php echo $projectName; ?></h1>
        <p><?php echo $course; ?> | <?php echo $professor; ?></p>
        <p><?php echo $student1; ?> y <?php echo $student2; ?></p>
    </header>

    <nav>
        <a href="#entidades">Entidades</a>
        <a href="#atributos">Atributos</a>
        <a href="#modelo-relacional">Modelo Relacional</a>
        <a href="#relaciones">Relaciones</a>
        <a href="#herencia">MediaType</a>
        <a href="#mejoras">Mejoras</a>
        <a href="#conclusion">Conclusión</a>
        <a href="queries.php">
            <font color='#256BEF'><u>Consultas y Datos ↗</u></font>
        </a>
    </nav>



    <main>

        <section id="diagrama">
            <h2>Diagrama Entidad-Relación</h2>
            <p>
                El siguiente diagrama muestra la estructura general de la base de datos. La entidad
                principal es <strong>Media</strong>, ya que representa cada película o serie dentro
                del catálogo. Las demás entidades se conectan con Media para añadir información
                adicional.
            </p>
            <div class="diagram">
                <img src="assets/movie-ER.svg" alt="Diagrama Entidad-Relación">
            </div>
            <p>
                En el diagrama, las entidades aparecen como tablas, las relaciones aparecen con
                diamantes y las conexiones muestran cómo se relacionan los datos.
            </p>
        </section>

        <p>
            Este proyecto presenta el diseño de una base de datos para organizar información
            sobre películas y series. La base de datos permite guardar datos importantes como
            el título, tipo de contenido, duración, puntuaciones, premios, fecha de estreno,
            actores, directores, escritores, géneros, idiomas, países, enlaces y trailers.
        </p>

        <p>
            Para representar esta información se creó un diagrama Entidad-Relación. Este
            diagrama ayuda a visualizar las entidades principales del sistema y la forma en
            que se relacionan entre sí.
        </p>
        </section>

        <section id="objetivo">
            <h2>Objetivo del proyecto</h2>

            <p>
                El objetivo principal de este proyecto es diseñar una base de datos clara y
                organizada para un catálogo de películas y series. También se busca evitar la
                repetición innecesaria de datos y facilitar la conversión del diagrama E/R a un
                modelo relacional.
            </p>
        </section>

        <section id="entidades">
            <h2>Entidades principales</h2>

            <table>
                <tr>
                    <th>Entidad</th>
                    <th>Descripción</th>
                </tr>

                <tr>
                    <td>Media</td>
                    <td>Entidad principal. Representa una película o serie dentro del catálogo.</td>
                </tr>

                <tr>
                    <td>Genre</td>
                    <td>Guarda los géneros del contenido, como drama, acción, comedia o terror.</td>
                </tr>

                <tr>
                    <td>Tag</td>
                    <td>Guarda etiquetas o palabras clave relacionadas con el contenido.</td>
                </tr>

                <tr>
                    <td>Language</td>
                    <td>Representa los idiomas disponibles o asociados al contenido.</td>
                </tr>

                <tr>
                    <td>Country</td>
                    <td>Representa los países donde el contenido está disponible o relacionado.</td>
                </tr>

                <tr>
                    <td>Actor</td>
                    <td>Guarda los actores que participan en una película o serie.</td>
                </tr>

                <tr>
                    <td>Director</td>
                    <td>Guarda los directores asociados al contenido.</td>
                </tr>

                <tr>
                    <td>Writer</td>
                    <td>Guarda los escritores o guionistas del contenido.</td>
                </tr>

                <tr>
                    <td>ProductionHouse</td>
                    <td>Representa las casas productoras asociadas con cada contenido.</td>
                </tr>

                <tr>
                    <td>MediaLinks</td>
                    <td>Guarda enlaces, imágenes y poster relacionados con la película o serie.</td>
                </tr>

                <tr>
                    <td>MediaTrailer</td>
                    <td>Guarda información sobre el trailer del contenido.</td>
                </tr>
            </table>
        </section>

        <section id="atributos">
            <h2>Descripción de atributos</h2>

            <p>
                Esta sección describe los atributos más importantes de las entidades principales
                y de las relaciones del modelo relacional. Los atributos permiten identificar,
                clasificar y conectar la información almacenada en la base de datos.
            </p>

            <h3>Atributos de la entidad Media</h3>

            <table>
                <tr>
                    <th>Atributo</th>
                    <th>Descripción</th>
                </tr>

                <tr>
                    <td>MediaID</td>
                    <td>Llave primaria que identifica de manera única cada película o serie.</td>
                </tr>

                <tr>
                    <td>Title</td>
                    <td>Nombre o título del contenido.</td>
                </tr>

                <tr>
                    <td>MediaType</td>
                    <td>Indica si el contenido es una película o una serie.</td>
                </tr>

                <tr>
                    <td>MinMinutes</td>
                    <td>Duración mínima del contenido en minutos.</td>
                </tr>

                <tr>
                    <td>MaxMinutes</td>
                    <td>Duración máxima del contenido en minutos.</td>
                </tr>

                <tr>
                    <td>HiddenGemScore</td>
                    <td>Puntuación que representa qué tan recomendado o valioso puede ser el contenido.</td>
                </tr>

                <tr>
                    <td>ViewRating</td>
                    <td>Clasificación del contenido según la audiencia recomendada.</td>
                </tr>

                <tr>
                    <td>IMDbScore</td>
                    <td>Puntuación del contenido según IMDb.</td>
                </tr>

                <tr>
                    <td>RottenTomatoesScore</td>
                    <td>Puntuación del contenido según Rotten Tomatoes.</td>
                </tr>

                <tr>
                    <td>MetacriticScore</td>
                    <td>Puntuación del contenido según Metacritic.</td>
                </tr>

                <tr>
                    <td>AwardsReceived</td>
                    <td>Cantidad de premios recibidos por el contenido.</td>
                </tr>

                <tr>
                    <td>AwardsNominated</td>
                    <td>Cantidad de nominaciones recibidas por el contenido.</td>
                </tr>

                <tr>
                    <td>BoxOffice</td>
                    <td>Información relacionada con ganancias o taquilla.</td>
                </tr>

                <tr>
                    <td>ReleaseDate</td>
                    <td>Fecha original de estreno del contenido.</td>
                </tr>

                <tr>
                    <td>NetflixReleaseDate</td>
                    <td>Fecha en que el contenido fue añadido a Netflix.</td>
                </tr>

                <tr>
                    <td>Summary</td>
                    <td>Resumen o descripción breve del contenido.</td>
                </tr>

                <tr>
                    <td>IMDbVotes</td>
                    <td>Cantidad de votos registrados en IMDb.</td>
                </tr>
            </table>

            <h3>Atributos de entidades secundarias</h3>

            <table>
                <tr>
                    <th>Entidad</th>
                    <th>Atributos</th>
                    <th>Descripción</th>
                </tr>

                <tr>
                    <td>Genre</td>
                    <td>GenreID, GenreName</td>
                    <td>Guarda los géneros asociados al contenido.</td>
                </tr>

                <tr>
                    <td>Tag</td>
                    <td>TagID, TagName</td>
                    <td>Guarda etiquetas o palabras clave relacionadas con el contenido.</td>
                </tr>

                <tr>
                    <td>Language</td>
                    <td>LanguageID, LanguageName</td>
                    <td>Guarda los idiomas asociados al contenido.</td>
                </tr>

                <tr>
                    <td>Country</td>
                    <td>CountryID, CountryName</td>
                    <td>Guarda los países donde el contenido está disponible o relacionado.</td>
                </tr>

                <tr>
                    <td>Director</td>
                    <td>DirectorID, DirectorName</td>
                    <td>Guarda los directores del contenido.</td>
                </tr>

                <tr>
                    <td>Writer</td>
                    <td>WriterID, WriterName</td>
                    <td>Guarda los escritores o guionistas del contenido.</td>
                </tr>

                <tr>
                    <td>Actor</td>
                    <td>ActorID, ActorName</td>
                    <td>Guarda los actores que participan en el contenido.</td>
                </tr>

                <tr>
                    <td>ProductionHouse</td>
                    <td>ProductionHouseID, ProductionHouseName</td>
                    <td>Guarda las casas productoras asociadas al contenido.</td>
                </tr>

                <tr>
                    <td>MediaLinks</td>
                    <td>LinkID, NetflixLink, IMDbLink, Image, Poster</td>
                    <td>Guarda enlaces e imágenes relacionados con el contenido.</td>
                </tr>

                <tr>
                    <td>MediaTrailer</td>
                    <td>TrailerID, IMDbTrailer, TrailerSite</td>
                    <td>Guarda información relacionada con el trailer del contenido.</td>
                </tr>
                <section id="queries">

                </section>



            </table>

            <h3>Atributos de relaciones en el modelo relacional</h3>

            <p>
                Las relaciones de muchos a muchos se convierten en tablas intermedias.
                Estas tablas utilizan llaves foráneas para conectar las entidades principales.
            </p>

            <table>
                <tr>
                    <th>Tabla de relación</th>
                    <th>Atributos</th>
                    <th>Descripción</th>
                </tr>

                <tr>
                    <td>Media_Genre</td>
                    <td>MediaID, GenreID</td>
                    <td>Conecta cada contenido con sus géneros.</td>
                </tr>

                <tr>
                    <td>Media_Tag</td>
                    <td>MediaID, TagID</td>
                    <td>Conecta cada contenido con sus etiquetas.</td>
                </tr>

                <tr>
                    <td>Media_Language</td>
                    <td>MediaID, LanguageID</td>
                    <td>Conecta cada contenido con sus idiomas.</td>
                </tr>

                <tr>
                    <td>Media_Country</td>
                    <td>MediaID, CountryID</td>
                    <td>Conecta cada contenido con los países relacionados.</td>
                </tr>

                <tr>
                    <td>Media_Director</td>
                    <td>MediaID, DirectorID</td>
                    <td>Conecta cada contenido con sus directores.</td>
                </tr>

                <tr>
                    <td>Media_Writer</td>
                    <td>MediaID, WriterID</td>
                    <td>Conecta cada contenido con sus escritores.</td>
                </tr>

                <tr>
                    <td>Media_Actor</td>
                    <td>MediaID, ActorID</td>
                    <td>Conecta cada contenido con sus actores.</td>
                </tr>

                <tr>
                    <td>Media_ProductionHouse</td>
                    <td>MediaID, ProductionHouseID</td>
                    <td>Conecta cada contenido con sus casas productoras.</td>
                </tr>
            </table>
        </section>
        <section id="modelo-relacional">
    <h2>Modelo Relacional</h2>

    <p>
        El modelo relacional muestra cómo las entidades y relaciones del diagrama
        Entidad-Relación se convierten en tablas. En este modelo se identifican
        las llaves primarias, las llaves foráneas y las tablas intermedias necesarias
        para representar las relaciones de muchos a muchos.
    </p>

    <h3>Entidades principales</h3>

    <table>
        <tr>
            <th>Tabla</th>
            <th>Atributos</th>
            <th>Explicación</th>
        </tr>

        <tr>
            <td>Media</td>
            <td>
                <strong>MediaID PK</strong>, Title, MediaType, MinMinutes, MaxMinutes,
                HiddenGemScore, ViewRating, IMDbScore, RottenTomatoesScore,
                MetacriticScore, AwardsReceived, AwardsNominated, BoxOffice,
                ReleaseDate, NetflixReleaseDate, Summary, IMDbVotes
            </td>
            <td>
                Es la tabla principal del sistema. Representa cada película o serie
                registrada en la base de datos.
            </td>
        </tr>

        <tr>
            <td>MediaLinks</td>
            <td>
                <strong>LinkID PK</strong>, NetflixLink, IMDbLink, Image, Poster
            </td>
            <td>
                Almacena enlaces, imágenes y pósters relacionados con el contenido.
            </td>
        </tr>

        <tr>
            <td>MediaTrailer</td>
            <td>
                <strong>TrailerID PK</strong>, IMDbTrailer, TrailerSite
            </td>
            <td>
                Almacena la información relacionada con el trailer de una película o serie.
            </td>
        </tr>

        <tr>
            <td>Genre</td>
            <td><strong>GenreID PK</strong>, GenreName</td>
            <td>Guarda los géneros del contenido.</td>
        </tr>

        <tr>
            <td>Tag</td>
            <td><strong>TagID PK</strong>, TagName</td>
            <td>Guarda etiquetas o palabras clave asociadas al contenido.</td>
        </tr>

        <tr>
            <td>Language</td>
            <td><strong>LanguageID PK</strong>, LanguageName</td>
            <td>Guarda los idiomas relacionados con el contenido.</td>
        </tr>

        <tr>
            <td>Country</td>
            <td><strong>CountryID PK</strong>, CountryName</td>
            <td>Guarda los países donde el contenido está disponible o relacionado.</td>
        </tr>

        <tr>
            <td>Director</td>
            <td><strong>DirectorID PK</strong>, DirectorName</td>
            <td>Guarda los directores asociados al contenido.</td>
        </tr>

        <tr>
            <td>Writer</td>
            <td><strong>WriterID PK</strong>, WriterName</td>
            <td>Guarda los escritores o guionistas asociados al contenido.</td>
        </tr>

        <tr>
            <td>Actor</td>
            <td><strong>ActorID PK</strong>, ActorName</td>
            <td>Guarda los actores que participan en el contenido.</td>
        </tr>

        <tr>
            <td>ProductionHouse</td>
            <td><strong>ProductionHouseID PK</strong>, ProductionHouseName</td>
            <td>Guarda las casas productoras asociadas al contenido.</td>
        </tr>
    </table>

    <h3>Tablas intermedias para relaciones muchos a muchos</h3>

    <p>
        Las siguientes tablas representan relaciones muchos a muchos. En estas tablas,
        los atributos funcionan como llaves foráneas y también forman una llave primaria
        compuesta. Esto evita repetir la misma relación más de una vez.
    </p>

    <table>
        <tr>
            <th>Tabla de relación</th>
            <th>Atributos</th>
            <th>Referencias</th>
        </tr>

        <tr>
            <td>Has_Genre</td>
            <td><strong>MediaID PK/FK</strong>, <strong>GenreID PK/FK</strong></td>
            <td>
                MediaID referencia a Media.MediaID.<br>
                GenreID referencia a Genre.GenreID.
            </td>
        </tr>

        <tr>
            <td>Has_Tag</td>
            <td><strong>MediaID PK/FK</strong>, <strong>TagID PK/FK</strong></td>
            <td>
                MediaID referencia a Media.MediaID.<br>
                TagID referencia a Tag.TagID.
            </td>
        </tr>

        <tr>
            <td>Has_Language</td>
            <td><strong>MediaID PK/FK</strong>, <strong>LanguageID PK/FK</strong></td>
            <td>
                MediaID referencia a Media.MediaID.<br>
                LanguageID referencia a Language.LanguageID.
            </td>
        </tr>

        <tr>
            <td>Available_In</td>
            <td><strong>MediaID PK/FK</strong>, <strong>CountryID PK/FK</strong></td>
            <td>
                MediaID referencia a Media.MediaID.<br>
                CountryID referencia a Country.CountryID.
            </td>
        </tr>

        <tr>
            <td>Directs</td>
            <td><strong>MediaID PK/FK</strong>, <strong>DirectorID PK/FK</strong></td>
            <td>
                MediaID referencia a Media.MediaID.<br>
                DirectorID referencia a Director.DirectorID.
            </td>
        </tr>

        <tr>
            <td>Writes</td>
            <td><strong>MediaID PK/FK</strong>, <strong>WriterID PK/FK</strong></td>
            <td>
                MediaID referencia a Media.MediaID.<br>
                WriterID referencia a Writer.WriterID.
            </td>
        </tr>

        <tr>
            <td>Acts_In</td>
            <td><strong>MediaID PK/FK</strong>, <strong>ActorID PK/FK</strong></td>
            <td>
                MediaID referencia a Media.MediaID.<br>
                ActorID referencia a Actor.ActorID.
            </td>
        </tr>

        <tr>
            <td>Produces</td>
            <td><strong>MediaID PK/FK</strong>, <strong>ProductionHouseID PK/FK</strong></td>
            <td>
                MediaID referencia a Media.MediaID.<br>
                ProductionHouseID referencia a ProductionHouse.ProductionHouseID.
            </td>
        </tr>
    </table>

    <h3>Relaciones uno a uno opcionales</h3>

    <p>
        Las relaciones con enlaces y trailers se consideran uno a uno opcionales,
        ya que un contenido puede tener enlaces o trailer asociados, pero no necesariamente
        todos los contenidos deben tenerlos desde el inicio.
    </p>

    <table>
        <tr>
            <th>Tabla de relación</th>
            <th>Atributos</th>
            <th>Explicación</th>
        </tr>

        <tr>
            <td>Has_Link</td>
            <td><strong>MediaID PK/FK</strong>, <strong>LinkID FK UNIQUE</strong></td>
            <td>
                MediaID referencia a Media.MediaID.<br>
                LinkID referencia a MediaLinks.LinkID.<br>
                Esta tabla conecta cada contenido con sus enlaces e imágenes.
            </td>
        </tr>

        <tr>
            <td>Has_Trailer</td>
            <td><strong>MediaID PK/FK</strong>, <strong>TrailerID FK UNIQUE</strong></td>
            <td>
                MediaID referencia a Media.MediaID.<br>
                TrailerID referencia a MediaTrailer.TrailerID.<br>
                Esta tabla conecta cada contenido con su trailer.
            </td>
        </tr>
    </table>

    <h3>Herencia mediante MediaType</h3>

    <p>
        La base de datos utiliza single-table inheritance, también conocido como STI.
        Esto significa que las películas y las series se almacenan en una misma tabla
        llamada <strong>Media</strong>. Para distinguir entre ambos tipos de contenido,
        se utiliza el atributo <strong>MediaType</strong>.
    </p>

    <p>
        Si MediaType tiene el valor <strong>Movie</strong>, el registro representa una película.
        Si MediaType tiene el valor <strong>Series</strong>, el registro representa una serie.
        Esta estrategia es adecuada porque ambos tipos de contenido comparten los mismos
        atributos principales en el diseño actual.
    </p>
</section>

        <section id="relaciones">
            <h2>Relaciones principales</h2>

            <p>
                Las relaciones indican cómo se conectan las entidades. Muchas relaciones son de
                muchos a muchos porque una película o serie puede tener varios actores, géneros,
                idiomas o países, y esos mismos elementos pueden aparecer en muchos contenidos.
            </p>

            <table>
                <tr>
                    <th>Relación</th>
                    <th>Entidades conectadas</th>
                    <th>Explicación</th>
                </tr>

                <tr>
                    <td>Has_Genre</td>
                    <td>Media y Genre</td>
                    <td>Una película o serie puede tener varios géneros.</td>
                </tr>

                <tr>
                    <td>Has_Tag</td>
                    <td>Media y Tag</td>
                    <td>Un contenido puede tener varias etiquetas.</td>
                </tr>

                <tr>
                    <td>Acts_In</td>
                    <td>Media y Actor</td>
                    <td>Un actor puede participar en varios contenidos y un contenido puede tener varios actores.</td>
                </tr>

                <tr>
                    <td>Directs</td>
                    <td>Media y Director</td>
                    <td>Relaciona una película o serie con sus directores.</td>
                </tr>

                <tr>
                    <td>Writes</td>
                    <td>Media y Writer</td>
                    <td>Relaciona una película o serie con sus escritores.</td>
                </tr>

                <tr>
                    <td>Produces</td>
                    <td>Media y ProductionHouse</td>
                    <td>Relaciona el contenido con las casas productoras.</td>
                </tr>

                <tr>
                    <td>Available_In</td>
                    <td>Media y Country</td>
                    <td>Indica los países donde el contenido está disponible o relacionado.</td>
                </tr>

                <tr>
                    <td>Has_Language</td>
                    <td>Media y Language</td>
                    <td>Indica los idiomas asociados con el contenido.</td>
                </tr>

                <tr>
                    <td>Has_Link</td>
                    <td>Media y MediaLinks</td>
                    <td>Relaciona el contenido con sus enlaces e imágenes.</td>
                </tr>

                <tr>
                    <td>Has_Trailer</td>
                    <td>Media y MediaTrailer</td>
                    <td>Relaciona el contenido con su trailer.</td>
                </tr>
            </table>
        </section>

        <section id="herencia">
            <h2>Uso de MediaType</h2>

            <p>
                En este diseño se utiliza el atributo <strong>MediaType</strong> dentro de la entidad
                Media. Este atributo permite identificar si el contenido es una película o una serie.
            </p>

            <p>
                Se decidió usar una sola entidad llamada Media porque ambos tipos de contenido
                comparten los mismos atributos principales. Esto evita crear tablas separadas para
                Movie y Series cuando no es necesario.
            </p>
        </section>

        <section id="mejoras">
            <h2>Mejoras realizadas al modelo</h2>

            <ul>
                <li>Se corrigió ProductionHouse para usar el atributo ProductionHouseName.</li>
                <li>Se corrigió la relación Produces para conectarla con ProductionHouse.</li>
                <li>Se completaron las relaciones Has_Link y Has_Trailer.</li>
                <li>Se organizaron mejor las entidades y relaciones del diagrama.</li>
                <li>Se mantuvo Media como entidad principal del sistema.</li>
            </ul>
        </section>


        <section id="conclusion">
            <h2>Conclusión</h2>

            <p>
                En conclusión, este modelo permite organizar de manera clara la información de
                películas y series. La entidad Media funciona como el centro de la base de datos,
                mientras que las demás entidades ayudan a clasificar y describir cada contenido.
            </p>

            <p>
                Este diseño puede utilizarse como base para crear el modelo relacional y luego
                implementar la base de datos en un sistema real.
            </p>
        </section>

    </main>

    <footer>
        <p>Proyecto de Base de Datos | <?php echo date("Y"); ?></p>
    </footer>

</body>

</html>

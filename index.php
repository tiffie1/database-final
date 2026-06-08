<?php
require_once "queries.php";

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
        <a href="#introduccion">Introducción</a>
        <a href="#diagrama">Diagrama E/R</a>
        <a href="#entidades">Entidades</a>
        <a href="#relaciones">Relaciones</a>
        <a href="#mejoras">Mejoras</a>
        <a href="#conclusion">Conclusión</a>
        <!-- Enlace a la nueva página de consultas y gestión de datos -->
        <a href="queries.php">
            <font color='#256BEF'><u>Consultas y Datos ↗</u></font>
        </a>
    </nav>

    <main>

        <section id="introduccion">
            <h2>Introducción</h2>
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

        <section id="diagrama">
            <h2>Diagrama Entidad-Relación</h2>
            <p>
                El siguiente diagrama muestra la estructura general de la base de datos. La entidad
                principal es <strong>Media</strong>, ya que representa cada película o serie dentro
                del catálogo. Las demás entidades se conectan con Media para añadir información
                adicional.
            </p>
            <div class="diagram">
                <img src="./movie-ER.svg" alt="Diagrama Entidad-Relación">
            </div>
            <p>
                En el diagrama, las entidades aparecen como tablas, las relaciones aparecen con
                diamantes y las conexiones muestran cómo se relacionan los datos.
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
                    <td><tt>Media</tt></td>
                    <td>Entidad principal. Representa una película o serie dentro del catálogo.</td>
                </tr>
                <tr>
                    <td><tt>Genre</tt></td>
                    <td>Guarda los géneros del contenido, como drama, acción, comedia o terror.</td>
                </tr>
                <tr>
                    <td><tt>Tag</tt></td>
                    <td>Guarda etiquetas o palabras clave relacionadas con el contenido.</td>
                </tr>
                <tr>
                    <td><tt>Language</tt></td>
                    <td>Representa los idiomas disponibles o asociados al contenido.</td>
                </tr>
                <tr>
                    <td><tt>Country</tt></td>
                    <td>Representa los países donde el contenido está disponible o relacionado.</td>
                </tr>
                <tr>
                    <td><tt>Actor</tt></td>
                    <td>Guarda los actores que participan en una película o serie.</td>
                </tr>
                <tr>
                    <td><tt>Director</tt></td>
                    <td>Guarda los directores asociados al contenido.</td>
                </tr>
                <tr>
                    <td><tt>Writer</tt></td>
                    <td>Guarda los escritores o guionistas del contenido.</td>
                </tr>
                <tr>
                    <td><tt>ProductionHouse</tt></td>
                    <td>Representa las casas productoras asociadas con cada contenido.</td>
                </tr>
                <tr>
                    <td><tt>MediaLinks</tt></td>
                    <td>Guarda enlaces, imágenes y poster relacionados con la película o serie.</td>
                </tr>
                <tr>
                    <td><tt>MediaTrailer</tt></td>
                    <td>Guarda información sobre el trailer del contenido.</td>
                </tr>
            </table>
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
                    <td><tt>Has_Genre</tt></td>
                    <td><tt>Media</tt> y <tt>Genre</tt></td>
                    <td>Una película o serie puede tener varios géneros.</td>
                </tr>
                <tr>
                    <td><tt>Has_Tag</tt></td>
                    <td><tt>Media</tt> y <tt>Tag</tt></td>
                    <td>Un contenido puede tener varias etiquetas.</td>
                </tr>
                <tr>
                    <td><tt>Acts_In</tt></td>
                    <td><tt>Media</tt> y <tt>Actor</tt></td>
                    <td>Un actor puede participar en varios contenidos y un contenido puede tener varios actores.</td>
                </tr>
                <tr>
                    <td><tt>Directs</tt></td>
                    <td><tt>Media</tt> y <tt>Director</tt></td>
                    <td>Relaciona una película o serie con sus directores.</td>
                </tr>
                <tr>
                    <td><tt>Writes</tt></td>
                    <td><tt>Media</tt> y <tt>Writer</tt></td>
                    <td>Relaciona una película o serie con sus escritores.</td>
                </tr>
                <tr>
                    <td><tt>Produces</tt></td>
                    <td><tt>Media</tt> y <tt>ProductionHouse</tt></td>
                    <td>Relaciona el contenido con las casas productoras.</td>
                </tr>
                <tr>
                    <td><tt>Available_In</tt></td>
                    <td><tt>Media</tt> y <tt>Country</tt></td>
                    <td>Indica los países donde el contenido está disponible o relacionado.</td>
                </tr>
                <tr>
                    <td><tt>Has_Language</tt></td>
                    <td><tt>Media</tt> y <tt>Language</tt></td>
                    <td>Indica los idiomas asociados con el contenido.</td>
                </tr>
                <tr>
                    <td><tt>Has_Link</tt></td>
                    <td><tt>Media</tt> y <tt>MediaLinks</tt></td>
                    <td>Relaciona el contenido con sus enlaces e imágenes.</td>
                </tr>
                <tr>
                    <td><tt>Has_Trailer</tt></td>
                    <td><tt>Media</tt> y <tt>MediaTrailer</tt></td>
                    <td>Relaciona el contenido con su trailer.</td>
                </tr>
            </table>
        </section>

        <section id="herencia">
            <h2>Uso de MediaType</h2>
            <p>
                En este diseño se utiliza el atributo <strong><tt>MediaType</tt></strong> dentro de la entidad
                <tt>Media</tt>. Este atributo permite identificar si el contenido es una película o una serie.
            </p>
            <p>
                Se decidió usar una sola entidad llamada <tt>Media</tt> porque ambos tipos de contenido
                comparten los mismos atributos principales. Esto evita crear tablas separadas para
                Movie y Series cuando no es necesario.
            </p>
        </section>

        <section id="mejoras">
            <h2>Mejoras realizadas al modelo</h2>
            <ul>
                <li>Se corrigió <tt>ProductionHouse</tt> para usar el atributo <tt>ProductionHouseName</tt>.</li>
                <li>Se corrigió la relación Produces para conectarla con <tt>ProductionHouse</tt>.</li>
                <li>Se completaron las relaciones <tt>Has_Link</tt> y <tt>Has_Trailer</tt>.</li>
                <li>Se organizaron mejor las entidades y relaciones del diagrama.</li>
                <li>Se mantuvo <tt>Media</tt> como entidad principal del sistema.</li>
            </ul>
        </section>

        <section id="conclusion">
            <h2>Conclusión</h2>
            <p>
                En conclusión, este modelo permite organizar de manera clara la información de
                películas y series. La entidad <tt>Media</tt> funciona como el centro de la base de datos,
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

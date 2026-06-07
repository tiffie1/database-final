<?php
/*
 * queries.php
 * -----------
 * Esta página tiene dos funciones principales:
 *   1. Ejecutar queries predefinidas y mostrar los resultados en tabla.
 *   2. Permitir insertar o modificar registros en la base de datos.
 *
 * La base de datos usada es MovieData corriendo en MariaDB/XAMPP local.
 */

/* =========================================================
 * CONEXIÓN A LA BASE DE DATOS
 * ---------------------------------------------------------
 * mysqli_connect() recibe: host, usuario, contraseña, nombre de BD.
 * En XAMPP local el usuario por defecto es root sin contraseña.
 * Si le pusiste contraseña en mariadb-secure-installation,
 * cámbiala aquí.
 * ========================================================= */
$conn = mysqli_connect("localhost", "root", "", "MovieData");

// Si la conexión falla, se detiene todo y se muestra el error.
if (!$conn) {
    die("<p>Error de conexión: " . mysqli_connect_error() . "</p>");
}

// Establecer UTF-8 para que caracteres especiales (japonés, turco, etc.)
// se lean y escriban correctamente.
mysqli_set_charset($conn, "utf8mb4");

/* =========================================================
 * QUERIES PREDEFINIDAS
 * ---------------------------------------------------------
 * Cada entrada del arreglo tiene:
 *   "label" -> lo que ve el usuario en el dropdown
 *   "sql"   -> el query que se ejecuta (solo los primeros 10
 *              resultados via LIMIT 10)
 * Reemplaza estos queries con los tuyos reales.
 * ========================================================= */
$queries = [
    [
        "label" => "1. Ver primeras 10 películas",
        "sql"   => "SELECT MediaID, Title, MediaType, IMDbScore
                    FROM Media
                    LIMIT 10"
    ],
    [
        "label" => "2. Películas con mayor puntuación IMDb",
        "sql"   => "SELECT MediaID, Title, IMDbScore
                    FROM Media
                    ORDER BY IMDbScore DESC
                    LIMIT 10"
    ],
    [
        "label" => "3. Actores y sus películas",
        "sql"   => "SELECT a.ActorName, m.Title
                    FROM Actor a
                    JOIN Acts_In ai ON a.ActorID = ai.ActorID
                    JOIN Media m   ON ai.MediaID = m.MediaID
                    LIMIT 10"
    ],
    [
        "label" => "4. Géneros disponibles",
        "sql"   => "SELECT GenreID, GenreName
                    FROM Genre
                    LIMIT 10"
    ],
    [
        "label" => "5. Películas por director",
        "sql"   => "SELECT d.DirectorName, m.Title
                    FROM Director d
                    JOIN Directs di ON d.DirectorID = di.DirectorID
                    JOIN Media m    ON di.MediaID   = m.MediaID
                    LIMIT 10"
    ],
];

/* =========================================================
 * MANEJO DEL DROPDOWN DE QUERIES
 * ---------------------------------------------------------
 * Cuando el usuario selecciona un query y hace clic en
 * "Ejecutar", el formulario envía el índice del query
 * seleccionado via POST. Aquí se recibe y se ejecuta.
 * ========================================================= */
$queryResults  = null;  // Guardará las filas del resultado
$queryError    = null;  // Guardará el error si falla el query
$selectedQuery = -1;    // Índice del query seleccionado

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["query_index"])) {

    $selectedQuery = (int) $_POST["query_index"];

    // Verificar que el índice sea válido antes de ejecutar
    if ($selectedQuery >= 0 && $selectedQuery < count($queries)) {

        $sql    = $queries[$selectedQuery]["sql"];
        $result = mysqli_query($conn, $sql);

        if ($result) {
            // mysqli_fetch_all devuelve todas las filas como arreglo asociativo
            $queryResults = mysqli_fetch_all($result, MYSQLI_ASSOC);
            mysqli_free_result($result);
        } else {
            // Si el query falla (ej. tabla no existe), guardar el mensaje de error
            $queryError = mysqli_error($conn);
        }
    }
}

/* =========================================================
 * MANEJO DEL FORMULARIO DE INSERCIÓN / MODIFICACIÓN
 * ---------------------------------------------------------
 * El formulario de abajo envía los datos de una nueva
 * película via POST con action="insert". Aquí se reciben,
 * se sanitizan, y se insertan en Media.
 *
 * mysqli_real_escape_string() previene SQL injection
 * escapando caracteres peligrosos en los strings.
 *
 * Si la base de datos tiene restricciones (NOT NULL,
 * FOREIGN KEY, CHECK, etc.), MariaDB devolverá un error
 * que se captura y muestra al usuario.
 * ========================================================= */
$insertSuccess = null;
$insertError   = null;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"]) && $_POST["action"] === "insert") {

    // Sanitizar cada campo recibido del formulario.
    // mysqli_real_escape_string escapa comillas y otros caracteres especiales.
    $title    = mysqli_real_escape_string($conn, trim($_POST["title"]));
    $type     = mysqli_real_escape_string($conn, trim($_POST["media_type"]));
    $score    = mysqli_real_escape_string($conn, trim($_POST["imdb_score"]));
    $release  = mysqli_real_escape_string($conn, trim($_POST["release_date"]));

    // Construir el INSERT. Los campos que no están en el formulario
    // se dejan como NULL. Añade más columnas según necesites.
    $insertSQL = "INSERT INTO Media (Title, MediaType, IMDbScore, ReleaseDate)
                  VALUES ('$title', '$type', 
                          " . ($score === "" ? "NULL" : "'$score'") . ",
                          " . ($release === "" ? "NULL" : "'$release'") . ")";

    if (mysqli_query($conn, $insertSQL)) {
        // mysqli_insert_id() devuelve el ID autogenerado del nuevo registro
        $insertSuccess = "Registro insertado correctamente con ID: " . mysqli_insert_id($conn);
    } else {
        // Si MariaDB rechaza el insert (por restricciones, tipos incorrectos, etc.)
        // se muestra el error exacto de la base de datos
        $insertError = mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Consultas y Datos</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <header>
        <h1>Consultas y Gestión de Datos</h1>
        <nav>
            <!-- Botón para regresar al index principal -->
            <a href="index.php">← Volver al Informe</a>
        </nav>
    </header>

    <main>

        <!-- =====================================================
             SECCIÓN 1: QUERIES PREDEFINIDAS
             ===================================================== -->
        <section id="consultas">
            <h2>Consultas predefinidas</h2>
            <p>Selecciona un query del menú y haz clic en <strong>Ejecutar</strong>
                para ver los primeros 10 resultados.</p>

            <!--
                Formulario del dropdown.
                method="POST" envía los datos al mismo archivo (action="").
                El select envía el índice numérico del query seleccionado.
            -->
            <form method="POST" action="">
                <select name="query_index">
                    <?php foreach ($queries as $i => $q): ?>
                        <option value="<?php echo $i; ?>"
                            <?php echo ($selectedQuery === $i) ? "selected" : ""; ?>>
                            <?php echo htmlspecialchars($q["label"]); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <button type="submit">Ejecutar</button>
            </form>

            <?php if ($queryError !== null): ?>
                <!-- Mostrar error si el query falló -->
                <p style="color:red;">Error en el query: <?php echo htmlspecialchars($queryError); ?></p>

            <?php elseif ($queryResults !== null): ?>
                <?php if (count($queryResults) === 0): ?>
                    <p>El query no devolvió resultados.</p>
                <?php else: ?>
                    <!--
                        Construir la tabla dinámicamente.
                        Los encabezados se sacan de las claves del primer resultado
                        para que funcione con cualquier query sin hardcodear columnas.
                    -->
                    <table>
                        <tr>
                            <?php foreach (array_keys($queryResults[0]) as $col): ?>
                                <th><?php echo htmlspecialchars($col); ?></th>
                            <?php endforeach; ?>
                        </tr>
                        <?php foreach ($queryResults as $row): ?>
                            <tr>
                                <?php foreach ($row as $cell): ?>
                                    <td><?php echo htmlspecialchars((string)$cell); ?></td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php endif; ?>
            <?php endif; ?>
        </section>

        <!-- =====================================================
             SECCIÓN 2: INSERTAR / MODIFICAR REGISTROS
             ===================================================== -->
        <section id="insertar">
            <h2>Insertar nuevo registro en Media</h2>
            <p>Completa los campos y haz clic en <strong>Insertar</strong>.
                Si algún valor viola las restricciones de la base de datos,
                se mostrará el error correspondiente.</p>

            <!--
                El campo oculto "action" con valor "insert" le dice al PHP
                de arriba que este POST es para insertar, no para ejecutar
                un query. Así distinguimos los dos formularios.
            -->
            <form method="POST" action="">
                <input type="hidden" name="action" value="insert">

                <table>
                    <tr>
                        <td><label for="title">Título *</label></td>
                        <td><input type="text" id="title" name="title" required></td>
                    </tr>
                    <tr>
                        <td><label for="media_type">Tipo (Movie / Series)</label></td>
                        <td>
                            <select id="media_type" name="media_type">
                                <option value="movie">Movie</option>
                                <option value="series">Series</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="imdb_score">Puntuación IMDb</label></td>
                        <td><input type="number" id="imdb_score" name="imdb_score"
                                step="0.1" min="0" max="10"></td>
                    </tr>
                    <tr>
                        <td><label for="release_date">Fecha de estreno (YYYY-MM-DD)</label></td>
                        <td><input type="date" id="release_date" name="release_date"></td>
                    </tr>
                </table>

                <button type="submit">Insertar</button>
            </form>

            <?php if ($insertSuccess !== null): ?>
                <p style="color:green;"><?php echo htmlspecialchars($insertSuccess); ?></p>
            <?php endif; ?>

            <?php if ($insertError !== null): ?>
                <p style="color:red;">Error al insertar: <?php echo htmlspecialchars($insertError); ?></p>
            <?php endif; ?>
        </section>

    </main>

    <footer>
        <p>Proyecto de Base de Datos | <?php echo date("Y"); ?></p>
    </footer>

</body>

</html>

<?php
// Cerrar la conexión al final de la página.
mysqli_close($conn);
?>

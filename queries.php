<?php
/*
 * queries.php
 * -----------
 * Esta página tiene dos funciones principales:
 *   1. Ejecutar queries predefinidas y mostrar los resultados en tabla.
 *   2. Permitir insertar registros en cualquier entidad de la base de datos.
 */

$conn = mysqli_connect("localhost", "root", "", "MovieData");

if (!$conn) {
    die("<p>Error de conexión: " . mysqli_connect_error() . "</p>");
}

mysqli_set_charset($conn, "utf8mb4");

/* =========================================================
 * DEFINICIÓN DE ENTIDADES Y SUS CAMPOS
 * ---------------------------------------------------------
 * Cada entidad tiene:
 *   "table"  -> nombre exacto de la tabla en MariaDB
 *   "id"     -> nombre de la columna PRI (se excluye del
 *               formulario porque es AUTO_INCREMENT)
 *   "fields" -> arreglo de campos insertables. Cada campo:
 *       "col"      -> nombre de columna en la tabla
 *       "label"    -> etiqueta legible para el usuario
 *       "type"     -> tipo de input HTML
 *       "required" -> si es obligatorio en el formulario
 * ========================================================= */
$entities = [

    "Media" => [
        "table"  => "Media",
        "id"     => "MediaID",
        "fields" => [
            ["col" => "Title",              "label" => "Título",                    "type" => "text",   "required" => true],
            ["col" => "MediaType",          "label" => "Tipo (movie / series)",     "type" => "text",   "required" => false],
            ["col" => "HiddenGemScore",     "label" => "Hidden Gem Score",          "type" => "number", "required" => false],
            ["col" => "MinMinutes",         "label" => "Duración mínima (mins)",    "type" => "number", "required" => false],
            ["col" => "MaxMinutes",         "label" => "Duración máxima (mins)",    "type" => "number", "required" => false],
            ["col" => "ViewRating",         "label" => "View Rating (ej. PG-13)",   "type" => "text",   "required" => false],
            ["col" => "IMDbScore",          "label" => "Puntuación IMDb",           "type" => "number", "required" => false],
            ["col" => "RottenTomatoesScore","label" => "Rotten Tomatoes Score",     "type" => "number", "required" => false],
            ["col" => "MetacriticScore",    "label" => "Metacritic Score",          "type" => "number", "required" => false],
            ["col" => "AwardsReceived",     "label" => "Premios Recibidos",         "type" => "number", "required" => false],
            ["col" => "AwardsNominated",    "label" => "Nominaciones",              "type" => "number", "required" => false],
            ["col" => "BoxOffice",          "label" => "Box Office (USD)",          "type" => "number", "required" => false],
            ["col" => "ReleaseDate",        "label" => "Fecha de estreno",          "type" => "date",   "required" => false],
            ["col" => "NetflixReleaseDate", "label" => "Fecha estreno en Netflix",  "type" => "date",   "required" => false],
            ["col" => "Summary",            "label" => "Resumen",                   "type" => "text",   "required" => false],
            ["col" => "IMDbVotes",          "label" => "Votos IMDb",                "type" => "number", "required" => false],
        ]
    ],

    "MediaLinks" => [
        "table"  => "MediaLinks",
        "id"     => "LinkID",
        "fields" => [
            ["col" => "NetflixLink", "label" => "Enlace Netflix",  "type" => "text", "required" => false],
            ["col" => "IMDBLink",    "label" => "Enlace IMDb",     "type" => "text", "required" => false],
            ["col" => "Image",       "label" => "URL de imagen",   "type" => "text", "required" => false],
            ["col" => "Poster",      "label" => "URL de póster",   "type" => "text", "required" => false],
        ]
    ],

    "MediaTrailer" => [
        "table"  => "MediaTrailer",
        "id"     => "TrailerID",
        "fields" => [
            ["col" => "IMDbTrailer", "label" => "URL Trailer IMDb", "type" => "text", "required" => false],
            ["col" => "TrailerSite", "label" => "Sitio del Trailer", "type" => "text", "required" => false],
        ]
    ],

    // Para todas las entidades simples de dos columnas,
    // el patrón es idéntico: solo el ID (excluido) y el nombre.
    "Actor" => [
        "table"  => "Actor",
        "id"     => "ActorID",
        "fields" => [
            ["col" => "ActorName", "label" => "Nombre del Actor", "type" => "text", "required" => true],
        ]
    ],

    "Country" => [
        "table"  => "Country",
        "id"     => "CountryID",
        "fields" => [
            ["col" => "CountryName", "label" => "Nombre del País", "type" => "text", "required" => true],
        ]
    ],

    "Director" => [
        "table"  => "Director",
        "id"     => "DirectorID",
        "fields" => [
            ["col" => "DirectorName", "label" => "Nombre del Director", "type" => "text", "required" => true],
        ]
    ],

    "Genre" => [
        "table"  => "Genre",
        "id"     => "GenreID",
        "fields" => [
            ["col" => "GenreName", "label" => "Nombre del Género", "type" => "text", "required" => true],
        ]
    ],

    "Language" => [
        "table"  => "Language",
        "id"     => "LanguageID",
        "fields" => [
            ["col" => "LanguageName", "label" => "Nombre del Idioma", "type" => "text", "required" => true],
        ]
    ],

    "ProductionHouse" => [
        "table"  => "ProductionHouse",
        "id"     => "ProductionHouseID",
        "fields" => [
            ["col" => "ProductionHouseName", "label" => "Nombre de la Productora", "type" => "text", "required" => true],
        ]
    ],

    "Tag" => [
        "table"  => "Tag",
        "id"     => "TagID",
        "fields" => [
            ["col" => "TagName", "label" => "Nombre del Tag", "type" => "text", "required" => true],
        ]
    ],

    "Writer" => [
        "table"  => "Writer",
        "id"     => "WriterID",
        "fields" => [
            ["col" => "WriterName", "label" => "Nombre del Escritor", "type" => "text", "required" => true],
        ]
    ],
];

/* =========================================================
 * QUERIES PREDEFINIDAS
 * ========================================================= */
// PARA DERECK: "Pon los queries tuyos aqui." - Emi
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
 * ========================================================= */
$queryResults  = null;
$queryError    = null;
$selectedQuery = -1;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["query_index"])) {

    $selectedQuery = (int) $_POST["query_index"];

    if ($selectedQuery >= 0 && $selectedQuery < count($queries)) {

        $sql    = $queries[$selectedQuery]["sql"];
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $queryResults = mysqli_fetch_all($result, MYSQLI_ASSOC);
            mysqli_free_result($result);
        } else {
            $queryError = mysqli_error($conn);
        }
    }
}

/* =========================================================
 * MANEJO DEL FORMULARIO DE INSERCIÓN
 * ---------------------------------------------------------
 * Cuando se envía el formulario de inserción, el POST
 * incluye:
 *   "action"        -> siempre "insert"
 *   "entity"        -> clave del arreglo $entities (ej. "Actor")
 *   un campo por cada "col" definida en $entities[entity]["fields"]
 *
 * Se construye el INSERT dinámicamente recorriendo los
 * fields de la entidad seleccionada, para no tener que
 * escribir un INSERT distinto por cada tabla.
 * ========================================================= */
$insertSuccess  = null;
$insertError    = null;
// Mantener qué entidad estaba seleccionada al recargar
// para que el formulario no se resetee tras un insert.
$selectedEntity = array_key_first($entities);

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"]) && $_POST["action"] === "insert") {

    // Validar que la entidad recibida exista en nuestro arreglo
    // (nunca confiar en datos del usuario directamente en SQL).
    if (isset($_POST["entity"]) && array_key_exists($_POST["entity"], $entities)) {

        $selectedEntity = $_POST["entity"];
        $entityDef      = $entities[$selectedEntity];

        $cols   = [];  // Nombres de columnas para el INSERT
        $vals   = [];  // Valores sanitizados para el INSERT

        foreach ($entityDef["fields"] as $field) {

            $col      = $field["col"];
            $rawValue = isset($_POST[$col]) ? trim($_POST[$col]) : "";

            // Si el campo llegó vacío, insertar NULL en vez de string vacío,
            // así respetamos las restricciones numéricas y de fecha de MariaDB.
            if ($rawValue === "") {
                $cols[] = "`$col`";
                $vals[] = "NULL";
            } else {
                // Escapar para prevenir SQL injection
                $escaped = mysqli_real_escape_string($conn, $rawValue);
                $cols[]  = "`$col`";
                $vals[]  = "'$escaped'";
            }
        }

        // Construir y ejecutar el INSERT dinámico
        $colList = implode(", ", $cols);
        $valList = implode(", ", $vals);
        $insertSQL = "INSERT INTO `{$entityDef['table']}` ($colList) VALUES ($valList)";

        if (mysqli_query($conn, $insertSQL)) {
            $insertSuccess = "Registro insertado en {$selectedEntity} con ID: " . mysqli_insert_id($conn);
        } else {
            $insertError = mysqli_error($conn);
        }
    } else {
        $insertError = "Entidad no válida.";
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
            <a href="index.php">
                <font color='#256BEF'><u>← Volver al Informe</u></font>
            </a>
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
                <p style="color:red;">Error en el query: <?php echo htmlspecialchars($queryError); ?></p>

            <?php elseif ($queryResults !== null): ?>
                <?php if (count($queryResults) === 0): ?>
                    <p>El query no devolvió resultados.</p>
                <?php else: ?>
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
             SECCIÓN 2: INSERTAR REGISTROS
             ---------------------------------------------------------
             El dropdown de entidad controla qué campos se muestran
             via JavaScript. Todos los campos de todas las entidades
             están en el HTML, pero solo los de la entidad seleccionada
             son visibles en un momento dado.
             ===================================================== -->
        <section id="insertar">
            <h2>Insertar nuevo registro</h2>
            <p>Selecciona la entidad, completa los campos y haz clic en
                <strong>Insertar</strong>. Los errores de la base de datos
                se mostrarán debajo del formulario.</p>

            <form method="POST" action="" id="insertForm">
                <input type="hidden" name="action" value="insert">

                <!-- Dropdown para seleccionar en qué tabla insertar -->
                <label for="entitySelect"><strong>Entidad:</strong></label>
                <select name="entity" id="entitySelect">
                    <?php foreach ($entities as $key => $def): ?>
                        <option value="<?php echo $key; ?>"
                            <?php echo ($selectedEntity === $key) ? "selected" : ""; ?>>
                            <?php echo htmlspecialchars($key); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <br><br>

                <!--
                    Por cada entidad se genera un <div> con sus campos.
                    El div tiene el id "fields-NombreEntidad".
                    JavaScript muestra solo el div de la entidad activa
                    y oculta los demás, así el servidor recibe solo
                    los campos relevantes (los otros llegan vacíos
                    pero como no pertenecen a la entidad seleccionada,
                    el PHP los ignora al construir el INSERT).
                -->
                <?php foreach ($entities as $key => $def): ?>
                    <div id="fields-<?php echo $key; ?>"
                         style="display: <?php echo ($selectedEntity === $key) ? 'block' : 'none'; ?>;">
                        <table>
                            <?php foreach ($def["fields"] as $field): ?>
                                <tr>
                                    <td>
                                        <label for="<?php echo $field['col']; ?>">
                                            <?php echo htmlspecialchars($field['label']); ?>
                                            <?php echo $field['required'] ? ' *' : ''; ?>
                                        </label>
                                    </td>
                                    <td>
                                        <input
                                            type="<?php echo $field['type']; ?>"
                                            id="<?php echo $field['col']; ?>"
                                            name="<?php echo $field['col']; ?>"
                                            <?php echo $field['required'] ? 'required' : ''; ?>
                                            <?php echo $field['type'] === 'number' ? 'step="any"' : ''; ?>
                                        >
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                <?php endforeach; ?>

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

    <!--
        JavaScript para mostrar/ocultar los campos según la entidad seleccionada.
        Cuando el usuario cambia el dropdown, se ocultan todos los divs de campos
        y se muestra solo el que corresponde a la entidad nueva.
        Esto es puramente visual — el PHP del servidor decide qué insertar
        basándose en el campo "entity" del POST, no en lo que esté visible.
    -->
    <script>
        const entitySelect = document.getElementById('entitySelect');

        // Lista de todas las entidades generada desde PHP para no hardcodearla en JS
        const entityKeys = <?php echo json_encode(array_keys($entities)); ?>;

        entitySelect.addEventListener('change', function () {
            // Ocultar todos los divs de campos
            entityKeys.forEach(function (key) {
                document.getElementById('fields-' + key).style.display = 'none';
            });
            // Mostrar solo el div de la entidad seleccionada
            document.getElementById('fields-' + this.value).style.display = 'block';
        });
    </script>

</body>
</html>

<?php
mysqli_close($conn);
?>

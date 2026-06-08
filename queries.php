<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$conn = mysqli_connect("localhost", "root", "", "MovieData");

if (!$conn) {
    die("<p>Error de conexión: " . mysqli_connect_error() . "</p>");
}

mysqli_set_charset($conn, "utf8mb4");

/* =========================================================
 * DEFINICIÓN DE ENTIDADES Y SUS CAMPOS
 * ---------------------------------------------------------
 * Se añade "dbtype" a cada campo para:
 *   1. Mostrarlo en el label del formulario en monospace.
 *   2. Validar el valor del usuario en PHP antes del INSERT.
 *
 * Tipos soportados para validación:
 *   "varchar" -> string, se normaliza a minúsculas sin puntuación
 *   "int"     -> debe ser entero
 *   "float"   -> debe ser numérico
 *   "date"    -> debe tener formato YYYY-MM-DD
 * ========================================================= */
$entities = [
    "Media" => [
        "table"  => "Media",
        "id"     => "MediaID",
        "fields" => [
            ["col" => "Title",               "label" => "Título",                   "type" => "text",   "dbtype" => "VARCHAR(150)", "required" => true],
            ["col" => "MediaType",           "label" => "Tipo",                     "type" => "text",   "dbtype" => "VARCHAR(10)",  "required" => false],
            ["col" => "HiddenGemScore",      "label" => "Hidden Gem Score",         "type" => "number", "dbtype" => "FLOAT",        "required" => false],
            ["col" => "MinMinutes",          "label" => "Duración mínima (mins)",   "type" => "number", "dbtype" => "INT(11)",      "required" => false],
            ["col" => "MaxMinutes",          "label" => "Duración máxima (mins)",   "type" => "number", "dbtype" => "INT(11)",      "required" => false],
            ["col" => "ViewRating",          "label" => "View Rating",              "type" => "text",   "dbtype" => "VARCHAR(10)",  "required" => false],
            ["col" => "IMDbScore",           "label" => "Puntuación IMDb",          "type" => "number", "dbtype" => "FLOAT",        "required" => false],
            ["col" => "RottenTomatoesScore", "label" => "Rotten Tomatoes Score",    "type" => "number", "dbtype" => "FLOAT",        "required" => false],
            ["col" => "MetacriticScore",     "label" => "Metacritic Score",         "type" => "number", "dbtype" => "FLOAT",        "required" => false],
            ["col" => "AwardsReceived",      "label" => "Premios Recibidos",        "type" => "number", "dbtype" => "FLOAT",        "required" => false],
            ["col" => "AwardsNominated",     "label" => "Nominaciones",             "type" => "number", "dbtype" => "FLOAT",        "required" => false],
            ["col" => "BoxOffice",           "label" => "Box Office (USD)",         "type" => "number", "dbtype" => "FLOAT",        "required" => false],
            ["col" => "ReleaseDate",         "label" => "Fecha de estreno",         "type" => "date",   "dbtype" => "DATE",         "required" => false],
            ["col" => "NetflixReleaseDate",  "label" => "Fecha estreno en Netflix", "type" => "date",   "dbtype" => "DATE",         "required" => false],
            ["col" => "Summary",             "label" => "Resumen",                  "type" => "text",   "dbtype" => "VARCHAR(500)", "required" => false],
            ["col" => "IMDbVotes",           "label" => "Votos IMDb",               "type" => "number", "dbtype" => "FLOAT",        "required" => false],
        ]
    ],
    "MediaLinks" => [
        "table"  => "MediaLinks",
        "id"     => "LinkID",
        "fields" => [
            ["col" => "NetflixLink", "label" => "Enlace Netflix", "type" => "text", "dbtype" => "VARCHAR(500)", "required" => false],
            ["col" => "IMDBLink",    "label" => "Enlace IMDb",    "type" => "text", "dbtype" => "VARCHAR(500)", "required" => false],
            ["col" => "Image",       "label" => "URL de imagen",  "type" => "text", "dbtype" => "VARCHAR(500)", "required" => false],
            ["col" => "Poster",      "label" => "URL de póster",  "type" => "text", "dbtype" => "VARCHAR(500)", "required" => false],
        ]
    ],
    "MediaTrailer" => [
        "table"  => "MediaTrailer",
        "id"     => "TrailerID",
        "fields" => [
            ["col" => "IMDbTrailer", "label" => "URL Trailer IMDb",  "type" => "text", "dbtype" => "VARCHAR(200)", "required" => false],
            ["col" => "TrailerSite", "label" => "Sitio del Trailer", "type" => "text", "dbtype" => "VARCHAR(50)",  "required" => false],
        ]
    ],
    "Actor" => [
        "table"  => "Actor",
        "id"     => "ActorID",
        "fields" => [["col" => "ActorName", "label" => "Nombre del Actor", "type" => "text", "dbtype" => "VARCHAR(150)", "required" => true]]
    ],
    "Country" => [
        "table"  => "Country",
        "id"     => "CountryID",
        "fields" => [["col" => "CountryName", "label" => "Nombre del País", "type" => "text", "dbtype" => "VARCHAR(150)", "required" => true]]
    ],
    "Director" => [
        "table"  => "Director",
        "id"     => "DirectorID",
        "fields" => [["col" => "DirectorName", "label" => "Nombre del Director", "type" => "text", "dbtype" => "VARCHAR(150)", "required" => true]]
    ],
    "Genre" => [
        "table"  => "Genre",
        "id"     => "GenreID",
        "fields" => [["col" => "GenreName", "label" => "Nombre del Género", "type" => "text", "dbtype" => "VARCHAR(150)", "required" => true]]
    ],
    "Language" => [
        "table"  => "Language",
        "id"     => "LanguageID",
        "fields" => [["col" => "LanguageName", "label" => "Nombre del Idioma", "type" => "text", "dbtype" => "VARCHAR(150)", "required" => true]]
    ],
    "ProductionHouse" => [
        "table"  => "ProductionHouse",
        "id"     => "ProductionHouseID",
        "fields" => [["col" => "ProductionHouseName", "label" => "Nombre de la Productora", "type" => "text", "dbtype" => "VARCHAR(150)", "required" => true]]
    ],
    "Tag" => [
        "table"  => "Tag",
        "id"     => "TagID",
        "fields" => [["col" => "TagName", "label" => "Nombre del Tag", "type" => "text", "dbtype" => "VARCHAR(150)", "required" => true]]
    ],
    "Writer" => [
        "table"  => "Writer",
        "id"     => "WriterID",
        "fields" => [["col" => "WriterName", "label" => "Nombre del Escritor", "type" => "text", "dbtype" => "VARCHAR(150)", "required" => true]]
    ],
];

/* =========================================================
 * FUNCIÓN: NORMALIZAR INPUT DE TEXTO
 * ---------------------------------------------------------
 * Solo se aplica a campos VARCHAR — los campos numéricos
 * y de fecha no se normalizan porque perderían su formato.
 *
 * Pasos:
 *   1. Convertir a minúsculas
 *   2. Transliterar caracteres acentuados a su equivalente
 *      ASCII (á→a, ñ→n, etc.) para consistencia con los
 *      datos importados del CSV que también fueron lowercased
 *   3. Eliminar caracteres de puntuación excepto espacios,
 *      guiones y apóstrofes (útiles en nombres propios)
 * ========================================================= */
function normalizeText(string $value): string
{
    // Paso 1: minúsculas
    $value = mb_strtolower($value, 'UTF-8');

    // Paso 2: transliterar acentos y caracteres especiales a ASCII
    // iconv convierte de UTF-8 a ASCII ignorando lo que no puede convertir
    $value = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $value);

    // Paso 3: eliminar puntuación excepto espacios, guiones y apóstrofes
    $value = preg_replace("/[^\w\s\-']/", '', $value);

    // Limpiar espacios extra que pudieran quedar
    $value = trim(preg_replace('/\s+/', ' ', $value));

    return $value;
}

/* =========================================================
 * FUNCIÓN: VALIDAR VALOR SEGÚN TIPO DE DATO
 * ---------------------------------------------------------
 * Devuelve null si el valor es válido, o un string de error.
 * Se llama para cada campo antes de construir el INSERT.
 * ========================================================= */
function validateField(string $col, string $rawValue, string $dbtype): ?string
{
    if ($rawValue === "") return null; // Vacío se convierte a NULL, siempre válido

    // Extraer el tipo base (VARCHAR, INT, FLOAT, DATE) ignorando el tamaño
    $baseType = strtoupper(preg_replace('/\(.*\)/', '', $dbtype));

    switch ($baseType) {

        case 'INT':
            // Debe ser un entero (positivo o negativo)
            if (!preg_match('/^-?\d+$/', $rawValue)) {
                return "$col debe ser un número entero (ej: 120). Valor recibido: \"$rawValue\"";
            }
            break;

        case 'FLOAT':
        case 'DOUBLE':
        case 'DECIMAL':
            // Debe ser numérico — entero o decimal
            if (!is_numeric($rawValue)) {
                return "$col debe ser un número (ej: 7.5). Valor recibido: \"$rawValue\"";
            }
            break;

        case 'DATE':
            // Debe tener formato YYYY-MM-DD y ser una fecha real
            if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $rawValue)) {
                return "$col debe tener formato YYYY-MM-DD (ej: 2023-04-15). Valor recibido: \"$rawValue\"";
            }
            // Verificar que la fecha sea real (ej: no 2023-13-45)
            [$y, $m, $d] = explode('-', $rawValue);
            if (!checkdate((int)$m, (int)$d, (int)$y)) {
                return "$col no es una fecha válida: \"$rawValue\"";
            }
            break;

        case 'VARCHAR':
        case 'TEXT':
            // Verificar que no exceda el largo máximo definido en el tipo
            preg_match('/\((\d+)\)/', $dbtype, $matches);
            if (!empty($matches[1])) {
                $maxLen = (int) $matches[1];
                if (mb_strlen($rawValue, 'UTF-8') > $maxLen) {
                    return "$col no puede tener más de $maxLen caracteres. Largo actual: " . mb_strlen($rawValue, 'UTF-8');
                }
            }
            break;
    }

    return null; // Sin errores
}

/* =========================================================
 * QUERIES PREDEFINIDAS
 * ========================================================= */
// PARA DERECK: "Pon los queries tuyos aqui." - Emi
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
            LIMIT 10
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

/* =========================================================
 * MANEJO: QUERY PREDEFINIDA
 * ========================================================= */
$queryResults  = null;
$queryError    = null;
$selectedQuery = -1;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["query_index"])) {
    $selectedQuery = (int) $_POST["query_index"];
    if ($selectedQuery >= 0 && $selectedQuery < count($queries)) {
        $result = mysqli_query($conn, $queries[$selectedQuery]["sql"]);
        if ($result) {
            $queryResults = mysqli_fetch_all($result, MYSQLI_ASSOC);
            mysqli_free_result($result);
        } else {
            $queryError = mysqli_error($conn);
        }
    }
}

/* =========================================================
 * MANEJO: INSERTAR REGISTRO
 * ========================================================= */
$insertSuccess  = null;
$insertError    = null;
$insertWarnings = []; // Lista de errores de validación por campo
$selectedEntity = array_key_first($entities);

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"]) && $_POST["action"] === "insert") {
    if (isset($_POST["entity"]) && array_key_exists($_POST["entity"], $entities)) {
        $selectedEntity = $_POST["entity"];
        $entityDef      = $entities[$selectedEntity];
        $cols           = [];
        $vals           = [];
        $validationOk   = true;

        foreach ($entityDef["fields"] as $field) {
            $col      = $field["col"];
            $dbtype   = $field["dbtype"];
            $rawValue = isset($_POST[$col]) ? trim($_POST[$col]) : "";

            // Normalizar solo campos de texto VARCHAR
            $baseType = strtoupper(preg_replace('/\(.*\)/', '', $dbtype));
            if (in_array($baseType, ['VARCHAR', 'TEXT']) && $rawValue !== "") {
                $rawValue = normalizeText($rawValue);
            }

            // Validar tipo de dato
            $validationError = validateField($col, $rawValue, $dbtype);
            if ($validationError !== null) {
                $insertWarnings[] = $validationError;
                $validationOk = false;
            }

            $cols[] = "`$col`";
            $vals[] = ($rawValue === "") ? "NULL" : "'" . mysqli_real_escape_string($conn, $rawValue) . "'";
        }

        // Solo ejecutar el INSERT si todos los campos pasaron validación
        if ($validationOk) {
            $table     = $entityDef["table"];
            $idCol     = $entityDef["id"];
            $maxResult = mysqli_query($conn, "SELECT MAX(`$idCol`) AS maxID FROM `$table`");
            $maxRow    = mysqli_fetch_assoc($maxResult);
            $nextID    = ($maxRow["maxID"] === null) ? 1 : (int)$maxRow["maxID"] + 1;

            array_unshift($cols, "`$idCol`");
            array_unshift($vals, $nextID);

            $insertSQL = "INSERT INTO `$table` (" . implode(", ", $cols) . ") VALUES (" . implode(", ", $vals) . ")";

            if (mysqli_query($conn, $insertSQL)) {
                $insertSuccess = "¡Datos insertados! Nuevo ID en {$selectedEntity}: {$nextID}";
            } else {
                $insertError = mysqli_error($conn);
            }
        }
    }
}

/* =========================================================
 * MANEJO: BUSCAR Y EDITAR REGISTRO
 * ========================================================= */
$editRow        = null;
$editError      = null;
$editSuccess    = null;
$editEntity     = array_key_first($entities);
$editSearchedID = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"])) {

    if ($_POST["action"] === "search_edit") {
        if (isset($_POST["edit_entity"]) && array_key_exists($_POST["edit_entity"], $entities)) {
            $editEntity     = $_POST["edit_entity"];
            $editSearchedID = trim($_POST["edit_id"]);
            $def            = $entities[$editEntity];
            $safeID         = (int) $editSearchedID;
            $result         = mysqli_query($conn, "SELECT * FROM `{$def['table']}` WHERE `{$def['id']}` = $safeID LIMIT 1");

            if ($result && mysqli_num_rows($result) > 0) {
                $editRow = mysqli_fetch_assoc($result);
            } else {
                $editError = "No se encontró ningún registro con ID $safeID en $editEntity.";
            }
        }
    }

    if ($_POST["action"] === "save_edit") {
        if (isset($_POST["edit_entity"]) && array_key_exists($_POST["edit_entity"], $entities)) {
            $editEntity     = $_POST["edit_entity"];
            $def            = $entities[$editEntity];
            $safeID         = (int) $_POST["edit_record_id"];
            $setParts       = [];
            $editWarnings   = [];
            $validationOk   = true;

            foreach ($def["fields"] as $field) {
                $col      = $field["col"];
                $dbtype   = $field["dbtype"];
                $rawValue = isset($_POST[$col]) ? trim($_POST[$col]) : "";

                $baseType = strtoupper(preg_replace('/\(.*\)/', '', $dbtype));
                if (in_array($baseType, ['VARCHAR', 'TEXT']) && $rawValue !== "") {
                    $rawValue = normalizeText($rawValue);
                }

                $validationError = validateField($col, $rawValue, $dbtype);
                if ($validationError !== null) {
                    $editWarnings[] = $validationError;
                    $validationOk   = false;
                }

                $escaped    = mysqli_real_escape_string($conn, $rawValue);
                $setParts[] = "`$col` = " . ($rawValue === "" ? "NULL" : "'$escaped'");
            }

            if ($validationOk) {
                $updateSQL = "UPDATE `{$def['table']}` SET " . implode(", ", $setParts) . " WHERE `{$def['id']}` = $safeID";
                if (mysqli_query($conn, $updateSQL)) {
                    $editSuccess    = "¡Registro $safeID en $editEntity actualizado correctamente!";
                    $result         = mysqli_query($conn, "SELECT * FROM `{$def['table']}` WHERE `{$def['id']}` = $safeID LIMIT 1");
                    $editRow        = mysqli_fetch_assoc($result);
                    $editSearchedID = $safeID;
                } else {
                    $editError = mysqli_error($conn);
                    $editRow   = [];
                    foreach ($def["fields"] as $field) {
                        $editRow[$field["col"]] = isset($_POST[$field["col"]]) ? $_POST[$field["col"]] : "";
                    }
                    $editRow[$def["id"]] = $safeID;
                    $editSearchedID      = $safeID;
                }
            } else {
                $editError      = "Errores de validación: " . implode(" | ", $editWarnings);
                $editRow        = [];
                foreach ($def["fields"] as $field) {
                    $editRow[$field["col"]] = isset($_POST[$field["col"]]) ? $_POST[$field["col"]] : "";
                }
                $editRow[$def["id"]] = $safeID;
                $editSearchedID      = $safeID;
            }
        }
    }
}

/* =========================================================
 * MANEJO: QUERY LIBRE
 * ========================================================= */
$freeQueryResult   = null;
$freeQueryError    = null;
$freeQuerySuccess  = null;
$freeQueryInput    = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"]) && $_POST["action"] === "free_query") {
    $freeQueryInput     = trim($_POST["free_sql"]);
    $confirmedDangerous = isset($_POST["confirmed_dangerous"]) && $_POST["confirmed_dangerous"] === "1";
    $isDangerous        = (bool) preg_match('/\b(DROP|TRUNCATE)\b/i', $freeQueryInput);

    if ($isDangerous && !$confirmedDangerous) {
        $freeQueryError = "El query contiene DROP o TRUNCATE. Confirma la operación antes de ejecutar.";
    } else {
        $result = mysqli_query($conn, $freeQueryInput);
        if ($result === true) {
            $freeQuerySuccess = "Query ejecutado. Filas afectadas: " . mysqli_affected_rows($conn);
        } elseif ($result === false) {
            $freeQueryError = mysqli_error($conn);
        } else {
            $freeQueryResult = mysqli_fetch_all($result, MYSQLI_ASSOC);
            mysqli_free_result($result);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Consultas y Datos</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Estilo para el tipo de dato en monospace dentro del label */
        .dbtype {
            font-family: monospace;
            font-size: 0.9em;
            color: #555;
        }

        .validation-error {
            color: red;
            font-size: 0.9em;
            margin: 5px 0;
        }
    </style>
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

        <!-- SECCIÓN 1: QUERIES PREDEFINIDAS -->
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
                <p style="color:red;">Error: <?php echo htmlspecialchars($queryError); ?></p>
            <?php elseif ($queryResults !== null): ?>
                <?php if (count($queryResults) === 0): ?>
                    <p>El query no devolvió resultados.</p>
                <?php else: ?>
                    <table>
                        <tr><?php foreach (array_keys($queryResults[0]) as $col): ?>
                                <th><?php echo htmlspecialchars($col); ?></th>
                            <?php endforeach; ?>
                        </tr>
                        <?php foreach ($queryResults as $row): ?>
                            <tr><?php foreach ($row as $cell): ?>
                                    <td><?php echo htmlspecialchars((string)$cell); ?></td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php endif; ?>
            <?php endif; ?>
        </section>

        <!-- SECCIÓN 2: INSERTAR REGISTROS -->
        <section id="insertar">
            <h2>Insertar nuevo registro</h2>
            <p>Los campos de texto se normalizarán a minúsculas sin puntuación al insertar.</p>

            <!-- Banner de éxito/error con auto-hide via JS -->
            <div id="insertBanner" style="display:none; padding:10px; border-radius:5px; margin-bottom:10px;"></div>

            <?php if (!empty($insertWarnings)): ?>
                <div class="validation-error">
                    <strong>Errores de validación:</strong>
                    <ul>
                        <?php foreach ($insertWarnings as $w): ?>
                            <li><?php echo htmlspecialchars($w); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="" id="insertForm">
                <input type="hidden" name="action" value="insert">

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

                <?php foreach ($entities as $key => $def): ?>
                    <div id="fields-<?php echo $key; ?>"
                        style="display:<?php echo ($selectedEntity === $key) ? 'block' : 'none'; ?>;">
                        <table>
                            <?php foreach ($def["fields"] as $field): ?>
                                <tr>
                                    <td>
                                        <!-- Label con tipo de dato en monospace -->
                                        <label for="insert_<?php echo $field['col']; ?>">
                                            <?php echo htmlspecialchars($field['label']); ?>
                                            <span class="dbtype">(`<?php echo $field['dbtype']; ?>`)</span>
                                            <?php echo $field['required'] ? ' *' : ''; ?>
                                        </label>
                                    </td>
                                    <td>
                                        <input
                                            type="<?php echo $field['type']; ?>"
                                            id="insert_<?php echo $field['col']; ?>"
                                            name="<?php echo $field['col']; ?>"
                                            <?php echo $field['required'] ? 'required' : ''; ?>
                                            <?php echo $field['type'] === 'number' ? 'step="any"' : ''; ?>>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                <?php endforeach; ?>

                <button type="submit">Insertar</button>
            </form>
        </section>

        <!-- SECCIÓN 3: MODIFICAR REGISTROS -->
        <section id="editar">
            <h2>Modificar registro existente</h2>

            <form method="POST" action="">
                <input type="hidden" name="action" value="search_edit">
                <label for="editEntitySelect"><strong>Entidad:</strong></label>
                <select name="edit_entity" id="editEntitySelect">
                    <?php foreach ($entities as $key => $def): ?>
                        <option value="<?php echo $key; ?>"
                            <?php echo ($editEntity === $key) ? "selected" : ""; ?>>
                            <?php echo htmlspecialchars($key); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <label for="edit_id"><strong>ID:</strong></label>
                <input type="number" id="edit_id" name="edit_id"
                    value="<?php echo htmlspecialchars($editSearchedID); ?>"
                    min="1" required style="width:80px;">
                <button type="submit">Buscar</button>
            </form>

            <?php if ($editError !== null): ?>
                <p style="color:red;">✘ <?php echo htmlspecialchars($editError); ?></p>
            <?php endif; ?>
            <?php if ($editSuccess !== null): ?>
                <p style="color:green; font-weight:bold;">✔ <?php echo htmlspecialchars($editSuccess); ?></p>
            <?php endif; ?>

            <?php if ($editRow !== null): ?>
                <?php $def = $entities[$editEntity]; ?>
                <hr>
                <p>Editando <strong><?php echo htmlspecialchars($editEntity); ?></strong>
                    con ID <strong><?php echo htmlspecialchars($editSearchedID); ?></strong>:</p>

                <form method="POST" action="">
                    <input type="hidden" name="action" value="save_edit">
                    <input type="hidden" name="edit_entity" value="<?php echo htmlspecialchars($editEntity); ?>">
                    <input type="hidden" name="edit_record_id" value="<?php echo htmlspecialchars($editSearchedID); ?>">

                    <table>
                        <?php foreach ($def["fields"] as $field): ?>
                            <?php $currentVal = isset($editRow[$field["col"]]) ? $editRow[$field["col"]] : ""; ?>
                            <tr>
                                <td>
                                    <label>
                                        <?php echo htmlspecialchars($field['label']); ?>
                                        <span class="dbtype">(`<?php echo $field['dbtype']; ?>`)</span>
                                    </label>
                                </td>
                                <td>
                                    <input
                                        type="<?php echo $field['type']; ?>"
                                        name="<?php echo $field['col']; ?>"
                                        value="<?php echo htmlspecialchars((string)$currentVal); ?>"
                                        <?php echo $field['required'] ? 'required' : ''; ?>
                                        <?php echo $field['type'] === 'number' ? 'step="any"' : ''; ?>>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                    <button type="submit">Guardar cambios</button>
                </form>
            <?php endif; ?>
        </section>

        <!-- SECCIÓN 4: QUERY LIBRE -->
        <section id="query-libre">
            <h2>Query libre</h2>
            <p>Escribe cualquier query SQL.
                <strong style="color:red;">DROP y TRUNCATE pedirán confirmación antes de ejecutarse.</strong>
            </p>

            <form method="POST" action="" id="freeQueryForm">
                <input type="hidden" name="action" value="free_query">
                <input type="hidden" name="confirmed_dangerous" id="confirmedDangerous" value="0">
                <textarea name="free_sql" id="freeSqlInput" rows="5"
                    style="width:100%; font-family:monospace;"
                    placeholder="SELECT * FROM Media LIMIT 5;"><?php echo htmlspecialchars($freeQueryInput); ?></textarea>
                <br>
                <button type="submit">Ejecutar query</button>
            </form>

            <?php if ($freeQueryError !== null): ?>
                <p style="color:red;">✘ Error: <?php echo htmlspecialchars($freeQueryError); ?></p>
            <?php endif; ?>
            <?php if ($freeQuerySuccess !== null): ?>
                <p style="color:green; font-weight:bold;">✔ <?php echo htmlspecialchars($freeQuerySuccess); ?></p>
            <?php endif; ?>
            <?php if ($freeQueryResult !== null): ?>
                <?php if (count($freeQueryResult) === 0): ?>
                    <p>El query no devolvió filas.</p>
                <?php else: ?>
                    <table>
                        <tr><?php foreach (array_keys($freeQueryResult[0]) as $col): ?>
                                <th><?php echo htmlspecialchars($col); ?></th>
                            <?php endforeach; ?>
                        </tr>
                        <?php foreach ($freeQueryResult as $row): ?>
                            <tr><?php foreach ($row as $cell): ?>
                                    <td><?php echo htmlspecialchars((string)$cell); ?></td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php endif; ?>
            <?php endif; ?>
        </section>

    </main>

    <footer>
        <p>Proyecto de Base de Datos | <?php echo date("Y"); ?></p>
    </footer>

    <script>
        /* =========================================================
         * JS: BANNER DE INSERCIÓN
         * ========================================================= */
        const insertBanner = document.getElementById('insertBanner');
        <?php if ($insertSuccess !== null): ?>
            insertBanner.innerHTML = '✔ <?php echo addslashes(htmlspecialchars($insertSuccess)); ?>';
            insertBanner.style.cssText = 'display:block; padding:10px; border-radius:5px; background:#d4edda; color:green; font-weight:bold;';
            setTimeout(() => {
                insertBanner.style.transition = 'opacity 0.5s';
                insertBanner.style.opacity = '0';
                setTimeout(() => insertBanner.style.display = 'none', 500);
            }, 5000);
        <?php elseif ($insertError !== null): ?>
            insertBanner.innerHTML = '✘ Error: <?php echo addslashes(htmlspecialchars($insertError)); ?>';
            insertBanner.style.cssText = 'display:block; padding:10px; border-radius:5px; background:#f8d7da; color:red; font-weight:bold;';
        <?php endif; ?>

        /* =========================================================
         * JS: DROPDOWN DE ENTIDAD EN INSERTAR
         * ========================================================= */
        const entitySelect = document.getElementById('entitySelect');
        const entityKeys = <?php echo json_encode(array_keys($entities)); ?>;

        function switchEntity(selectedKey) {
            entityKeys.forEach(key => {
                const div = document.getElementById('fields-' + key);
                const inputs = div.querySelectorAll('input');
                if (key === selectedKey) {
                    div.style.display = 'block';
                    inputs.forEach(i => i.removeAttribute('disabled'));
                } else {
                    div.style.display = 'none';
                    inputs.forEach(i => i.setAttribute('disabled', 'disabled'));
                }
            });
        }

        switchEntity(entitySelect.value);
        entitySelect.addEventListener('change', function() {
            switchEntity(this.value);
        });

        /* =========================================================
         * JS: CONFIRMACIÓN PARA DROP / TRUNCATE
         * ========================================================= */
        document.getElementById('freeQueryForm').addEventListener('submit', function(e) {
            const sql = document.getElementById('freeSqlInput').value;
            const dangerous = /\b(DROP|TRUNCATE)\b/i.test(sql);
            if (dangerous) {
                e.preventDefault();
                const confirmed = window.confirm(
                    "⚠️ ADVERTENCIA: El query contiene DROP o TRUNCATE.\n\n" +
                    "Esto eliminará datos de forma permanente.\n\n" +
                    "Query a ejecutar:\n" + sql + "\n\n" +
                    "¿Estás seguro de que quieres continuar?"
                );
                if (confirmed) {
                    document.getElementById('confirmedDangerous').value = '1';
                    this.submit();
                }
            }
        });
    </script>

</body>

</html>
<?php mysqli_close($conn); ?>

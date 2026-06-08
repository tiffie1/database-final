<?php
$conn = mysqli_connect("localhost", "root", "", "MovieData");

if (!$conn) {
    die("<p>Error de conexión: " . mysqli_connect_error() . "</p>");
}

mysqli_set_charset($conn, "utf8mb4");

/* =========================================================
 * DEFINICIÓN DE ENTIDADES Y SUS CAMPOS
 * ========================================================= */
$entities = [
    "Media" => [
        "table"  => "Media",
        "id"     => "MediaID",
        "fields" => [
            ["col" => "Title",               "label" => "Título",                   "type" => "text",   "required" => true],
            ["col" => "MediaType",           "label" => "Tipo (movie / series)",    "type" => "text",   "required" => false],
            ["col" => "HiddenGemScore",      "label" => "Hidden Gem Score",         "type" => "number", "required" => false],
            ["col" => "MinMinutes",          "label" => "Duración mínima (mins)",   "type" => "number", "required" => false],
            ["col" => "MaxMinutes",          "label" => "Duración máxima (mins)",   "type" => "number", "required" => false],
            ["col" => "ViewRating",          "label" => "View Rating (ej. PG-13)",  "type" => "text",   "required" => false],
            ["col" => "IMDbScore",           "label" => "Puntuación IMDb",          "type" => "number", "required" => false],
            ["col" => "RottenTomatoesScore", "label" => "Rotten Tomatoes Score",    "type" => "number", "required" => false],
            ["col" => "MetacriticScore",     "label" => "Metacritic Score",         "type" => "number", "required" => false],
            ["col" => "AwardsReceived",      "label" => "Premios Recibidos",        "type" => "number", "required" => false],
            ["col" => "AwardsNominated",     "label" => "Nominaciones",             "type" => "number", "required" => false],
            ["col" => "BoxOffice",           "label" => "Box Office (USD)",         "type" => "number", "required" => false],
            ["col" => "ReleaseDate",         "label" => "Fecha de estreno",         "type" => "date",   "required" => false],
            ["col" => "NetflixReleaseDate",  "label" => "Fecha estreno en Netflix", "type" => "date",   "required" => false],
            ["col" => "Summary",             "label" => "Resumen",                  "type" => "text",   "required" => false],
            ["col" => "IMDbVotes",           "label" => "Votos IMDb",               "type" => "number", "required" => false],
        ]
    ],
    "MediaLinks" => [
        "table"  => "MediaLinks",
        "id"     => "LinkID",
        "fields" => [
            ["col" => "NetflixLink", "label" => "Enlace Netflix", "type" => "text", "required" => false],
            ["col" => "IMDBLink",    "label" => "Enlace IMDb",    "type" => "text", "required" => false],
            ["col" => "Image",       "label" => "URL de imagen",  "type" => "text", "required" => false],
            ["col" => "Poster",      "label" => "URL de póster",  "type" => "text", "required" => false],
        ]
    ],
    "MediaTrailer" => [
        "table"  => "MediaTrailer",
        "id"     => "TrailerID",
        "fields" => [
            ["col" => "IMDbTrailer", "label" => "URL Trailer IMDb",  "type" => "text", "required" => false],
            ["col" => "TrailerSite", "label" => "Sitio del Trailer", "type" => "text", "required" => false],
        ]
    ],
    "Actor" => [
        "table"  => "Actor",
        "id"     => "ActorID",
        "fields" => [["col" => "ActorName", "label" => "Nombre del Actor", "type" => "text", "required" => true]]
    ],
    "Country" => [
        "table"  => "Country",
        "id"     => "CountryID",
        "fields" => [["col" => "CountryName", "label" => "Nombre del País", "type" => "text", "required" => true]]
    ],
    "Director" => [
        "table"  => "Director",
        "id"     => "DirectorID",
        "fields" => [["col" => "DirectorName", "label" => "Nombre del Director", "type" => "text", "required" => true]]
    ],
    "Genre" => [
        "table"  => "Genre",
        "id"     => "GenreID",
        "fields" => [["col" => "GenreName", "label" => "Nombre del Género", "type" => "text", "required" => true]]
    ],
    "Language" => [
        "table"  => "Language",
        "id"     => "LanguageID",
        "fields" => [["col" => "LanguageName", "label" => "Nombre del Idioma", "type" => "text", "required" => true]]
    ],
    "ProductionHouse" => [
        "table"  => "ProductionHouse",
        "id"     => "ProductionHouseID",
        "fields" => [["col" => "ProductionHouseName", "label" => "Nombre de la Productora", "type" => "text", "required" => true]]
    ],
    "Tag" => [
        "table"  => "Tag",
        "id"     => "TagID",
        "fields" => [["col" => "TagName", "label" => "Nombre del Tag", "type" => "text", "required" => true]]
    ],
    "Writer" => [
        "table"  => "Writer",
        "id"     => "WriterID",
        "fields" => [["col" => "WriterName", "label" => "Nombre del Escritor", "type" => "text", "required" => true]]
    ],
];

/* =========================================================
 * QUERIES PREDEFINIDAS
 * ========================================================= */
// PARA DERECK: "Pon los queries tuyos aqui." - Emi
$queries = [
    ["label" => "1. Ver primeras 10 películas",
     "sql"   => "SELECT MediaID, Title, MediaType, IMDbScore FROM Media LIMIT 10"],
    ["label" => "2. Películas con mayor puntuación IMDb",
     "sql"   => "SELECT MediaID, Title, IMDbScore FROM Media ORDER BY IMDbScore DESC LIMIT 10"],
    ["label" => "3. Actores y sus películas",
     "sql"   => "SELECT a.ActorName, m.Title FROM Actor a JOIN Acts_In ai ON a.ActorID = ai.ActorID JOIN Media m ON ai.MediaID = m.MediaID LIMIT 10"],
    ["label" => "4. Géneros disponibles",
     "sql"   => "SELECT GenreID, GenreName FROM Genre LIMIT 10"],
    ["label" => "5. Películas por director",
     "sql"   => "SELECT d.DirectorName, m.Title FROM Director d JOIN Directs di ON d.DirectorID = di.DirectorID JOIN Media m ON di.MediaID = m.MediaID LIMIT 10"],
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
$selectedEntity = array_key_first($entities);

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"]) && $_POST["action"] === "insert") {
    if (isset($_POST["entity"]) && array_key_exists($_POST["entity"], $entities)) {
        $selectedEntity = $_POST["entity"];
        $entityDef      = $entities[$selectedEntity];
        $cols = [];
        $vals = [];

        foreach ($entityDef["fields"] as $field) {
            $col      = $field["col"];
            $rawValue = isset($_POST[$col]) ? trim($_POST[$col]) : "";
            $cols[]   = "`$col`";
            $vals[]   = ($rawValue === "") ? "NULL" : "'" . mysqli_real_escape_string($conn, $rawValue) . "'";
        }

        $insertSQL = "INSERT INTO `{$entityDef['table']}` (" . implode(", ", $cols) . ") VALUES (" . implode(", ", $vals) . ")";

        if (mysqli_query($conn, $insertSQL)) {
            $insertSuccess = "¡Datos insertados! Nuevo ID en {$selectedEntity}: " . mysqli_insert_id($conn);
        } else {
            $insertError = mysqli_error($conn);
        }
    }
}

/* =========================================================
 * MANEJO: BUSCAR FILA PARA EDITAR
 * ---------------------------------------------------------
 * Cuando el usuario busca por ID, se carga la fila completa
 * en el formulario de edición para que pueda modificarla.
 * ========================================================= */
$editRow         = null;   // La fila encontrada para editar
$editError       = null;   // Error al buscar o al guardar
$editSuccess     = null;   // Confirmación de edición exitosa
$editEntity      = array_key_first($entities);
$editSearchedID  = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"])) {

    // --- Buscar fila por ID ---
    if ($_POST["action"] === "search_edit") {
        if (isset($_POST["edit_entity"]) && array_key_exists($_POST["edit_entity"], $entities)) {
            $editEntity     = $_POST["edit_entity"];
            $editSearchedID = trim($_POST["edit_id"]);
            $def            = $entities[$editEntity];
            $safeID         = (int) $editSearchedID;

            $searchSQL = "SELECT * FROM `{$def['table']}` WHERE `{$def['id']}` = $safeID LIMIT 1";
            $result    = mysqli_query($conn, $searchSQL);

            if ($result && mysqli_num_rows($result) > 0) {
                // Guardar la fila encontrada para pre-llenar el formulario
                $editRow = mysqli_fetch_assoc($result);
            } else {
                $editError = "No se encontró ningún registro con ID $safeID en $editEntity.";
            }
        }
    }

    // --- Guardar cambios de edición ---
    if ($_POST["action"] === "save_edit") {
        if (isset($_POST["edit_entity"]) && array_key_exists($_POST["edit_entity"], $entities)) {
            $editEntity = $_POST["edit_entity"];
            $def        = $entities[$editEntity];
            $safeID     = (int) $_POST["edit_record_id"];
            $setParts   = [];

            // Construir el SET del UPDATE dinámicamente igual que el INSERT
            foreach ($def["fields"] as $field) {
                $col      = $field["col"];
                $rawValue = isset($_POST[$col]) ? trim($_POST[$col]) : "";
                $escaped  = mysqli_real_escape_string($conn, $rawValue);
                $setParts[] = "`$col` = " . ($rawValue === "" ? "NULL" : "'$escaped'");
            }

            $updateSQL = "UPDATE `{$def['table']}` SET " . implode(", ", $setParts) . " WHERE `{$def['id']}` = $safeID";

            if (mysqli_query($conn, $updateSQL)) {
                $editSuccess = "¡Registro $safeID en $editEntity actualizado correctamente!";
                // Recargar la fila actualizada para mostrarla en el formulario
                $result  = mysqli_query($conn, "SELECT * FROM `{$def['table']}` WHERE `{$def['id']}` = $safeID LIMIT 1");
                $editRow = mysqli_fetch_assoc($result);
                $editSearchedID = $safeID;
            } else {
                $editError = mysqli_error($conn);
                // Mantener los datos en el formulario para que el usuario pueda corregir
                $editRow = [];
                foreach ($def["fields"] as $field) {
                    $editRow[$field["col"]] = isset($_POST[$field["col"]]) ? $_POST[$field["col"]] : "";
                }
                $editRow[$def["id"]] = $safeID;
                $editSearchedID = $safeID;
            }
        }
    }
}

/* =========================================================
 * MANEJO: QUERY LIBRE
 * ---------------------------------------------------------
 * Acepta cualquier query escrito por el usuario.
 * Si detecta DROP, DELETE, o TRUNCATE, requiere confirmación
 * explícita antes de ejecutar (ver JS abajo).
 * ========================================================= */
$freeQueryResult  = null;   // Filas devueltas por SELECT
$freeQueryError   = null;   // Error del query
$freeQuerySuccess = null;   // Confirmación para no-SELECT
$freeQueryInput   = "";     // Para mantener el texto en el textarea

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"]) && $_POST["action"] === "free_query") {
    $freeQueryInput    = trim($_POST["free_sql"]);
    $confirmedDangerous = isset($_POST["confirmed_dangerous"]) && $_POST["confirmed_dangerous"] === "1";

    // Detectar si el query contiene operaciones destructivas
    // (insensible a mayúsculas con preg_match)
    $isDangerous = (bool) preg_match('/\b(DROP|TRUNCATE)\b/i', $freeQueryInput);

    if ($isDangerous && !$confirmedDangerous) {
        // No ejecutar — el JS debería haber pedido confirmación,
        // pero si llega aquí sin confirmar se bloquea igual en el servidor.
        $freeQueryError = "El query contiene DROP o TRUNCATE. Confirma la operación antes de ejecutar.";
    } else {
        $result = mysqli_query($conn, $freeQueryInput);

        if ($result === true) {
            // Query ejecutado correctamente pero no devuelve filas (INSERT, UPDATE, DELETE, DROP...)
            $freeQuerySuccess = "Query ejecutado. Filas afectadas: " . mysqli_affected_rows($conn);
        } elseif ($result === false) {
            $freeQueryError = mysqli_error($conn);
        } else {
            // Es un SELECT o similar, devuelve un result set
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
</head>
<body>

<header>
    <h1>Consultas y Gestión de Datos</h1>
    <nav>
        <a href="index.php"><font color='#256BEF'><u>← Volver al Informe</u></font></a>
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
            <p style="color:red;">Error: <?php echo htmlspecialchars($queryError); ?></p>
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
         ===================================================== -->
    <section id="insertar">
        <h2>Insertar nuevo registro</h2>
        <p>Selecciona la entidad, completa los campos y haz clic en <strong>Insertar</strong>.</p>

        <!--
            El div #insertBanner está oculto por defecto.
            PHP inyecta el mensaje de éxito/error en él y el JS
            lo hace visible con una animación al cargar la página.
        -->
        <div id="insertBanner" style="display:none; padding:10px; border-radius:5px; margin-bottom:10px;">
            <?php if ($insertSuccess !== null): ?>
                <span style="color:green; font-weight:bold;">✔ <?php echo htmlspecialchars($insertSuccess); ?></span>
            <?php elseif ($insertError !== null): ?>
                <span style="color:red; font-weight:bold;">✘ Error: <?php echo htmlspecialchars($insertError); ?></span>
            <?php endif; ?>
        </div>

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
                                    <label for="insert_<?php echo $field['col']; ?>">
                                        <?php echo htmlspecialchars($field['label']); ?>
                                        <?php echo $field['required'] ? ' *' : ''; ?>
                                    </label>
                                </td>
                                <td>
                                    <input
                                        type="<?php echo $field['type']; ?>"
                                        id="insert_<?php echo $field['col']; ?>"
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
    </section>

    <!-- =====================================================
         SECCIÓN 3: MODIFICAR REGISTROS
         ---------------------------------------------------------
         Flujo:
           1. Usuario elige entidad e ingresa un ID → "Buscar"
           2. Se carga la fila en un formulario pre-llenado
           3. Usuario edita y hace clic en "Guardar cambios"
         ===================================================== -->
    <section id="editar">
        <h2>Modificar registro existente</h2>
        <p>Selecciona la entidad, ingresa el ID del registro a modificar y haz clic en
            <strong>Buscar</strong>.</p>

        <!-- Paso 1: Formulario de búsqueda por ID -->
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

        <!-- Paso 2: Formulario de edición — solo aparece si se encontró la fila -->
        <?php if ($editRow !== null): ?>
            <?php $def = $entities[$editEntity]; ?>
            <hr>
            <p>Editando <strong><?php echo htmlspecialchars($editEntity); ?></strong>
               con ID <strong><?php echo htmlspecialchars($editSearchedID); ?></strong>:</p>

            <form method="POST" action="">
                <input type="hidden" name="action"         value="save_edit">
                <input type="hidden" name="edit_entity"    value="<?php echo htmlspecialchars($editEntity); ?>">
                <!-- Guardar el ID del registro que se está editando -->
                <input type="hidden" name="edit_record_id" value="<?php echo htmlspecialchars($editSearchedID); ?>">

                <table>
                    <?php foreach ($def["fields"] as $field): ?>
                        <?php
                            // Pre-llenar cada campo con el valor actual de la base de datos
                            $currentVal = isset($editRow[$field["col"]]) ? $editRow[$field["col"]] : "";
                        ?>
                        <tr>
                            <td><label><?php echo htmlspecialchars($field['label']); ?></label></td>
                            <td>
                                <input
                                    type="<?php echo $field['type']; ?>"
                                    name="<?php echo $field['col']; ?>"
                                    value="<?php echo htmlspecialchars((string)$currentVal); ?>"
                                    <?php echo $field['required'] ? 'required' : ''; ?>
                                    <?php echo $field['type'] === 'number' ? 'step="any"' : ''; ?>
                                >
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>

                <button type="submit">Guardar cambios</button>
            </form>
        <?php endif; ?>
    </section>

    <!-- =====================================================
         SECCIÓN 4: QUERY LIBRE
         ---------------------------------------------------------
         Permite escribir cualquier query SQL.
         DROP y TRUNCATE requieren confirmación explícita
         antes de enviarse al servidor.
         ===================================================== -->
    <section id="query-libre">
        <h2>Query libre</h2>
        <p>Escribe cualquier query SQL. <strong style="color:red;">DROP y TRUNCATE
            pedirán confirmación antes de ejecutarse.</strong></p>

        <!--
            El campo oculto "confirmed_dangerous" empieza en 0.
            Si el JS detecta DROP/TRUNCATE y el usuario confirma,
            lo cambia a 1 antes de hacer submit.
            El servidor verifica este valor como segunda capa de seguridad.
        -->
        <form method="POST" action="" id="freeQueryForm">
            <input type="hidden" name="action"               value="free_query">
            <input type="hidden" name="confirmed_dangerous"  id="confirmedDangerous" value="0">

            <textarea name="free_sql" id="freeSqlInput" rows="5"
                      style="width:100%; font-family:monospace;"
                      placeholder="SELECT * FROM Media LIMIT 5;"
            ><?php echo htmlspecialchars($freeQueryInput); ?></textarea>

            <br>
            <button type="submit" id="freeQuerySubmit">Ejecutar query</button>
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
                    <tr>
                        <?php foreach (array_keys($freeQueryResult[0]) as $col): ?>
                            <th><?php echo htmlspecialchars($col); ?></th>
                        <?php endforeach; ?>
                    </tr>
                    <?php foreach ($freeQueryResult as $row): ?>
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

</main>

<footer>
    <p>Proyecto de Base de Datos | <?php echo date("Y"); ?></p>
</footer>

<script>
/* =========================================================
 * JS: DROPDOWN DE ENTIDAD EN INSERTAR
 * ---------------------------------------------------------
 * Al cambiar de entidad, además de mostrar/ocultar los divs,
 * se habilitan/deshabilitan los inputs para que el browser
 * no valide campos required de entidades no seleccionadas.
 * ========================================================= */
const entitySelect = document.getElementById('entitySelect');
const entityKeys   = <?php echo json_encode(array_keys($entities)); ?>;

function switchEntity(selectedKey) {
    entityKeys.forEach(key => {
        const div    = document.getElementById('fields-' + key);
        const inputs = div.querySelectorAll('input');

        if (key === selectedKey) {
            // Mostrar y habilitar
            div.style.display = 'block';
            inputs.forEach(input => input.removeAttribute('disabled'));
        } else {
            // Ocultar y deshabilitar — campos disabled no se validan
            // ni se envían en el POST, así que no interfieren
            div.style.display = 'none';
            inputs.forEach(input => input.setAttribute('disabled', 'disabled'));
        }
    });
}

// Ejecutar al cargar la página para deshabilitar los divs ocultos iniciales
switchEntity(entitySelect.value);

// Ejecutar cada vez que el usuario cambia la entidad
entitySelect.addEventListener('change', function () {
    switchEntity(this.value);
});
/* =========================================================
 * JS: BANNER DE INSERCIÓN EXITOSA
 * ---------------------------------------------------------
 * Si PHP dejó contenido en el banner (éxito o error),
 * se hace visible con una transición suave.
 * Se oculta automáticamente después de 5 segundos.
 * ========================================================= */
const insertBanner = document.getElementById('insertBanner');
if (insertBanner && insertBanner.innerHTML.trim() !== '') {
    insertBanner.style.display = 'block';
    insertBanner.style.transition = 'opacity 0.5s';
    insertBanner.style.opacity = '1';

    // Desvanecer y ocultar después de 5 segundos
    setTimeout(() => {
        insertBanner.style.opacity = '0';
        setTimeout(() => insertBanner.style.display = 'none', 500);
    }, 5000);
}

/* =========================================================
 * JS: CONFIRMACIÓN PARA DROP / TRUNCATE EN QUERY LIBRE
 * ---------------------------------------------------------
 * Antes de hacer submit, se revisa el texto del query.
 * Si contiene DROP o TRUNCATE, se muestra un confirm()
 * que detalla exactamente qué va a ejecutarse para que
 * el usuario sepa lo que está por borrar.
 * Solo si confirma, se pone confirmed_dangerous=1 y se envía.
 * ========================================================= */
document.getElementById('freeQueryForm').addEventListener('submit', function (e) {
    const sql       = document.getElementById('freeSqlInput').value;
    const dangerous = /\b(DROP|TRUNCATE)\b/i.test(sql);

    if (dangerous) {
        // Cancelar el submit inmediatamente
        e.preventDefault();

        // Mostrar exactamente qué se va a ejecutar en el confirm
        const confirmed = window.confirm(
            "⚠️ ADVERTENCIA: El query contiene DROP o TRUNCATE.\n\n" +
            "Esto eliminará datos de forma permanente.\n\n" +
            "Query a ejecutar:\n" + sql + "\n\n" +
            "¿Estás seguro de que quieres continuar?"
        );

        if (confirmed) {
            // Marcar como confirmado y reenviar el formulario
            document.getElementById('confirmedDangerous').value = '1';
            this.submit();
        }
        // Si no confirma, no pasa nada — el formulario no se envía
    }
});
</script>

</body>
</html>

<?php mysqli_close($conn); ?>

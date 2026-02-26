<?php
$tokenId = "0.0.10239758";

// Obtener datos del token
$_GET['id'] = $tokenId;
ob_start();
include dirname(__FILE__) . "/token.php";
$tokenJson = ob_get_clean();

// DEBUG: ver JSON crudo
// echo "<pre>".$tokenJson."</pre>";

$tokenData = json_decode($tokenJson, true);

// Función recursiva mejorada
function mostrarMetadata($data) {
    if (is_array($data)) {
        echo "<ul>";
        foreach ($data as $key => $value) {
            echo "<li><strong>" . htmlspecialchars($key) . ":</strong> ";

            if (is_array($value)) {
                mostrarMetadata($value);
            } else {
                echo htmlspecialchars($value);
            }

            echo "</li>";
        }
        echo "</ul>";
    } else {
        echo htmlspecialchars($data);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Metadata Token</title>
</head>
<body>

<h1>Metadata completa del token</h1>

<?php
if ($tokenData) {

    // ?? CLAVE: detectar dónde están realmente los datos
    if (isset($tokenData['metadata'])) {
        mostrarMetadata($tokenData['metadata']);
    } elseif (isset($tokenData['data'])) {
        mostrarMetadata($tokenData['data']);
    } else {
        // fallback ? mostrar todo
        mostrarMetadata($tokenData);
    }

} else {
    echo "? No hay datos o JSON inválido";
}
?>

<br>

<!-- Botones naranja -->
<button style="background-color: orange; color: white; border: none; padding: 10px 18px; border-radius: 6px; cursor: pointer;">
    Comprar
</button>

<button style="background-color: orange; color: white; border: none; padding: 10px 18px; border-radius: 6px; cursor: pointer;">
    Vender
</button>

<hr>

<h3>DEBUG (muy importante)</h3>
<pre>
<?php
print_r($tokenData);
?>
</pre>

</body>
</html>

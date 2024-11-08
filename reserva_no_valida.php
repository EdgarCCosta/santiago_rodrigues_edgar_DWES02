<?php
session_start();
$validacion = $_SESSION['validacion'] ?? [];

echo "<h2>Errores en la Reserva</h2><ul>";
foreach ($validacion as $campo => $resultado) {
    $color = $resultado["estado"] == "correcto" ? "green" : "red";
    echo "<li style='color:{$color};'>{$resultado["mensaje"]}</li>";
}
echo "</ul>";
?>

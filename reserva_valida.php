<?php
session_start();

$reserva = $_SESSION['reserva'];
$modelo = strtolower($reserva['modelo']);
$imagen = "img/{$modelo}.jpg";

echo "<h2>Reserva Confirmada</h2>";
echo "<p>Nombre: {$reserva['nombre']} {$reserva['apellido']}</p>";
echo "<img src='$imagen' alt='{$reserva['modelo']}' style='width:300px; height:auto;'>";

unset($_SESSION['reserva']);
?>

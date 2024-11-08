<?php
session_start();
require './library/libVehiculos.php';

// Función para validar el DNI usando módulo 23
function validarDNI($dni) {
    $letras = "TRWAGMYFPDXBNJZSQVHLCKE";
    $numero = substr($dni, 0, -1);
    $letra = strtoupper(substr($dni, -1));
    return strlen($dni) == 9 && is_numeric($numero) && $letra == $letras[$numero % 23];
}

// Función para verificar si el usuario existe
function usuarioExiste($nombre, $apellido, $dni) {
    foreach (USUARIOS as $usuario) {
        if ($usuario["nombre"] == $nombre && $usuario["apellido"] == $apellido && $usuario["dni"] == $dni) {
            return true;
        }
    }
    return false;
}

// Función para verificar si el coche está disponible
function cocheDisponible($modelo, $fecha_inicio, $duracion) {
    global $coches;
    foreach ($coches as $coche) {
        if ($coche["modelo"] == $modelo) {
            $fecha_fin = date('Y-m-d', strtotime("$fecha_inicio + $duracion days - 1 day"));
            if ($coche["disponible"] &&
                (!$coche["fecha_inicio"] || $fecha_fin < $coche["fecha_inicio"] || $fecha_inicio > $coche["fecha_fin"])) {
                return true;
            }
        }
    }
    return false;
}

// Recibir y validar datos del formulario
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$dni = $_POST['dni'];
$modelo = $_POST['modelo'];
$fecha_inicio = $_POST['fecha_inicio'];
$duracion = $_POST['duracion'];

$validacion = [];

// Validacar usuario
$validacion['nombre_apellido'] = (empty($nombre) || empty($apellido)) ? 
    ["mensaje" => "El nombre y apellido no pueden estar vacíos.", "estado" => "incorrecto"] : 
    ["mensaje" => "Nombre y apellido correctos.", "estado" => "correcto"];

$validacion['dni'] = (!validarDNI($dni)) ? 
    ["mensaje" => "El DNI no es válido.", "estado" => "incorrecto"] : 
    ["mensaje" => "DNI válido.", "estado" => "correcto"];

$validacion['usuario'] = (!usuarioExiste($nombre, $apellido, $dni)) ? 
    ["mensaje" => "El usuario no está registrado.", "estado" => "incorrecto"] : 
    ["mensaje" => "Usuario registrado.", "estado" => "correcto"];

$validacion['fecha_inicio'] = ($fecha_inicio <= date('Y-m-d')) ? 
    ["mensaje" => "La fecha de inicio debe ser posterior a hoy.", "estado" => "incorrecto"] : 
    ["mensaje" => "Fecha de inicio válida.", "estado" => "correcto"];

$validacion['duracion'] = (!is_numeric($duracion) || $duracion < 1 || $duracion > 30 || floor($duracion) != $duracion) ? 
    ["mensaje" => "La duración debe ser un número entero entre 1 y 30 días.", "estado" => "incorrecto"] : 
    ["mensaje" => "Duración válida.", "estado" => "correcto"];

$validacion['vehiculo'] = (!cocheDisponible($modelo, $fecha_inicio, $duracion)) ? 
    ["mensaje" => "El vehículo no está disponible para las fechas seleccionadas.", "estado" => "incorrecto"] : 
    ["mensaje" => "Vehículo disponible.", "estado" => "correcto"];

// Guardar la validación y los datos en sesión
$_SESSION['validacion'] = $validacion;
$_SESSION['reserva'] = [
    'nombre' => $nombre,
    'apellido' => $apellido,
    'dni' => $dni,
    'modelo' => $modelo,
    'fecha_inicio' => $fecha_inicio,
    'duracion' => $duracion
];


$hayErrores = false;
foreach ($validacion as $item) {
    if ($item['estado'] === 'incorrecto') {
        $hayErrores = true;
        break;
    }
}

// Redirigir en función si hay errores
if ($hayErrores) {
    echo "<script>window.location.href = 'reserva_no_valida.php';</script>";
} else {
    echo "<script>window.location.href = 'reserva_valida.php';</script>";
}
exit();
?>
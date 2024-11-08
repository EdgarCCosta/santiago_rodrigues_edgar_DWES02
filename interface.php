<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserva de Vehículo</title>
    <link rel="stylesheet" href="./css/styles.css">
</head>
<body>

<h2>Formulario de Reserva de Vehículo</h2>
<form action="reserva.php" method="post">

    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre"><br><br>

    <label for="apellido">Apellido:</label>
    <input type="text" id="apellido" name="apellido"><br><br>

    <label for="dni">DNI:</label>
    <input type="text" id="dni" name="dni"><br><br>

    <label for="modelo">Modelo del Vehículo:</label>
    <select id="modelo" name="modelo">
        <option value="Lancia Stratos">Lancia Stratos</option>
        <option value="Audi Quattro">Audi Quattro</option>
        <option value="Ford Escort RS1800">Ford Escort RS1800</option>
        <option value="Subaru Impreza 555">Subaru Impreza 555</option>
    </select><br><br>

    <label for="fecha_inicio">Fecha de Inicio de Reserva:</label>
    <input type="date" id="fecha_inicio" name="fecha_inicio"><br><br>

    <label for="duracion">Duración de Reserva (días):</label>
    <input type="number" id="duracion" name="duracion"><br><br>

    <button type="submit">Enviar Reserva</button>
</form>

</body>
</html>

<?php 
$conexion = new mysqli("localhost", "root", "", "mibase");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}


// Guardar nuevo usuario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["guardar"])) {
    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $conexion->query("INSERT INTO usuarios (nombre, correo) VALUES ('$nombre', '$correo')");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Formulario de Usuarios</title>
</head>
<body>
    <h2>Captura de Información</h2>
    <form method="post">
        Nombre: <input type="text" name="nombre" required><br>
        Correo: <input type="email" name="correo" required><br>
        <input type="submit" name="guardar" value="Guardar">
    </form>

    <form method="post" style="margin-top:20px;">
        <input type="submit" name="ver_usuarios" value="Ver Usuarios">
    </form>

    <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["ver_usuarios"])): ?>
        <h2>Usuarios Registrados</h2>
        <ul>
            <?php
            $resultado = $conexion->query("SELECT * FROM usuarios");
            while ($fila = $resultado->fetch_assoc()) {
                echo "<li>{$fila['nombre']} - {$fila['correo']}</li>";
            }
            ?>
        </ul>
    <?php endif; ?>
</body>
</html>

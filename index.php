<?php
// Mostrar errores para depuración (quítalos en producción)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Datos de conexión proporcionados por Azure
$server = "tcp:elservidor-1.database.windows.net,1433";
$database = "basedatos";
$username = "usuarioserver";
$password = "Estaesla34"; // <- Cambia esto por tu contraseña real

try {
    $conexion = new PDO("sqlsrv:server=$server;Database=$database", $username, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Insertar usuario si se envió el formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["guardar"])) {
        $nombre = $_POST["nombre"];
        $correo = $_POST["correo"];
        $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, correo) VALUES (?, ?)");
        $stmt->execute([$nombre, $correo]);
    }
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
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
            $stmt = $conexion->query("SELECT nombre, correo FROM usuarios");
            while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<li>{$fila['nombre']} - {$fila['correo']}</li>";
            }
            ?>
        </ul>
    <?php endif; ?>
</body>
</html>


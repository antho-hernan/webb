<?php
$host = "localhost";
$user = "root";
$pass = ""; // Cambia si tienes contraseña en MySQL
$db = "registro";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $conn->real_escape_string($_POST["nombre"]);
    $apellido = $conn->real_escape_string($_POST["apellido"]);
    $correo = $conn->real_escape_string($_POST["correo"]);
    $cedula = $conn->real_escape_string($_POST["cedula"]);

    // Insertar datos en tablas separadas
    $conn->query("INSERT INTO nombres (nombre) VALUES ('$nombre')");
    $nombre_id = $conn->insert_id;

    $conn->query("INSERT INTO apellidos (apellido) VALUES ('$apellido')");
    $apellido_id = $conn->insert_id;

    $conn->query("INSERT INTO correos (correo) VALUES ('$correo')");
    $correo_id = $conn->insert_id;

    $conn->query("INSERT INTO cedulas (cedula) VALUES ('$cedula')");
    $cedula_id = $conn->insert_id;

    // Relacionarlos en la tabla usuarios
    $conn->query("INSERT INTO usuarios (nombre_id, apellido_id, correo_id, cedula_id)
                  VALUES ($nombre_id, $apellido_id, $correo_id, $cedula_id)");

    $mensaje = "Registro exitoso";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario Detallado</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f6f8;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .formulario {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 450px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .campo {
            margin-bottom: 15px;
        }

        label {
            font-weight: 600;
            margin-bottom: 5px;
            display: block;
        }

        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        input[type="submit"] {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #2980b9;
        }

        .mensaje {
            margin-top: 20px;
            text-align: center;
            color: green;
        }
    </style>
</head>
<body>

<div class="formulario">
    <h2>Registro Detallado</h2>

    <?php if (!empty($mensaje)) echo "<p class='mensaje'>$mensaje</p>"; ?>

    <form method="post">
        <div class="campo">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" required>
        </div>

        <div class="campo">
            <label for="apellido">Apellido:</label>
            <input type="text" name="apellido" required>
        </div>

        <div class="campo">
            <label for="correo">Correo electrónico:</label>
            <input type="email" name="correo" required>
        </div>

        <div class="campo">
            <label for="cedula">Cédula:</label>
            <input type="text" name="cedula" required>
        </div>

        <input type="submit" value="Registrar">
    </form>
</div>

</body>
</html>

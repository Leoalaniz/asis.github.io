<?php
// Incluir el archivo de conexión
include "../modelo/conexion.php";

// Verificar si se han enviado datos por POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos enviados desde el formulario
    $nombre = trim($_POST['nombre_estudiante'] ?? '');
    $email = trim($_POST['email_estudiante'] ?? '');
    $telefono = trim($_POST['telefono_estudiante'] ?? '');
    $genero = $_POST['genero'] ?? '';

    // Validar que no haya campos vacíos
    if (empty($nombre) || empty($email) || empty($telefono) || empty($genero)) {
        die("Error: Todos los campos son obligatorios.");
    }

    // Validar el formato del email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Error: El formato del correo electrónico no es válido.");
    }

    try {
        // Preparar la consulta SQL para insertar los datos
        $sql = "INSERT INTO estudiantes (nombre_estudiante, email_estudiante, telefono_estudiante, genero) 
                VALUES (?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);

        if (!$stmt) {
            die("Error al preparar la consulta: " . $conexion->error);
        }

        // Vincular los parámetros
        $stmt->bind_param('ssss', $nombre, $email, $telefono, $genero);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Redirigir con mensaje de éxito
            header("Location: ../estudiantes.php?mensaje=Estudiante registrado con éxito");
            exit;
        } else {
            die("Error al ejecutar la consulta: " . $stmt->error);
        }
    } catch (Exception $e) {
        die("Error inesperado: " . $e->getMessage());
    }
} else {
    die("Método no permitido.");
}
?>

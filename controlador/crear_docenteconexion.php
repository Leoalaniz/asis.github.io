<?php
// Incluir archivo de conexión
include "../modelo/conexion.php";

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre_docente = $_POST['nombre_docente'];
    $sexo = $_POST['sexo_docente'];
    $telefono = $_POST['telefono_docente'];
    $email = $_POST['email_docente'];
    $rol_docente = $_POST['rol_docente'];
    $usuario = $_POST['usuario_docente'];
    $password = $_POST['password_docente']; // Aquí no se ha cifrado la contraseña

    // Preparar la consulta SQL para insertar los datos
    $sql = "INSERT INTO docentes (nombre_docente, sexo_docente, telefono_docente, email_docente, rol_docente, usuario_docente, password_docente) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    // Preparar el statement y vincular los parámetros
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sssssss", $nombre_docente, $sexo, $telefono, $email, $rol_docente, $usuario, $password);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Redirigir a la página de lista de docentes después de insertar
        header("Location: ../crear_docente.php");
        exit();
    } else {
        echo "Error al registrar al docente: " . $stmt->error;
    }

    // Cerrar la conexión
    $stmt->close();
}
?>

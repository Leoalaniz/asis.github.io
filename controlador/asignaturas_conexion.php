<?php
include '../modelo/conexion.php'; // Asegúrate de que la ruta al archivo de conexión es correcta

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btnregistrar"])) {
    // Obtener los valores del formulario
    $nombre_asignatura = isset($_POST['nombre_asignatura']) ? $_POST['nombre_asignatura'] : null;
    $id_carrera = isset($_POST['id_carrera']) ? intval($_POST['id_carrera']) : null;

    // Verificar que los campos no sean nulos
    if ($nombre_asignatura && $id_carrera) {
        // Preparar la consulta de inserción
        $query_insert = "INSERT INTO asignatura (nombre_asignatura, id_carrera) VALUES (?, ?)";
        $stmt = $conexion->prepare($query_insert);

        // Vincular los parámetros y ejecutar la consulta
        $stmt->bind_param('si', $nombre_asignatura, $id_carrera);

        // Ejecutar la consulta y verificar el resultado
        if ($stmt->execute()) {
            // Redirigir a la página de lista de asignaturas (o donde quieras)
            header("Location: ../asignaturas.php");
            exit();
        } else {
            echo "Error al registrar la asignatura.";
        }

        // Cerrar la consulta preparada
        $stmt->close();
    } else {
        echo "Por favor complete todos los campos.";
    }
}

// Cerrar la conexión
$conexion->close();

// Redirigir en caso de error o si no se cumplen las condiciones
header("Location: ../asignaturas.php");
exit();
?>

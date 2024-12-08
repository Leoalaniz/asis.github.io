<?php
// Incluir el archivo de conexión
include "modelo/conexion.php";

// Verificar si se recibe el ID del estudiante
if (isset($_GET['id_estudiante'])) {
    $id_estudiante = intval($_GET['id_estudiante']);

    // Preparar la consulta de eliminación
    $sqlQuery = "DELETE FROM estudiantes WHERE id_estudiante = ?";
    $stmt = $conexion->prepare($sqlQuery);

    if ($stmt) {
        $stmt->bind_param("i", $id_estudiante);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Redirigir con mensaje de éxito
            header("Location: acciones.php?mensaje=Eliminado correctamente");
        } else {
            // Redirigir con mensaje de error
            header("Location: acciones.php?mensaje=Error: No se encontró el estudiante");
        }

        $stmt->close();
    } else {
        // Redirigir con mensaje de error
        header("Location: acciones.php?mensaje=Error en la consulta SQL");
    }
} else {
    // Redirigir si no se recibe el ID
    header("Location: acciones.php?mensaje=Error: ID no válido");
}

// Cerrar la conexión
$conexion->close();
exit;

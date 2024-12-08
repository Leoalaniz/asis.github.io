<?php
// Incluir el archivo de conexión
include "modelo/conexion.php";

// Verificar si se recibe el parámetro 'id_matricula'
if (isset($_GET['id_matricula']) && is_numeric($_GET['id_matricula'])) {
    $id_matricula = intval($_GET['id_matricula']); // Asegurarse de que sea un entero

    // Preparar la consulta SQL para eliminar
    $sqlQuery = "DELETE FROM matricula WHERE id_matricula = ?";

    if ($stmt = $conexion->prepare($sqlQuery)) {
        // Asociar el parámetro
        $stmt->bind_param("i", $id_matricula);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Redirigir a la página principal con un mensaje de éxito
            header("Location: acciones_matricula.php?mensaje=eliminado");
            exit();
        } else {
            // Mostrar mensaje de error si no se pudo eliminar
            echo "<div class='alert alert-danger'>Error al eliminar la matrícula: " . htmlspecialchars($conexion->error) . "</div>";
        }

        $stmt->close();
    } else {
        // Mostrar mensaje de error si la consulta no se preparó correctamente
        echo "<div class='alert alert-danger'>Error al preparar la consulta: " . htmlspecialchars($conexion->error) . "</div>";
    }
} else {
    // Redirigir si no se proporciona un ID válido
    header("Location: acciones_matricula.php?mensaje=error_id");
    exit();
}

// Cerrar la conexión
$conexion->close();
?>

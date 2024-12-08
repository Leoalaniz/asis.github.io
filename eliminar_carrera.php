<?php
// Incluir archivo de conexión
include "modelo/conexion.php";

// Verificar si el ID de la carrera está presente en la URL
if (isset($_GET['id_carrera'])) {
    // Obtener el ID de la carrera desde la URL
    $id_carrera = $_GET['id_carrera'];

    // Prepara la consulta SQL para eliminar el registro
    $sql = "DELETE FROM carrera WHERE id_carrera = ?";
    $stmt = $conexion->prepare($sql);

    // Vincula el parámetro (id) y ejecuta la consulta
    $stmt->bind_param("i", $id_carrera);
    $stmt->execute();

    // Verificar si se eliminó correctamente
    if ($stmt->affected_rows > 0) {
        // Redirigir a la página de lista de carreras después de eliminar
        header("Location: crear_carrera.php");
        exit();
    } else {
        // Si no se pudo eliminar, mostrar mensaje de error
        echo "Error al eliminar la carrera.";
    }

    // Cerrar la conexión
    $stmt->close();
}
?>

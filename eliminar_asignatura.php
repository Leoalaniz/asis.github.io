<?php
// Incluir archivo de conexión
include "modelo/conexion.php";

// Verificar si el ID de la carrera está presente en la URL
if (isset($_GET['id_asignatura'])) {
    // Obtener el ID de la carrera desde la URL
    $id_asignatura = $_GET['id_asignatura'];

    // Prepara la consulta SQL para eliminar el registro
    $sql = "DELETE FROM asignatura WHERE id_asignatura = ?";
    $stmt = $conexion->prepare($sql);

    // Vincula el parámetro (id) y ejecuta la consulta
    $stmt->bind_param("i", $id_asignatura);
    $stmt->execute();

    // Verificar si se eliminó correctamente
    if ($stmt->affected_rows > 0) {
        // Redirigir a la página de lista de carreras después de eliminar
        header("Location: acciones_asignatura.php");
        exit();
    } else {
        // Si no se pudo eliminar, mostrar mensaje de error
        echo "Error al eliminar la carrera.";
    }

    // Cerrar la conexión
    $stmt->close();
}
?>
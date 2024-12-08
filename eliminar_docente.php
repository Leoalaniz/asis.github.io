<?php
// Incluir archivo de conexión
include "modelo/conexion.php";

// Verificar si el ID del docente está presente en la URL
if (isset($_GET['id_docente'])) {
    // Obtener el ID del docente desde la URL
    $id_docente = $_GET['id_docente'];

    // Prepara la consulta SQL para eliminar el registro
    $sql = "DELETE FROM docentes WHERE id_docente = ?";
    $stmt = $conexion->prepare($sql);

    // Vincula el parámetro (id) y ejecuta la consulta
    $stmt->bind_param("i", $id_docente);
    $stmt->execute();

    // Verificar si se eliminó correctamente
    if ($stmt->affected_rows > 0) {
        // Redirigir a la página de lista de docentes después de eliminar
        header("Location: crear_docente.php");
        exit();
    } else {
        // Si no se pudo eliminar, mostrar mensaje de error
        echo "Error al eliminar el docente.";
    }

    // Cerrar la conexión
    $stmt->close();
}
?>

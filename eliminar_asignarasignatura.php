<?php
include 'modelo/conexion.php'; // Conexión a la base de datos

if (isset($_GET['id_asignar_asignatura'])) {
    $idAsignarAsignatura = intval($_GET['id_asignar_asignatura']);

    $query_delete = "DELETE FROM asignar_asignaturas WHERE id_asignar_asignatura = ?";
    $stmt = $conexion->prepare($query_delete);

    if ($stmt) {
        $stmt->bind_param('i', $idAsignarAsignatura);
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                header("Location: asignar_asignatura.php?mensaje=eliminado");
            } else {
                header("Location: asignar_asignatura.php?mensaje=no_encontrado");
            }
        } else {
            echo "Error al ejecutar la consulta: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $conexion->error;
    }
} else {
    header("Location: asignar_asignatura.php?mensaje=sin_id");
}

$conexion->close();
?>

<?php
include '../modelo/conexion.php'; // Asegúrate de que la ruta al archivo de conexión es correcta

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btnregistrar"])) {
    $id_docente = isset($_POST['id_docente']) ? intval($_POST['id_docente']) : null;
    $id_asignatura = isset($_POST['id_asignatura']) ? intval($_POST['id_asignatura']) : null;

    if ($id_docente && $id_asignatura) {
        // Inserción en la tabla asignar_asignaturas
        $query_insert = "INSERT INTO asignar_asignaturas (id_docente, id_asignatura) VALUES (?, ?)";
        $stmt = $conexion->prepare($query_insert);
        $stmt->bind_param('ii', $id_docente, $id_asignatura);

        if ($stmt->execute()) {
            // Redirigir a la página de lista de asignaciones
            header("Location: ../asignar_asignatura.php");
            exit();
        }

        $stmt->close();
    }
}

// Cierra la conexión
$conexion->close();

// En caso de que no se cumplan las condiciones, redirige también
header("Location: ../asignar_asignatura.php");
exit();
?>

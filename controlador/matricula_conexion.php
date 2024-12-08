<?php
include '../modelo/conexion.php'; // Ajusta la ruta según tu estructura

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_estudiante = isset($_POST['id_estudiante']) ? intval($_POST['id_estudiante']) : null;
    $id_asignar_asignatura = isset($_POST['id_asignar_asignatura']) ? trim($_POST['id_asignar_asignatura']) : null;
    $semestre = isset($_POST['semestre']) ? trim($_POST['semestre']) : null;
    $anio = isset($_POST['anio']) ? intval($_POST['anio']) : null;
    $estado = isset($_POST['estado']) ? trim($_POST['estado']) : null;

    // Separar id_docente e id_asignatura
    if ($id_asignar_asignatura) {
        list($id_docente, $id_asignatura) = explode('-', $id_asignar_asignatura);
        $id_docente = intval($id_docente);
        $id_asignatura = intval($id_asignatura);
    } else {
        error_log("No se proporcionó un id_asignar_asignatura válido.");
        header("Location: ../matricula.php?error=invalid_selection");
        exit;
    }

    // Validar que todos los datos sean válidos
    if ($id_estudiante && $id_docente && $id_asignatura && $semestre && $anio && $estado) {
        // Verificar que la combinación de id_docente e id_asignatura exista en la tabla asignar_asignaturas
        $stmt_check = $conexion->prepare("SELECT COUNT(*) FROM asignar_asignaturas WHERE id_docente = ? AND id_asignatura = ?");
        $stmt_check->bind_param("ii", $id_docente, $id_asignatura);
        $stmt_check->execute();
        $stmt_check->bind_result($count);
        $stmt_check->fetch();
        $stmt_check->close();

        if ($count > 0) {
            // Insertar el registro en la tabla matricula
            $stmt = $conexion->prepare("INSERT INTO matricula (id_estudiante, id_docente, id_asignatura, semestre, anio, estado) VALUES (?, ?, ?, ?, ?, ?)");
            if ($stmt) {
                $stmt->bind_param("iiisis", $id_estudiante, $id_docente, $id_asignatura, $semestre, $anio, $estado);
                if ($stmt->execute()) {
                    header("Location: ../matricula.php?success=1");
                    exit;
                } else {
                    error_log("Error al registrar la matrícula: " . $stmt->error);
                }
                $stmt->close();
            } else {
                error_log("Error al preparar la consulta: " . $conexion->error);
            }
        } else {
            // La combinación de docente y asignatura no existe
            error_log("La combinación de id_docente ($id_docente) y id_asignatura ($id_asignatura) no existe en asignar_asignaturas.");
            header("Location: ../matricula.php?error=invalid_combination");
            exit;
        }
    } else {
        error_log("Datos incompletos proporcionados en el formulario.");
        header("Location: ../matricula.php?error=missing_data");
        exit;
    }
}

// Si ocurre algún error, redirigir igualmente
header("Location: ../matricula.php?error=general");
exit;

$conexion->close();
?>

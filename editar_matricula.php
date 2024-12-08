<?php
// Incluir el archivo de conexión
include "modelo/conexion.php";

// Verificar si se recibe el parámetro 'id_matricula'
if (isset($_GET['id_matricula']) && is_numeric($_GET['id_matricula'])) {
    $id_matricula = intval($_GET['id_matricula']); // Asegurarse de que sea un entero

    // Preparar la consulta para obtener los datos actuales
    $sqlQuery = "
        SELECT 
            matricula.id_matricula,
            estudiantes.nombre_estudiante,
            asignatura.nombre_asignatura,
            matricula.semestre,
            matricula.anio,
            matricula.estado,
            matricula.id_estudiante,
            matricula.id_asignatura
        FROM matricula
        INNER JOIN estudiantes ON matricula.id_estudiante = estudiantes.id_estudiante
        INNER JOIN asignatura ON matricula.id_asignatura = asignatura.id_asignatura
        WHERE id_matricula = ?
    ";

    if ($stmt = $conexion->prepare($sqlQuery)) {
        $stmt->bind_param("i", $id_matricula);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $datos = $result->fetch_object(); // Obtener los datos de la matrícula
        } else {
            echo "<div class='alert alert-danger'>No se encontró la matrícula.</div>";
            exit();
        }

        $stmt->close();
    } else {
        echo "<div class='alert alert-danger'>Error al preparar la consulta: " . htmlspecialchars($conexion->error) . "</div>";
        exit();
    }
} else {
    header("Location: acciones_matricula.php?mensaje=error_id");
    exit();
}

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_estudiante = intval($_POST['id_estudiante']);
    $id_asignatura = intval($_POST['id_asignatura']);
    $semestre = trim($_POST['semestre']);
    $anio = intval($_POST['anio']);
    $estado = trim($_POST['estado']);

    // Validar y actualizar los datos
    $updateQuery = "UPDATE matricula SET id_estudiante = ?, id_asignatura = ?, semestre = ?, anio = ?, estado = ? WHERE id_matricula = ?";
    if ($updateStmt = $conexion->prepare($updateQuery)) {
        $updateStmt->bind_param("iisisi", $id_estudiante, $id_asignatura, $semestre, $anio, $estado, $id_matricula);
        if ($updateStmt->execute()) {
            header("Location: acciones_matricula.php?mensaje=actualizado");
            exit();
        } else {
            echo "<div class='alert alert-danger'>Error al actualizar: " . htmlspecialchars($updateStmt->error) . "</div>";
        }

        $updateStmt->close();
    } else {
        echo "<div class='alert alert-danger'>Error al preparar la consulta: " . htmlspecialchars($conexion->error) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Matrícula</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center text-primary mb-4">Editar Matrícula</h2>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="id_estudiante" class="form-label">Estudiante</label>
                <select class="form-select" name="id_estudiante" id="id_estudiante" required>
                    <?php
                    $estudiantesQuery = "SELECT id_estudiante, nombre_estudiante FROM estudiantes";
                    $estudiantesResult = $conexion->query($estudiantesQuery);
                    while ($estudiante = $estudiantesResult->fetch_object()) {
                        $selected = ($estudiante->id_estudiante == $datos->id_estudiante) ? "selected" : "";
                        echo "<option value='$estudiante->id_estudiante' $selected>$estudiante->nombre_estudiante</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="id_asignatura" class="form-label">Asignatura</label>
                <select class="form-select" name="id_asignatura" id="id_asignatura" required>
                    <?php
                    $asignaturasQuery = "SELECT id_asignatura, nombre_asignatura FROM asignatura";
                    $asignaturasResult = $conexion->query($asignaturasQuery);
                    while ($asignatura = $asignaturasResult->fetch_object()) {
                        $selected = ($asignatura->id_asignatura == $datos->id_asignatura) ? "selected" : "";
                        echo "<option value='$asignatura->id_asignatura' $selected>$asignatura->nombre_asignatura</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="semestre" class="form-label">Semestre</label>
                <input type="text" class="form-control" id="semestre" name="semestre" value="<?= htmlspecialchars($datos->semestre) ?>" required>
            </div>
            <div class="mb-3">
                <label for="anio" class="form-label">Año</label>
                <input type="number" class="form-control" id="anio" name="anio" value="<?= htmlspecialchars($datos->anio) ?>" required>
            </div>
            <div class="mb-3">
                <label for="estado" class="form-label">Estado</label>
                <select class="form-select" name="estado" id="estado" required>
                    <option value="activo" <?= $datos->estado === "activo" ? "selected" : "" ?>>Activo</option>
                    <option value="inactivo" <?= $datos->estado === "inactivo" ? "selected" : "" ?>>Inactivo</option>
                </select>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-success">Guardar Cambios</button>
                <a href="acciones_matricula.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>

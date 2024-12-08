<?php
include "modelo/conexion.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_asignatura = intval($_POST['id_asignatura']);
    $nombre_asignatura = $_POST['nombre_asignatura'];
    $nombre_carrera = $_POST['nombre_carrera'];

    // Obtener ID de carrera mediante su nombre
    $sqlCarrera = "SELECT id_carrera FROM carrera WHERE nombre_carrera = ?";
    $stmtCarrera = $conexion->prepare($sqlCarrera);
    $stmtCarrera->bind_param("s", $nombre_carrera);
    $stmtCarrera->execute();
    $resultCarrera = $stmtCarrera->get_result();
    $carrera = $resultCarrera->fetch_object();
    $id_carrera = $carrera->id_carrera;

    // Actualizar asignatura
    $sqlUpdate = "UPDATE asignatura SET nombre_asignatura = ?, id_carrera = ? WHERE id_asignatura = ?";
    $stmtUpdate = $conexion->prepare($sqlUpdate);
    $stmtUpdate->bind_param("ssi", $nombre_asignatura, $id_carrera, $id_asignatura);
    $stmtUpdate->execute();

    // Redirigir tras la actualización
    header("Location: acciones_asignatura.php");
    exit();
}

// Obtener datos de la asignatura y listas de carreras
if (isset($_GET['id_asignatura'])) {
    $id_asignatura = intval($_GET['id_asignatura']);
    $sqlSelect = "SELECT a.nombre_asignatura, c.nombre_carrera 
                  FROM asignatura a
                  JOIN carrera c ON a.id_carrera = c.id_carrera
                  WHERE a.id_asignatura = ?";
    $stmtSelect = $conexion->prepare($sqlSelect);
    $stmtSelect->bind_param("i", $id_asignatura);
    $stmtSelect->execute();
    $result = $stmtSelect->get_result();

    if ($result->num_rows > 0) {
        $datos = $result->fetch_object();
    } else {
        header("Location: acciones_asignatura.php");
        exit();
    }

    $stmtSelect->close();

    // Obtener lista de carreras
    $carreras = [];
    $sqlCarreras = "SELECT nombre_carrera FROM carrera";
    $resultCarreras = $conexion->query($sqlCarreras);
    while ($row = $resultCarreras->fetch_assoc()) {
        $carreras[] = $row['nombre_carrera'];
    }
} else {
    header("Location: acciones_asignatura.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Asignatura</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h3 class="text-center text-primary">Editar Asignatura</h3>
        <form method="POST" action="">
            <input type="hidden" name="id_asignatura" value="<?= $id_asignatura ?>">

            <div class="mb-3">
                <label for="nombre_asignatura" class="form-label">Nombre de la Asignatura:</label>
                <input type="text" class="form-control" id="nombre_asignatura" name="nombre_asignatura" value="<?= htmlspecialchars($datos->nombre_asignatura) ?>" required>
            </div>

            <div class="mb-3">
                <label for="nombre_carrera" class="form-label">Carrera:</label>
                <select class="form-select" id="nombre_carrera" name="nombre_carrera" required>
                    <option value="" disabled>Selecciona una carrera</option>
                    <?php foreach ($carreras as $carrera) { ?>
                        <option value="<?= htmlspecialchars($carrera) ?>" <?= $carrera === $datos->nombre_carrera ? 'selected' : '' ?>>
                            <?= htmlspecialchars($carrera) ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                <a href="acciones_asignatura.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

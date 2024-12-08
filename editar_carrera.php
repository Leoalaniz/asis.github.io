<?php
// Incluir archivo de conexión
include "modelo/conexion.php";

// Verificar si el ID de la carrera está presente en la URL
if (isset($_GET['id_carrera'])) {
    // Obtener el ID de la carrera desde la URL
    $id_carrera = $_GET['id_carrera'];

    // Prepara la consulta SQL para obtener los datos de la carrera
    $sql = "SELECT nombre_carrera, plan_estudio FROM carrera WHERE id_carrera = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_carrera);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si la carrera existe
    if ($result->num_rows > 0) {
        $datos = $result->fetch_object();
        $nombre_carrera = $datos->nombre_carrera;
        $plan_estudio = $datos->plan_estudio;
    } else {
        echo "<div class='alert alert-danger'>Carrera no encontrada.</div>";
        exit();
    }

    // Si el formulario se envía, actualizar los datos
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener los datos del formulario
        $nombre_carrera = $_POST['nombre_carrera'];
        $plan_estudio = $_POST['plan_estudio'];

        // Prepara la consulta SQL para actualizar los datos
        $updateSql = "UPDATE carrera SET nombre_carrera = ?, plan_estudio = ? WHERE id_carrera = ?";
        $stmtUpdate = $conexion->prepare($updateSql);
        $stmtUpdate->bind_param("ssi", $nombre_carrera, $plan_estudio, $id_carrera);
        $stmtUpdate->execute();

        // Verificar si se actualizó correctamente
        if ($stmtUpdate->affected_rows > 0) {
            // Redirigir a la página de lista de carreras después de actualizar
            header("Location: crear_carrera.php");
            exit();
        } else {
            echo "<div class='alert alert-warning'>No se realizaron cambios en la carrera.</div>";
        }

        $stmtUpdate->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Carrera</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles.css">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .form-container {
      background-color: #ffffff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .btn-primary {
      background-color: #007bff;
      border-color: #007bff;
    }
    .btn-primary:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>
  <div class="container mt-5">
    <div class="form-container mx-auto" style="max-width: 500px;">
      <h2 class="text-center mb-4">Editar Carrera</h2>
      <form method="POST">
        <div class="mb-3">
          <label for="nombre_carrera" class="form-label">Nombre de la Carrera</label>
          <input type="text" class="form-control" id="nombre_carrera" name="nombre_carrera" value="<?= htmlspecialchars($nombre_carrera) ?>" required>
        </div>
        <div class="mb-3">
          <label for="plan_estudio" class="form-label">Plan de Estudio</label>
          <input type="text" class="form-control" id="plan_estudio" name="plan_estudio" value="<?= htmlspecialchars($plan_estudio) ?>" required>
        </div>
        <div class="d-grid gap-2">
          <button type="submit" class="btn btn-primary">Actualizar Carrera</button>
          <a href="crear_carrera.php" class="btn btn-secondary">Volver a la Lista</a>
        </div>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

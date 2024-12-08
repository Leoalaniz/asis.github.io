<?php
include 'modelo/conexion.php';

// Obtener los datos de las carreras
$sqlQuery = "
    SELECT  
        c.id_carrera, 
        c.nombre_carrera
    FROM 
        carrera c
";
$result = $conexion->query($sqlQuery);
$carreras = [];
if ($conexion->connect_error) {
    die("Connection failed: " . $conexion->connect_error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro de Asignaturas</title>
  
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f8f9fa;
    }

    .form-container {
      max-width: 600px;
      margin: 2rem auto;
      padding: 2rem;
      background-color: white;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    header {
      text-align: center;
      margin-bottom: 1.5rem;
    }

    .btn-primary {
      background-color: #007bff;
      border-color: #007bff;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <header>
      <h2 class="mb-4">Registro de Asignaturas</h2>
    </header>
    <form action="controlador/asignaturas_conexion.php" method="POST">

      <!-- Nombre de la Asignatura -->
      <div class="mb-3">
        <label for="nombre_asignatura" class="form-label">Nombre de la Asignatura</label>
        <input type="text" class="form-control" id="nombre_asignatura" name="nombre_asignatura" required>
      </div>

      <div class="mb-3">
        <label for="nombre_carrera" class="form-label text-secondary">Seleccione carrera</label>
        <select id="nombre_carrera" name="id_carrera" class="form-control" required>
          <option value="">Seleccione una carrera</option>
          <!-- Opciones dinámicas -->
          <?php
          $query_carreras = "SELECT id_carrera, nombre_carrera FROM carrera";
          $result_carreras = $conexion->query($query_carreras);
          while ($row = $result_carreras->fetch_assoc()) {
              echo "<option value='{$row['id_carrera']}'>{$row['nombre_carrera']}</option>";
          }
          ?>
        </select>
      </div>

      <!-- Botones -->
      <div class="d-flex justify-content-between">
        <button type="submit" name="btnregistrar" class="btn btn-primary">Registrar</button>
        <a href="inicio_registroacademico.php" class="btn btn-secondary">Cancelar</a>
      </div>
    </form>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

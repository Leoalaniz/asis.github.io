<?php
include 'modelo/conexion.php';

// Verificar conexión
if ($conexion->connect_error) {
    die("Connection failed: " . $conexion->connect_error);
}

// Obtener estudiantes
$query_estudiantes = "SELECT id_estudiante, nombre_estudiante FROM estudiantes";
$result_estudiantes = $conexion->query($query_estudiantes);

// Obtener docentes y asignaturas
$query_asignar_asignaturas = "
    SELECT aa.id_docente, aa.id_asignatura, d.nombre_docente, a.nombre_asignatura 
    FROM asignar_asignaturas aa
    INNER JOIN docentes d ON aa.id_docente = d.id_docente
    INNER JOIN asignatura a ON aa.id_asignatura = a.id_asignatura";
$result_asignar_asignaturas = $conexion->query($query_asignar_asignaturas);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro de Matrícula</title>
  
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
  </style>
</head>
<body>
  <div class="form-container">
    <header>
      <h2 class="mb-4">Registro de Matrícula</h2>
    </header>
    <form action="controlador/matricula_conexion.php" method="POST">
      
      <!-- Seleccionar Estudiante -->
      <div class="mb-3">
        <label for="id_estudiante" class="form-label">Seleccione Estudiante</label>
        <select id="id_estudiante" name="id_estudiante" class="form-control" required>
          <option value="">Seleccione un estudiante</option>
          <?php
          while ($row = $result_estudiantes->fetch_assoc()) {
              echo "<option value='{$row['id_estudiante']}'>{$row['nombre_estudiante']}</option>";
          }
          ?>
        </select>
      </div>

      <!-- Seleccionar Docente y Asignatura -->
      <div class="mb-3">
        <label for="id_asignar_asignatura" class="form-label">Seleccione Docente y Asignatura</label>
        <select id="id_asignar_asignatura" name="id_asignar_asignatura" class="form-control" required>
          <option value="">Seleccione una combinación</option>
          <?php
          while ($row = $result_asignar_asignaturas->fetch_assoc()) {
              echo "<option value='{$row['id_docente']}-{$row['id_asignatura']}'>
                      {$row['nombre_docente']} - {$row['nombre_asignatura']}
                    </option>";
          }
          ?>
        </select>
      </div>

      <!-- Semestre -->
      <div class="mb-3">
        <label for="semestre" class="form-label">Semestre</label>
        <input type="text" class="form-control" id="semestre" name="semestre" placeholder="1 o 2" required>
      </div>

      <!-- Año -->
      <div class="mb-3">
        <label for="anio" class="form-label">Año</label>
        <input type="number" class="form-control" id="anio" name="anio" placeholder="Ingrese el año" required>
      </div>

      <!-- Estado -->
      <div class="mb-3">
        <label for="estado" class="form-label">Estado</label>
        <select id="estado" name="estado" class="form-control" required>
          <option value="">Seleccione el estado</option>
          <option value="Activo">Activo</option>
          <option value="Inactivo">Inactivo</option>
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

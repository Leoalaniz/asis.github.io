<?php
session_start();

// Verificar si el usuario está autenticado como docente
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== "2") {
    header("Location: index.php");
    exit();
}

include 'modelo/conexion.php';

// Obtener el id_docente de la sesión
$id_docente = $_SESSION['id_docente'];

// Consulta para obtener el nombre del docente
$query_docente = "SELECT nombre_docente FROM docentes WHERE id_docente = ?";
$stmt_docente = $conexion->prepare($query_docente);
$stmt_docente->bind_param("i", $id_docente);
$stmt_docente->execute();
$result_docente = $stmt_docente->get_result();

// Verificar si se obtuvo el nombre del docente
if ($result_docente && $result_docente->num_rows > 0) {
    $docente = $result_docente->fetch_object();
    $nombre_docente = htmlspecialchars($docente->nombre_docente);
} else {
    $nombre_docente = "Docente desconocido";
}

// Consulta SQL filtrada por id_docente para obtener estudiantes matriculados
$query_estudiantes = "
    SELECT 
        m.id_estudiante, 
        e.nombre_estudiante AS nombre_estudiante, 
        m.id_asignatura, 
        asig.nombre_asignatura AS nombre_asignatura 
    FROM 
        matricula m
    INNER JOIN 
        estudiantes e ON m.id_estudiante = e.id_estudiante
    INNER JOIN 
        asignatura asig ON m.id_asignatura = asig.id_asignatura
    WHERE 
        m.id_docente = ?
";

// Preparar y ejecutar la consulta
$stmt = $conexion->prepare($query_estudiantes);
$stmt->bind_param("i", $id_docente);
$stmt->execute();
$result_estudiantes = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Asistencia</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Roboto', sans-serif;
      background-color: #f8f9fa;
    }
    header {
      background: linear-gradient(90deg, #003366, #007bff);
      color: white;
    }
    footer {
      background-color: #003366;
      color: white;
      text-align: center;
      padding: 1rem 0;
    }
    .table-container {
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
  </style>
</head>
<body>
  <header class="py-3 shadow">
    <nav class="navbar navbar-expand-lg navbar-dark">
      <div class="container">
        <a class="navbar-brand" href="#">
          <i class="bi bi-mortarboard"></i> Docentes URACCAN
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a class="nav-link text-danger" href="index.php"><i class="bi bi-box-arrow-right"></i> Cerrar Sesión</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <div class="container text-center mt-3">
      <h2>Bienvenido, <?= $nombre_docente ?>!</h2>
    </div>
  </header>

  <main class="container my-5">
    <h1 class="mb-4 text-center">Asistencia</h1>

    <div class="table-container">
      <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
          <thead class="table-primary">
            <tr>
              <th>Nombre del Estudiante</th>
              <th>Nombre de la Asignatura</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if ($result_estudiantes && $result_estudiantes->num_rows > 0) {
              while ($row = $result_estudiantes->fetch_object()) { ?>
                <tr>
                  <td><?= htmlspecialchars($row->nombre_estudiante) ?></td>
                  <td><?= htmlspecialchars($row->nombre_asignatura) ?></td>
                  <td>
                    <div class="btn-group" role="group">
                      <button class="btn btn-success btn-sm marcar-asistencia" 
                              data-id-estudiante="<?= $row->id_estudiante ?>" 
                              data-id-asignatura="<?= $row->id_asignatura ?>" 
                              title="Marcar Asistencia">
                        <i class="bi bi-check-circle-fill"></i>
                      </button>
                      <button class="btn btn-warning btn-sm marcar-retraso" 
                              data-id-estudiante="<?= $row->id_estudiante ?>" 
                              data-id-asignatura="<?= $row->id_asignatura ?>" 
                              title="Marcar Retraso">
                        <i class="bi bi-clock-fill"></i>
                      </button>
                      <button class="btn btn-danger btn-sm marcar-ausencia" 
                              data-id-estudiante="<?= $row->id_estudiante ?>" 
                              data-id-asignatura="<?= $row->id_asignatura ?>" 
                              title="Marcar Ausencia">
                        <i class="bi bi-x-circle-fill"></i>
                      </button>
                    </div>
                  </td>
                </tr>
              <?php }
            } else { ?>
              <tr>
                <td colspan="3" class="text-center">No hay estudiantes asignados</td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </main>

  <script>
    document.querySelectorAll('.marcar-asistencia, .marcar-retraso, .marcar-ausencia').forEach(button => {
      button.addEventListener('click', function () {
        const idEstudiante = this.dataset.idEstudiante;
        const idAsignatura = this.dataset.idAsignatura;
        let estado;

        if (this.classList.contains('marcar-asistencia')) {
          estado = 'Asistencia';
        } else if (this.classList.contains('marcar-retraso')) {
          estado = 'Retraso';
        } else if (this.classList.contains('marcar-ausencia')) {
          estado = 'Ausencia';
        }

        const data = {
          id_estudiante: idEstudiante,
          id_asignatura: idAsignatura,
          estado: estado
        };

        console.log('Enviando datos:', data);

        fetch('acciones.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(data),
        })
        .then(response => response.json())
        .then(data => {
          console.log('Respuesta del servidor:', data);
          if (data.success) {
            alert(data.message);
            location.reload();
          } else {
            alert('Error: ' + data.message);
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Hubo un error al procesar la solicitud');
        });
      });
    });
  </script>

</body>
</html>

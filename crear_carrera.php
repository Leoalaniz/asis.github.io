<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crear Carreras - Academia URACCAN</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="container mt-5">
    <h2>Crear Carreras</h2>
    <form method="POST" action="controlador/crear_carreraconexion.php">
      <div class="mb-3">
        <label for="nombre_carrera" class="form-label">Nombre de la Carrera</label>
        <input type="text" class="form-control" id="nombre_carrera" name="nombre_carrera" required>
      </div>
      <div class="mb-3">
        <label for="plan_estudio" class="form-label">Plan de Estudio</label>
        <input type="text" class="form-control" id="plan_estudio" name="plan_estudio" required>
      </div>
      <button type="submit" name="btnregistrar" class="btn btn-primary">Crear Carrera</button>
      <a href="inicio_academia.php" class="btn btn-danger btn-sm">
        <i class="bi bi-box-arrow-right fs-6 me-1"></i> salir
      </a>
    </form>
  </div>

  <div class="col-8 p-4">
    <h3 class="text-center mb-3">Lista de Carreras</h3>
    <!-- Campo de búsqueda -->
    <div class="mb-3">
      <input type="text" id="buscar" class="form-control" placeholder="Buscar carrera...">
    </div>
    <table class="table table-hover" id="tablaCarreras">
      <thead>
        <tr>
          <th>Nombre de la Carrera</th>
          <th>Plan de Estudio</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Incluir archivo de conexión
        include "modelo/conexion.php";

        // Preparar y ejecutar la consulta SQL
        $sqlQuery = "SELECT id_carrera, nombre_carrera, plan_estudio FROM carrera";
        $stmt = $conexion->prepare($sqlQuery);
        $stmt->execute();
        $result = $stmt->get_result();

        // Mostrar resultados en la tabla
        while ($datos = $result->fetch_object()) { ?>
          <tr>
            <td><?= htmlspecialchars($datos->nombre_carrera) ?></td>
            <td><?= htmlspecialchars($datos->plan_estudio) ?></td>
            <td>
              <div class="btn-group">
                <a href="editar_carrera.php?id_carrera=<?= urlencode($datos->id_carrera) ?>" class="btn btn-warning btn-icon" title="Editar">
                  <i class="fas fa-edit fa-lg"></i>
                </a>
                <a href="eliminar_carrera.php?id_carrera=<?= urlencode($datos->id_carrera) ?>" class="btn btn-danger btn-icon" title="Eliminar" onclick="return confirm('¿Estás seguro de que deseas eliminar esta carrera?');">
                  <i class="fas fa-trash-alt fa-lg"></i>
                </a>
              </div>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Función para filtrar la tabla
    document.getElementById('buscar').addEventListener('keyup', function () {
      const query = this.value.toLowerCase();
      const filas = document.querySelectorAll('#tablaCarreras tbody tr');

      filas.forEach(fila => {
        const textoFila = fila.innerText.toLowerCase();
        fila.style.display = textoFila.includes(query) ? '' : 'none';
      });
    });
  </script>
</body>
</html>

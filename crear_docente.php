<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro de Docente</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
  <div class="container mt-5">
    <h2>Registro Docente</h2>
    <form method="POST" action="controlador/crear_docenteconexion.php">
      <!-- Formulario para registrar docentes -->
      <div class="mb-3">
        <label for="nombre_docente" class="form-label">Nombre del Docente</label>
        <input type="text" class="form-control" id="nombre_docente" name="nombre_docente" placeholder="Ingrese el nombre del docente" required>
      </div>
      <div class="mb-3">
        <label for="sexo_docente" class="form-label">Sexo</label>
        <select class="form-select" id="sexo_docente" name="sexo_docente" required>
          <option value="">Seleccione...</option>
          <option value="M">Masculino</option>
          <option value="F">Femenino</option>
          <option value="O">Otro</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="telefono_docente" class="form-label">Teléfono</label>
        <input type="tel" class="form-control" id="telefono_docente" name="telefono_docente" placeholder="Ingrese el teléfono" required>
      </div>
      <div class="mb-3">
        <label for="email_docente" class="form-label">Email</label>
        <input type="email" class="form-control" id="email_docente" name="email_docente" placeholder="Ingrese el email" required>
      </div>
      <div class="mb-3">
        <label for="rol_docente" class="form-label">Rol del docente</label>
        <select class="form-select" id="rol_docente" name="rol_docente" required>
          <option value="" disabled selected>Seleccione rol</option>
          <option value="2">2</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="usuario_docente" class="form-label">Usuario</label>
        <input type="text" class="form-control" id="usuario_docente" name="usuario_docente" placeholder="Ingrese el nombre de usuario" required>
      </div>
      <div class="mb-3">
        <label for="password_docente" class="form-label">Contraseña</label>
        <input type="password" class="form-control" id="password_docente" name="password_docente" placeholder="Ingrese la contraseña" required>
      </div>
      <div class="d-grid">
        <button type="submit" class="btn btn-primary">Registrar Docente</button>
        <br>
        <a href="inicio_academia.php" class="btn btn-danger btn-sm">
          <i class="bi bi-box-arrow-right fs-6 me-1"></i> Salir
        </a>
      </div>
    </form>
  </div>

  <div class="col-8 p-4">
    <h3 class="text-center mb-3">Lista de Docentes</h3>

    <!-- Campo de búsqueda -->
    <form method="GET" action="" class="mb-3">
  <div class="input-group">
    <!-- Campo de búsqueda -->
    <input 
      type="text" 
      name="search" 
      class="form-control" 
      placeholder="Buscar por nombre, email o teléfono" 
      value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
    >
    <!-- Botón Buscar -->
    <button type="submit" class="btn btn-primary">
      Buscar
    </button>
    
    <!-- Botón Volver a la Lista -->
    <a href="crear_docente.php" class="btn btn-secondary">
      Volver a la Lista
    </a>
  </div>
</form>

    <table class="table table-hover">
      <thead>
        <tr>
          <th>Nombre del Docente</th>
          <th>Sexo</th>
          <th>Teléfono</th>
          <th>Email</th>
          <th>Rol</th>
          <th>Usuario</th>
          <th>Contraseña</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php
        include "modelo/conexion.php";

        // Obtener valor de búsqueda
        $search = $_GET['search'] ?? '';

        // Consulta SQL con filtro de búsqueda
        $sqlQuery = "SELECT id_docente, nombre_docente, sexo_docente, telefono_docente, email_docente, rol_docente, usuario_docente, password_docente FROM docentes";
        if (!empty($search)) {
          $sqlQuery .= " WHERE nombre_docente LIKE ? OR email_docente LIKE ? OR telefono_docente LIKE ?";
        }

        $stmt = $conexion->prepare($sqlQuery);

        // Si hay búsqueda, agregar parámetros
        if (!empty($search)) {
          $searchParam = '%' . $search . '%';
          $stmt->bind_param("sss", $searchParam, $searchParam, $searchParam);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        // Mostrar los resultados
        if ($result->num_rows > 0) {
          while ($datos = $result->fetch_object()) { ?>
            <tr>
              <td><?= htmlspecialchars($datos->nombre_docente) ?></td>
              <td><?= htmlspecialchars($datos->sexo_docente) ?></td>
              <td><?= htmlspecialchars($datos->telefono_docente) ?></td>
              <td><?= htmlspecialchars($datos->email_docente) ?></td>
              <td><?= htmlspecialchars($datos->rol_docente) ?></td>
              <td><?= htmlspecialchars($datos->usuario_docente) ?></td>
              <td><?= htmlspecialchars($datos->password_docente) ?></td>
              <td>
                <div class="btn-group">
                  <a href="editar_docente.php?id_docente=<?= $datos->id_docente ?>" class="btn btn-warning btn-icon">
                    <i class="fas fa-edit fa-lg"></i>
                  </a>
                  <a href="eliminar_docente.php?id_docente=<?= $datos->id_docente ?>" class="btn btn-danger btn-icon">
                    <i class="fas fa-trash-alt fa-lg"></i>
                  </a>
                </div>
              </td>
            </tr>
          <?php }
        } else { ?>
          <tr>
            <td colspan="8" class="text-center">No se encontraron resultados para "<?= htmlspecialchars($search) ?>".</td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

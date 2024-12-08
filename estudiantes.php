<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro de Estudiantes</title>
  
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
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
      <h2 class="mb-4">Registro de Estudiantes</h2>
    </header>
    <form method="POST" action="controlador/estudiante_conexion.php">
      <!-- Nombre del Estudiante -->
      <div class="mb-3">
        <label for="nombre_estudiante" class="form-label">Nombre del Estudiante</label>
        <input type="text" class="form-control" id="nombre_estudiante" name="nombre_estudiante" placeholder="ELIETH MAGALLY JIRON GARCIA" required>
      </div>
      
      <!-- Email -->
      <div class="mb-3">
        <label for="email_estudiante" class="form-label">Correo Electrónico</label>
        <input type="email" class="form-control" id="email_estudiante" name="email_estudiante" placeholder="eli@est.uraccan.com" required>
      </div>
      
      <!-- Teléfono -->
      <div class="mb-3">
        <label for="telefono_estudiante" class="form-label">Teléfono</label>
        <input type="tel" class="form-control" id="telefono_estudiante" name="telefono_estudiante" placeholder="8280-7890" required>
      </div>
      
      <!-- Género -->
      <div class="mb-3">
        <label for="genero" class="form-label">Género</label>
        <select class="form-select" id="genero" name="genero" required>
          <option value="" selected disabled>Seleccione el género</option>
          <option value="Masculino">Masculino</option>
          <option value="Femenino">Femenino</option>

        </select>
      </div>
      
      <!-- Botones -->
      <div class="d-flex justify-content-between">
        <button type="submit" class="btn btn-primary">Registrar</button>
        <a href="inicio_registroacademico.php" class="btn btn-secondary">Cancelar</a>
      </div>
    </form>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro Académico - Academia URACCAN</title>
  
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Montserrat:wght@700&display=swap" rel="stylesheet">
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

    .hero-image {
      background-image: url('https://www.uraccan.edu.ni/sites/default/files/blog/images/IMG%201_161.jpg');
      background-size: cover;
      background-position: center;
      height: 400px;
      border-radius: 15px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .hero-overlay {
      background-color: rgba(0, 0, 0, 0.5);
      height: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      border-radius: 15px;
    }

    .dropdown-item:hover {
      background-color: #f8f9fa;
      color: #007bff;
    }
  </style>
</head>
<body>
  <header class="py-3 shadow">
    <nav class="navbar navbar-expand-lg navbar-dark">
      <div class="container">
        <a class="navbar-brand" href="#">
          <i class="bi bi-mortarboard"></i> Registro Académico URACCAN
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a class="nav-link" href="acciones.php">Ver Registro de Estudiantes</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="acciones_asignatura.php">Ver Asignaturas</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="acciones_matricula.php">Ver matricula de los estudiante</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-danger" href="index.php"><i class="bi bi-box-arrow-right"></i> Cerrar Sesión</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <main class="container my-5">
    <div class="text-center">
      <div class="hero-image mb-4">
        <div class="hero-overlay">
          <h1 class="display-5 fw-bold">Bienvenidos al Registro Académico</h1>
        </div>
      </div>
      <p class="lead mb-4">Gestione estudiantes, asignaturas y matrículas de forma eficiente.</p>
      <div>
        <a href="estudiantes.php" class="btn btn-primary btn-lg rounded-pill me-3">
          <i class="bi bi-person-plus-fill me-2"></i> Registrar Estudiantes
        </a>
        <a href="asignaturas.php" class="btn btn-secondary btn-lg rounded-pill me-3">
          <i class="bi bi-bookmark-plus-fill me-2"></i> Crear Asignaturas
        </a>
        <a href="matricula.php" class="btn btn-success btn-lg rounded-pill">
          <i class="bi bi-clipboard-check-fill me-2"></i> Matricular Estudiantes
        </a>
      </div>
    </div>
  </main>

  <footer>
    <p>&copy; 2024 Registro Académico URACCAN - Todos los derechos reservados</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

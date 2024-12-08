<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Academia URACCAN</title>
  
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
          <i class="bi bi-mortarboard"></i> Academia URACCAN
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a class="nav-link" href="crear_carrera.php" onclick="redirectAndClose(event, 'crear_carrera.php')">Crear Carreras</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="crear_docente.php" onclick="redirectAndClose(event, 'crear_docente.php')">Registrar Docentes</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Opciones Académicas
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="asignar_asignatura.php" onclick="redirectAndClose(event, 'asignar_asignatura.php')">Asignar Asignatura</a></li>
              </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link text-danger" href="index.php" onclick="redirectAndClose(event, 'index.php')">
                <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
              </a>
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
          <h1 class="display-5 fw-bold">Bienvenidos a la Academia URACCAN</h1>
        </div>
      </div>
      <p class="lead mb-4">AQUI PUEDES EXPLORAR A CERCA DE URACCAN .</p>
      <a href="https://www.uraccan.edu.ni/" class="btn btn-primary btn-lg rounded-pill">
        <i class="bi bi-arrow-down-circle me-2"></i> Explorar
      </a>
    </div>
  </main>

  <footer>
    <p>&copy; 2024 Academia URACCAN - Todos los derechos reservados</p>
  </footer>

  <script>
    function redirectAndClose(event, url) {
      event.preventDefault(); // Prevenir el comportamiento predeterminado del enlace
      window.open(url, "_blank"); // Abrir la nueva página
      window.close(); // Cerrar la ventana actual
    }
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

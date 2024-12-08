<?php
session_start();
include('modelo/conexion.php');

// Configuración para evitar el uso del botón "Atrás" del navegador
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0"); // Proxies

$error = ''; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = htmlspecialchars(trim($_POST['usuario']));
    $password = htmlspecialchars(trim($_POST['password']));
    $rol = htmlspecialchars(trim($_POST['rol'])); 

    if ($rol === "0") { 
        // Academia
        $query = "SELECT * FROM academia WHERE usuario_academico = ? AND password_academico = ?";
    } elseif ($rol === "1") { 
        // Registro Académico
        $query = "SELECT * FROM registro_academico WHERE usuario_registro = ? AND password_registro = ?";
    } elseif ($rol === "2") { 
        // Docentes
        $query = "SELECT * FROM docentes WHERE usuario_docente = ? AND password_docente = ?";
    } else {
        $error = "Rol no válido.";
    }

    if (isset($query)) {
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("ss", $usuario, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
            // Si el rol es docente, verificamos si tiene matrícula asignada
            if ($rol === "2") {
                $id_docente = $user['id_docente']; // Obtenemos el id_docente del usuario autenticado

                // Verificar si el docente tiene alguna asignación en la tabla matricula
                $query_matricula = "SELECT * FROM matricula WHERE id_docente = ?";
                $stmt_matricula = $conexion->prepare($query_matricula);
                $stmt_matricula->bind_param("i", $id_docente);
                $stmt_matricula->execute();
                $result_matricula = $stmt_matricula->get_result();

                if ($result_matricula->num_rows > 0) {
                    // El docente tiene matrícula asignada, continuar con el inicio de sesión
                    $_SESSION['rol'] = $rol;
                    $_SESSION['id_docente'] = $user['id_docente']; // Guardamos el id_docente en la sesión
                    header("Location: inicio_docentes.php");
                    exit();
                } else {
                    // Si no tiene matrícula asignada, mostramos un error
                    $error = "Este docente no tiene matrícula asignada.";
                }
            } else {
                // Para otros roles (Academia, Registro Académico), redirigir normalmente
                $_SESSION['rol'] = $rol;

                if ($rol === "0") {
                    header("Location: inicio_academia.php");
                } elseif ($rol === "1") {
                    header("Location: inicio_registroacademico.php");
                }
                exit();
            }
        } else {
            $error = "Usuario o contraseña incorrectos.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Asistencia - URACCAN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/13a2a62932.js" crossorigin="anonymous"></script>
    <style>
        body {
            background-image: url('imagenes/ee.jpg'); 
            font-family: Arial, sans-serif;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background: linear-gradient(to bottom, rgba(0, 123, 255, 0.5), rgba(0, 123, 255, 0.3));
            padding: 50px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            width: 400px;
            text-align: center;
            position: relative;
        }

        .login-container h3 {
            margin-bottom: 20px;
            color: #ffffff;
            font-weight: bold;
        }

        .login-container input[type="text"],
        .login-container input[type="password"],
        .login-container select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        .login-container input[type="submit"] {
            border: none;
            width: 100%;
            font-size: 16px;
            border-radius: 20px;
            padding: 10px;
            background-color: #0056b3;
            color: white;
            cursor: pointer;
        }

        .login-container input[type="submit"]:hover {
            background-color: #003366;
        }

        .alert {
            position: absolute;
            top: -20px;
            left: 50%;
            transform: translateX(-50%);
            width: calc(100% - 40px);
            text-align: center;
        }

        .logo-container img {
            max-width: 100px;
        }

        .input-group .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #0056b3;
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="logo-container">
        <img src="imagenes/uraccanlogo.png" alt="uraccan" width="300" height="110">
    </div>
    <h3 class="text-center" style="color: #ffffff;">Sistema de Asistencia URACCAN</h3>

    <?php if (!empty($error)): ?>
        <div id="errorAlert" class="alert alert-danger" role="alert">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form class="p-3" method="POST" action="">
        <select name="rol" id="rol" required>
            <option value="">Selecciona tu rol</option>
            <option value="0">Academia</option>
            <option value="1">Registro Académico</option>
            <option value="2">Docentes</option>
        </select>
        <input type="text" placeholder="&#128100; Usuario" name="usuario" id="usuario" required>
        <div class="input-group">
            <input type="password" placeholder="&#128274; Contraseña" name="password" id="password" required>
            <span class="toggle-password" onclick="togglePassword()">
                <i class="fas fa-eye" id="eyeIcon"></i>
            </span>
        </div>
        <input type="submit" value="Iniciar Sesión" class="btn btn-primary mt-3">
    </form>
</div>

<script>
    // Evitar regresar con el botón "Atrás"
    history.pushState(null, null, location.href);
    window.onpopstate = function () {
        history.pushState(null, null, location.href);
    };

    function togglePassword() {
        const passwordInput = document.getElementById("password");
        const eyeIcon = document.getElementById("eyeIcon");
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            eyeIcon.classList.remove("fa-eye");
            eyeIcon.classList.add("fa-eye-slash");
        } else {
            passwordInput.type = "password";
            eyeIcon.classList.remove("fa-eye-slash");
            eyeIcon.classList.add("fa-eye");
        }
    }
</script>

</body>
</html>

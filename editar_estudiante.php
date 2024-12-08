<?php
include "modelo/conexion.php";

if (isset($_GET['id_estudiante'])) {
    $id_estudiante = intval($_GET['id_estudiante']);
    $sqlQuery = "SELECT nombre_estudiante, email_estudiante, telefono_estudiante, genero FROM estudiantes WHERE id_estudiante = ?";
    $stmt = $conexion->prepare($sqlQuery);

    if ($stmt) {
        $stmt->bind_param("i", $id_estudiante);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $datos = $result->fetch_object();
        } else {
            echo "<div class='alert alert-danger'>Error: Estudiante no encontrado.</div>";
            exit;
        }

        $stmt->close();
    }
} else {
    echo "<div class='alert alert-danger'>Error: ID no válido.</div>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_estudiante = intval($_POST['id_estudiante']);
    $nombre_estudiante = $_POST['nombre_estudiante'];
    $email_estudiante = $_POST['email_estudiante'];
    $telefono_estudiante = $_POST['telefono_estudiante'];
    $genero = $_POST['genero'];

    $sqlQuery = "UPDATE estudiantes SET 
                 nombre_estudiante = ?, 
                 email_estudiante = ?, 
                 telefono_estudiante = ?, 
                 genero = ? 
                 WHERE id_estudiante = ?";
    $stmt = $conexion->prepare($sqlQuery);

    if ($stmt) {
        $stmt->bind_param("ssssi", $nombre_estudiante, $email_estudiante, $telefono_estudiante, $genero, $id_estudiante);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            header("Location: acciones.php");
            exit;
        } else {
            echo "<div class='alert alert-warning'>No se realizaron cambios.</div>";
        }

        $stmt->close();
    } else {
        echo "<div class='alert alert-danger'>Error en la consulta SQL: " . $conexion->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Estudiante</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        .form-group label {
            font-weight: bold;
        }
        .btn-primary {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3 class="text-primary mb-4">Editar Estudiante</h3>

        <!-- Formulario de edición -->
        <form method="POST" action="">
            <input type="hidden" name="id_estudiante" value="<?= $id_estudiante ?>">

            <div class="mb-3 form-group">
                <label for="nombre_estudiante">Nombre del Estudiante:</label>
                <input type="text" class="form-control" id="nombre_estudiante" name="nombre_estudiante" value="<?= htmlspecialchars($datos->nombre_estudiante) ?>" required>
            </div>

            <div class="mb-3 form-group">
                <label for="email_estudiante">Email:</label>
                <input type="email" class="form-control" id="email_estudiante" name="email_estudiante" value="<?= htmlspecialchars($datos->email_estudiante) ?>" required>
            </div>

            <div class="mb-3 form-group">
                <label for="telefono_estudiante">Teléfono:</label>
                <input type="text" class="form-control" id="telefono_estudiante" name="telefono_estudiante" value="<?= htmlspecialchars($datos->telefono_estudiante) ?>" required>
            </div>

            <div class="mb-3 form-group">
                <label for="genero">Género:</label>
                <select class="form-control" id="genero" name="genero" required>
                     <option value="Masculino" <?= $datos->genero === 'Masculino' ? 'selected' : '' ?>>Masculino</option>
                    <option value="Femenino" <?= $datos->genero === 'Femenino' ? 'selected' : '' ?>>Femenino</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar Cambios</button>
            <br>
            <br>
            <a href="acciones.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Volver</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

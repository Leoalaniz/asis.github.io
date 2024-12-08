<?php
// Incluir archivo de conexión
include "modelo/conexion.php";

// Verificar si el ID del docente está presente en la URL
if (isset($_GET['id_docente'])) {
    // Obtener el ID del docente desde la URL
    $id_docente = $_GET['id_docente'];

    // Preparar la consulta SQL para obtener los datos del docente
    $sql = "SELECT nombre_docente, sexo_docente, telefono_docente, email_docente, rol_docente, usuario_docente, password_docente FROM docentes WHERE id_docente = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_docente);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si el docente existe
    if ($result->num_rows > 0) {
        $datos = $result->fetch_object();
        $nombre_docente = $datos->nombre_docente;
        $sexo = $datos->sexo_docente;
        $telefono = $datos->telefono_docente;
        $email = $datos->email_docente;
        $rol_docente = $datos->rol_docente;
        $usuario = $datos->usuario_docente;
        $password = $datos->password_docente; // No mostrar la contraseña aquí
    } else {
        echo "Docente no encontrado.";
        exit();
    }

    // Si el formulario se envía, actualizar los datos
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener los datos del formulario
        $nombre_docente = $_POST['nombre_docente'];
        $sexo = $_POST['sexo_docente'];
        $telefono = $_POST['telefono_docente'];
        $email = $_POST['email_docente'];
        $rol_docente = $_POST['rol_docente'];
        $usuario = $_POST['usuario_docente'];
        $password = $_POST['password_docente']; // Obtener la contraseña del formulario

        // Si se ha ingresado una nueva contraseña
        if (!empty($password)) {
            // Si se cambia la contraseña, se guarda la nueva
            $sql_update = "UPDATE docentes SET nombre_docente = ?, sexo_docente = ?, telefono_docente = ?, email_docente = ?, rol_docente = ?, usuario_docente = ?, password_docente = ? WHERE id_docente = ?";
            $stmt_update = $conexion->prepare($sql_update);
            $stmt_update->bind_param("sssssssi", $nombre_docente, $sexo, $telefono, $email, $rol_docente, $usuario, $password, $id_docente);
        } else {
            // Si no se cambia la contraseña, actualizar solo los otros campos
            $sql_update = "UPDATE docentes SET nombre_docente = ?, sexo_docente = ?, telefono_docente = ?, email_docente = ?, rol_docente = ?, usuario_docente = ? WHERE id_docente = ?";
            $stmt_update = $conexion->prepare($sql_update);
            $stmt_update->bind_param("ssssssi", $nombre_docente, $sexo, $telefono, $email, $rol_docente, $usuario, $id_docente);
        }

        // Ejecutar la consulta
        if ($stmt_update->execute()) {
            // Redirigir a la lista de docentes después de actualizar
            header("Location: crear_docente.php");
            exit();
        } else {
            echo "Error al actualizar el docente: " . $stmt_update->error;
        }

        $stmt_update->close();
    }
}
?>

<!-- Formulario HTML para editar el docente -->
<link rel="stylesheet" href="asignar.css">


<div class="container mt-5">
    <h2>Editar Docente</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="nombreDocente" class="form-label">Nombre del Docente</label>
            <input type="text" class="form-control" id="nombre_docente" name="nombre_docente" value="<?= htmlspecialchars($nombre_docente) ?>" required>
        </div>
        <div class="mb-3">
            <label for="sexo" class="form-label">Sexo</label>
            <select class="form-select" id="sexo_docente" name="sexo_docente" required>
                <option value="M" <?= $sexo == 'M' ? 'selected' : '' ?>>Masculino</option>
                <option value="F" <?= $sexo == 'F' ? 'selected' : '' ?>>Femenino</option>
                <option value="O" <?= $sexo == 'O' ? 'selected' : '' ?>>Otro</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="tel" class="form-control" id="telefono_docente" name="telefono_docente" value="<?= htmlspecialchars($telefono) ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email_docente" name="email_docente" value="<?= htmlspecialchars($email) ?>" required>
        </div>
        <div class="mb-3">
            <label for="rol_docente" class="form-label">Rol del Docente</label>
            <select class="form-select" id="rol_docente" name="rol_docente" required>
                <option value="1" <?= $rol_docente == 1 ? 'selected' : '' ?>>Rol 1</option>
                <option value="2" <?= $rol_docente == 2 ? 'selected' : '' ?>>Rol 2</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="usuario" class="form-label">Usuario</label>
            <input type="text" class="form-control" id="usuario_docente" name="usuario_docente" value="<?= htmlspecialchars($usuario) ?>" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="password_docente" name="password_docente" placeholder="Ingrese una nueva contraseña si desea cambiarla">
        </div>
        <button type="submit" class="btn btn-primary">Actualizar Docente</button>
        <a href="crear_docente.php" class="btn btn-custom">Volver a la Lista</a>
    </form>
</div>

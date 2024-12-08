<?php
// Incluir archivo de conexión
include 'modelo/conexion.php';

// Verificar si el ID de la asignación está presente en la URL
if (isset($_GET['id_asignar_asignatura'])) {
    // Obtener el ID de la asignación desde la URL
    $id_asignar_asignatura = $_GET['id_asignar_asignatura'];

    // Prepara la consulta SQL para obtener los datos de la asignación
    $sql = "SELECT id_docente, id_asignatura FROM asignar_asignaturas WHERE id_asignar_asignatura = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_asignar_asignatura);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si la asignación existe
    if ($result->num_rows > 0) {
        $datos = $result->fetch_object();
        $id_docente = $datos->id_docente;
        $id_asignatura = $datos->id_asignatura;
    } else {
        echo "Asignación no encontrada.";
        exit();
    }

    // Si el formulario se envía, actualizar los datos
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener los datos del formulario
        $id_docente = $_POST['id_docente'];
        $id_asignatura = $_POST['id_asignatura'];

        // Prepara la consulta SQL para actualizar los datos
        $updateSql = "UPDATE asignar_asignaturas SET id_docente = ?, id_asignatura = ? WHERE id_asignar_asignatura = ?";
        $stmtUpdate = $conexion->prepare($updateSql);
        $stmtUpdate->bind_param("iii", $id_docente, $id_asignatura, $id_asignar_asignatura);
        $stmtUpdate->execute();

        // Verificar si se actualizó correctamente
        if ($stmtUpdate->affected_rows > 0) {
            // Redirigir a la página de lista de asignaciones después de actualizar
            header("Location: asignar_asignatura.php");
            exit();
        } else {
            echo "Error al actualizar la asignación.";
        }

        $stmtUpdate->close();
    }
}
?>

<!-- Formulario HTML para editar la asignación -->
<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow border-0 rounded-4 p-4" style="background-color: #f7f7f7; width: 100%; max-width: 600px;">
        <h2 class="text-center text-primary mb-4" style="font-size: 30px; font-weight: 600;">Editar Asignación de Asignatura</h2>
        <form method="POST">
            <!-- Selección de Docente -->
            <div class="mb-4">
                <label for="nombre_docente" class="form-label text-secondary" style="font-weight: 600;">Seleccione Docente</label>
                <select id="nombre_docente" name="id_docente" class="form-control" required style="border-radius: 8px; padding: 10px; font-size: 16px;">
                    <option value="">Seleccione un Docente</option>
                    <?php
                    // Obtener la lista de docentes para el select
                    $query_docentes = "SELECT id_docente, nombre_docente FROM docentes";
                    $result_docentes = $conexion->query($query_docentes);
                    while ($row = $result_docentes->fetch_assoc()) {
                        $selected = ($row['id_docente'] == $id_docente) ? 'selected' : '';
                        echo "<option value='" . $row['id_docente'] . "' $selected>" . htmlspecialchars($row['nombre_docente']) . "</option>";
                    }
                    ?>
                </select>
            </div>

            <br>
            <!-- Selección de Asignatura -->
            <div class="mb-4">
                <label for="nombre_asignatura" class="form-label text-secondary" style="font-weight: 600;">Seleccione Asignatura</label>
                <select id="nombre_asignatura" name="id_asignatura" class="form-control" required style="border-radius: 8px; padding: 10px; font-size: 16px;">
                    <option value="">Seleccione una Asignatura</option>
                    <?php
                    // Obtener la lista de asignaturas para el select
                    $query_asignaturas = "SELECT id_asignatura, nombre_asignatura FROM asignatura";
                    $result_asignaturas = $conexion->query($query_asignaturas);
                    while ($row = $result_asignaturas->fetch_assoc()) {
                        $selected = ($row['id_asignatura'] == $id_asignatura) ? 'selected' : '';
                        echo "<option value='" . $row['id_asignatura'] . "' $selected>" . htmlspecialchars($row['nombre_asignatura']) . "</option>";
                    }
                    ?>
                </select>
            </div>
            <br>
          

            <button type="submit" class="btn btn-success btn-block mt-3">
    Actualizar Asignación
</button>

<!-- Botón Volver a la Lista -->
<a href="asignar_asignatura.php" class="btn btn-secondary btn-block mt-3">
    Volver a la Lista
</a>
        </form>
    </div>
</div>

<!-- Estilos personalizados -->
<style>
    .d-flex {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }

    .card {
        background-color: #f7f7f7;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
    }

    .form-control {
        border-radius: 8px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    }

    .form-control:focus {
        border-color: #28a745;
        box-shadow: 0 0 5px rgba(40, 167, 69, 0.6);
    }

    /* Botones: Estilo general */
.btn {
    padding: 12px;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    text-align: center;
    display: inline-block;
    border: none;
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
}

/* Botón: Éxito (Actualizar) */
.btn-success {
    background-color: #28a745; /* Verde Bootstrap */
    color: white;
}

.btn-success:hover {
    background-color: #218838;
    box-shadow: 0 4px 6px rgba(40, 167, 69, 0.4);
}

/* Botón: Secundario (Volver) */
.btn-secondary {
    background-color: #6c757d; /* Gris Bootstrap */
    color: white;
}

.btn-secondary:hover {
    background-color: #5a6268;
    box-shadow: 0 4px 6px rgba(108, 117, 125, 0.4);
}

/* Responsividad para botones */
@media (max-width: 768px) {
    .btn {
        font-size: 14px;
        padding: 10px;
    }
}


    h2 {
        color: #0066cc;
    }
</style>

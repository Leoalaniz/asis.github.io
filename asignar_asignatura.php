<?php
include 'modelo/conexion.php';

// Obtener las asignaciones iniciales de la base de datos
$sqlQuery = "
    SELECT 
        a.id_asignar_asignatura, 
        d.nombre_docente, 
        asig.nombre_asignatura 
    FROM 
        asignar_asignaturas a
    INNER JOIN 
        docentes d ON a.id_docente = d.id_docente
    INNER JOIN 
        asignatura asig ON a.id_asignatura = asig.id_asignatura
";
$result = $conexion->query($sqlQuery);
$asignaciones = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $asignaciones[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignar Asignaturas a Docentes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="styles.css">
    <script>
        function filtrarAsignaciones() {
            const filtro = document.getElementById('busquedaDocente').value.toLowerCase();
            const filas = document.querySelectorAll('#tablaAsignaciones tbody tr');
            
            filas.forEach(fila => {
                const nombreDocente = fila.querySelector('.col-docente').textContent.toLowerCase();
                if (nombreDocente.includes(filtro)) {
                    fila.style.display = '';
                } else {
                    fila.style.display = 'none';
                }
            });
        }
    </script>
</head>
<body>
    <div class="container my-5">
        <h2 class="text-center mb-4 text-primary">Asignar Asignaturas a Docentes</h2>

        <!-- Formulario de asignación -->
        <form method="POST" action="controlador/asignar_asignaturaconexion.php" class="shadow-lg p-4 rounded-3 bg-light">
            <div class="mb-3">
                <label for="nombre_docente" class="form-label text-secondary">Seleccione Docente</label>
                <select id="nombre_docente" name="id_docente" class="form-control" required>
                    <option value="">Seleccione un Docente</option>
                    <!-- Opciones dinámicas -->
                    <?php
                    $query_docentes = "SELECT id_docente, nombre_docente FROM docentes";
                    $result_docentes = $conexion->query($query_docentes);
                    while ($row = $result_docentes->fetch_assoc()) {
                        echo "<option value='{$row['id_docente']}'>{$row['nombre_docente']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="nombre_asignatura" class="form-label text-secondary">Seleccione Asignatura</label>
                <select id="nombre_asignatura" name="id_asignatura" class="form-control" required>
                    <option value="">Seleccione una Asignatura</option>
                    <!-- Opciones dinámicas -->
                    <?php
                    $query_asignaturas = "SELECT id_asignatura, nombre_asignatura FROM asignatura";
                    $result_asignaturas = $conexion->query($query_asignaturas);
                    while ($row = $result_asignaturas->fetch_assoc()) {
                        echo "<option value='{$row['id_asignatura']}'>{$row['nombre_asignatura']}</option>";
                    }
                    ?>
                </select>
            </div>

            <button type="submit" name="btnregistrar" class="btn btn-success w-100 py-2">Asignar</button>
            <br><br>
            <a href="inicio_academia.php" class="btn btn-danger btn-sm">Salir</a>
        </form>
    </div>

    <!-- Lista de asignaciones -->
    <div class="container mt-5">
        <h3 class="text-center mb-3">Lista de Asignaciones</h3>
        <div class="mb-3">
            <input 
                type="text" 
                id="busquedaDocente" 
                class="form-control" 
                placeholder="Buscar por nombre del docente" 
                onkeyup="filtrarAsignaciones()"
            >
        </div>
        <table class="table table-hover table-bordered" id="tablaAsignaciones">
            <thead class="table-dark">
                <tr>
                    <th>Nombre del Docente</th>
                    <th>Nombre de la Asignatura</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($asignaciones as $asignacion): ?>
                <tr>
                    <td class="col-docente"><?= htmlspecialchars($asignacion['nombre_docente']) ?></td>
                    <td><?= htmlspecialchars($asignacion['nombre_asignatura']) ?></td>
                    <td>
                        <div class="btn-group">
                            <a href="editar_asignarasignatura.php?id_asignar_asignatura=<?= $asignacion['id_asignar_asignatura'] ?>" class="btn btn-warning">
                                <i class="fas fa-edit"></i> 
                            </a>
                            <a href="eliminar_asignarasignatura.php?id_asignar_asignatura=<?= $asignacion['id_asignar_asignatura'] ?>" class="btn btn-danger">
                                <i class="fas fa-trash-alt"></i> 
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

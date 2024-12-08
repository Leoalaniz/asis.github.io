<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Matrículas</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        .table thead th {
            vertical-align: middle;
            text-align: center;
            background-color: #007bff;
            color: white;
        }
        .table tbody td {
            vertical-align: middle;
            text-align: center;
        }
        .btn-custom {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Encabezado y Botón de Agregar -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="text-primary">Lista de Matrículas</h3>
        </div>

        <!-- Barra de búsqueda -->
        <form method="GET" action="" class="mb-3">
            <div class="input-group">
                <input class="form-control me-2" type="search" name="search" placeholder="Buscar" aria-label="Buscar" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                <button class="btn btn-outline-success" type="submit"><i class="fas fa-search"></i> Buscar</button>
                <?php if (!empty($_GET['search'])) { ?>
                    <a href="acciones_matricula.php" class="btn btn-outline-secondary ms-2"><i class="fas fa-undo"></i> Ver Todo</a>
                <?php } ?>
            </div>
        </form>

        <!-- Tabla de Matrículas -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead class="table-primary">
                    <tr>
                        <th>Nombre del Estudiante</th>
                        <th>Nombre de la Asignatura</th>
                        <th>Semestre</th>
                        <th>Año</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Incluir el archivo de conexión
                    include "modelo/conexion.php";

                    // Obtener el valor de búsqueda
                    $search = $_GET['search'] ?? '';

                    // Consulta SQL con JOINs
                    $sqlQuery = "
                        SELECT 
                            matricula.id_matricula,
                            estudiantes.nombre_estudiante AS nombre_estudiante,
                            asignatura.nombre_asignatura AS nombre_asignatura,
                            matricula.semestre,
                            matricula.anio,
                            matricula.estado
                        FROM matricula
                        INNER JOIN estudiantes ON matricula.id_estudiante = estudiantes.id_estudiante
                        INNER JOIN asignatura ON matricula.id_asignatura = asignatura.id_asignatura
                    ";
                    // Añadir búsqueda si aplica
                    if (!empty($search)) {
                        $sqlQuery .= " WHERE estudiantes.nombre_estudiante LIKE ? 
                                       OR asignatura.nombre_asignatura LIKE ? 
                                       OR matricula.semestre LIKE ? 
                                       OR matricula.anio LIKE ? 
                                       OR matricula.estado LIKE ?";
                    }

                    $stmt = $conexion->prepare($sqlQuery);

                    // Si hay búsqueda, agregar parámetros
                    if (!empty($search)) {
                        $searchParam = '%' . $search . '%';
                        $stmt->bind_param("sssss", $searchParam, $searchParam, $searchParam, $searchParam, $searchParam);
                    }

                    if ($stmt) {
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            // Mostrar los resultados
                            while ($datos = $result->fetch_object()) { ?>
                                <tr>
                                    <td><?= htmlspecialchars($datos->nombre_estudiante) ?></td>
                                    <td><?= htmlspecialchars($datos->nombre_asignatura) ?></td>
                                    <td><?= htmlspecialchars($datos->semestre) ?></td>
                                    <td><?= htmlspecialchars($datos->anio) ?></td>
                                    <td><?= htmlspecialchars($datos->estado) ?></td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <!-- Editar Matrícula -->
                                            <a href="editar_matricula.php?id_matricula=<?= $datos->id_matricula ?>" class="btn btn-warning btn-sm" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <!-- Eliminar Matrícula -->
                                            <a href="eliminar_matricula.php?id_matricula=<?= $datos->id_matricula ?>" class="btn btn-danger btn-sm" title="Eliminar" onclick="return confirm('¿Estás seguro de eliminar esta matrícula?');">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php }
                        } else { ?>
                            <tr>
                                <td colspan="6" class="text-center">No se encontraron matrículas con el término "<?= htmlspecialchars($search) ?>".</td>
                            </tr>
                        <?php }
                        $stmt->close();
                    } else {
                        // Manejar errores en la preparación de la consulta
                        echo "<tr><td colspan='6' class='text-center text-danger'>Error al preparar la consulta: " . htmlspecialchars($conexion->error) . "</td></tr>";
                    }

                    // Cerrar la conexión
                    $conexion->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="text-center">
        <a href="inicio_registroacademico.php" class="btn btn-secondary btn-block mt-3">
            Volver 
        </a>
    </div>

    <!-- Bootstrap JS Bundle con Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

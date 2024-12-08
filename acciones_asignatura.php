<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Asignaturas</title>
    
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
            <h3 class="text-primary">Lista de Asignaturas</h3>
        </div>

        <!-- Barra de búsqueda -->
        <form method="GET" action="" class="mb-3">
            <div class="input-group">
                <input class="form-control me-2" type="search" name="search" placeholder="Buscar" aria-label="Buscar" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                <button class="btn btn-outline-success" type="submit"><i class="fas fa-search"></i> Buscar</button>
                <?php if (!empty($_GET['search'])) { ?>
                    <a href="acciones_asignatura.php" class="btn btn-outline-secondary ms-2"><i class="fas fa-undo"></i> Ver Todo</a>
                <?php } ?>
            </div>
        </form>

        <!-- Tabla de Asignaturas -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead class="table-primary">
                    <tr>
                        <th>Nombre de la Asignatura</th>
                        <th>Nombre de la Carrera</th>
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
                            asignatura.id_asignatura, 
                            asignatura.nombre_asignatura, 
                            carrera.nombre_carrera AS nombre_carrera
                        FROM asignatura
                        INNER JOIN carrera ON asignatura.id_carrera = carrera.id_carrera
                    ";
                    // Añadir búsqueda si aplica
                    if (!empty($search)) {
                        $sqlQuery .= " WHERE asignatura.nombre_asignatura LIKE ? 
                                       OR carrera.nombre_carrera LIKE ?";
                    }

                    $stmt = $conexion->prepare($sqlQuery);

                    // Si hay búsqueda, agregar parámetros
                    if (!empty($search)) {
                        $searchParam = '%' . $search . '%';
                        $stmt->bind_param("ss", $searchParam, $searchParam);
                    }

                    if ($stmt) {
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            // Mostrar los resultados
                            while ($datos = $result->fetch_object()) { ?>
                                <tr>
                                    <td><?= htmlspecialchars($datos->nombre_asignatura) ?></td>
                                    <td><?= htmlspecialchars($datos->nombre_carrera) ?></td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <!-- Editar Asignatura -->
                                            <a href="editar_asignatura.php?id_asignatura=<?= $datos->id_asignatura ?>" class="btn btn-warning btn-sm" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <!-- Eliminar Asignatura -->
                                            <a href="eliminar_asignatura.php?id_asignatura=<?= $datos->id_asignatura ?>" class="btn btn-danger btn-sm" title="Eliminar" onclick="return confirm('¿Estás seguro de eliminar esta asignatura?');">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php }
                        } else { ?>
                            <tr>
                                <td colspan="3" class="text-center">No se encontraron asignaturas con el término "<?= htmlspecialchars($search) ?>".</td>
                            </tr>
                        <?php }
                        $stmt->close();
                    } else {
                        // Manejar errores en la preparación de la consulta
                        echo "<tr><td colspan='3' class='text-center text-danger'>Error al preparar la consulta: " . htmlspecialchars($conexion->error) . "</td></tr>";
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
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

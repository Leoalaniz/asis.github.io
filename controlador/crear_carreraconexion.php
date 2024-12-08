<?php
include "../modelo/conexion.php"; // Incluye tu archivo de conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btnregistrar"])) {
    if (!empty($_POST["nombre_carrera"]) && !empty($_POST["plan_estudio"])) {
        // Captura los datos
        $nombre_carrera = $_POST["nombre_carrera"];
        $plan_estudio = $_POST["plan_estudio"];

        // Inicia la transacción
        $conexion->begin_transaction();

        try {
            // Inserción en la tabla carrera
            $sqlEstudiante = $conexion->prepare("INSERT INTO carrera (nombre_carrera, plan_estudio) VALUES (?, ?)");
            $sqlEstudiante->bind_param("ss", $nombre_carrera, $plan_estudio);
            $sqlEstudiante->execute();
            $sqlEstudiante->close();

            // Confirma la transacción
            $conexion->commit();
            // Redirige después de la inserción exitosa
            header("Location: ../crear_carrera.php");
            exit();

        } catch (Exception $e) {
            // Si ocurre un error, revierte la transacción
            $conexion->rollback();
            echo "Error: " . $e->getMessage();
        }
    }
}
?>

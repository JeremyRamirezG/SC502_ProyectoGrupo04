<?php
require_once "dbCRUD/conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conexion = Conecta();

    $titulo = $_POST['titulo'];
    $area = $_POST['area'];
    $descripcion = $_POST['descripcion'];
    $calificacion = $_POST['calificacion'];

    // Se insertan los datos
    $sql = "INSERT INTO tab_feedback (Titulo, Area, Descripción, Calificacion) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conexion, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssi", $titulo, $area, $descripcion, $calificacion);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            echo "¡Gracias por tu feedback!";
        } else {
            echo "Hubo un error al enviar tu feedback. Intentar nuevamente.";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error en la preparación de la consulta.";
    }
    Desconecta($conexion);
} else {
    echo "Acceso no autorizado.";
}

header("Location: soporteFeedback.php");
exit();
?>
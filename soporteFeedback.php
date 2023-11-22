<?php
require_once "templates/head.php";
require_once "templates/headerNavbar.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Feedback</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <h2 class="feedback-form h2">Deja tu Feedback</h2>
    <form class=feedback-form action="procesar_feedback.php" method="POST">
        <label for="titulo">Título:</label><br>
        <input type="text" id="titulo" name="titulo" required><br><br>

        <label for="area">Área:</label><br>
        <input type="text" id="area" name="area" required><br><br>

        <label for="descripcion">Descripción:</label><br>
        <textarea id="descripcion" name="descripcion" required></textarea><br><br>

        <label for="calificacion">Calificación:</label><br>
        <input type="number" id="calificacion" name="calificacion" min="1" max="10" required><br><br>

        <input type="submit" value="Enviar Feedback">
    </form>
</body>

</html>
<?php
require_once "templates/footer.php";
?>
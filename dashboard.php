<?php
    session_start();
    if(!isset($_SESSION["logged"]) || !($_SESSION["logged"] === true)){
        header("location: login.php");
        exit;
    }

    require_once "templates/head.php";

    $cedula = $_SESSION['id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <!-- Dashboard -->
    <div class="container-fluid">
        <div class="row">
            <!-- Barra lateral -->
            <div class="col-md-2">
                <?php include("templates/sidenav.php"); ?>
            </div>

            <div class="col-md-10">
                <h5 class="titulo__animacion">Dashboard</h5>

                <!-- Sección de Perfil -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <h5 class="card-title">Mi Perfil</h5>
                                <a href="perfil.php" class="btn btn-light">
                                    <i class="fa fa-user-circle fa-3x"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sección de los permisos y roles-->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card bg-warning text-white">
                            <div class="card-body">
                                <h5 class="card-title">Gestión de permisos y roles</h5>
                                <a href="roles.php" class="btn btn-light">
                                    <i class="fa fa-cogs fa-3x"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sección de las citas-->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <h5 class="card-title">Registro de Citas</h5>
                                <a href="citasDashboard.php" class="btn btn-light">
                                    <i class="fa fa-calendar fa-3x"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div> 

</body>

</html>
<?php
    require_once "templates/footer.php";
?>

<?php
    session_start();
    if(!isset($_SESSION["logged"]) || !($_SESSION["logged"] === true)){
        header("location: login.php");
        exit;
    }

    require_once "templates/head.php";
    require_once "templates/headerNavbar.php";

    $cedula = $_SESSION['id'];
?>

    <!-- Dashboard -->
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-10">
                <h5 class="my-3">Dashboard</h5>

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

            </div>
        </div>
    </div> 
<?php
    require_once "templates/footer.php";
?>

<?php
    session_start();
    if(!isset($_SESSION["logged"]) || !($_SESSION["logged"] === true)){
        header("location: login.php");
        exit;
    }

    require_once "templates/head.php";
    require_once "templates/headerNavbar.php";
?>
    <main class = "contenedor">
        <!--Bienvenida-->
        <section class="contenido__bienvenida">
            <h1 class="titulo__animacion">BIENVENIDO</h1>
            <h3>Descubre todos los beneficios que obtendrás en nuestra app.</h3>
        </section>
        <!--Sobre la empresa-->
        <section class="contenido__descripcion">
            <div class="texto">
                <br />
                <br />
                <h2>¿Quiénes Somos?</h2>
                <br />
                <br />
                <br />
                <br />
                <br />
                <p>Somos una empresa que brinda servicios médicos a toda persona que lo necesite.
                 Aquí podrán registrar sus citas médicas, cancelarlas si lo amerita y llevar control de estas mismas.
                Queremos ofrecerles la mejor atención en su salud.</p>
                <br />
                <p></p>
                <br />
                <p></p>
            </div>
        </section>
        <!--Contactenos-->
        <section class="contenido__contactos">
            <br />
            <h2>Contáctenos</h2>
            <p> Ofrece sus servicios en Costa Rica</p>
            <div class="box-container">
                <div class="box2">
                    <br />
                    <h3>Correo Electrónico</h3>
                    <br />
                    <br />
                    <p>med@salud.co.cr</p>
                </div>
                <div class="box2">
                    <br />
                    <h3>Números de Teléfono</h3>
                    <br />
                    <br />
                    <p>+506 2299-5800</p>
                    <p>+506 2668-0095</p>
                    <p>Emergencias 9-1-1</p>
                </div>
            </div>
        </section>
        <!--Servicios de emergencia-->
        <section class="contenido__serviciosemergencia">
            <br />
            <h2>Servicios de emergencia</h2>
            <div class="content-photo">
            </div>
            </div>
        </section>
    </main>
<?php
    require_once "templates/footer.php";
?>
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
                <h2>¿Quiénes Somos?</h2>
                <br />
                <p>Nos enorgullece ser una empresa dedicada a proporcionar servicios médicos de alta calidad a todas las personas que lo necesiten. Nuestra plataforma le permite registrar sus citas médicas de manera fácil y conveniente, brindándole la flexibilidad de cancelarlas si es necesario. Además, le ofrecemos un completo control y seguimiento de sus citas para garantizar que reciba la mejor atención posible para su salud. Estamos comprometidos en brindarle un servicio excepcional y cuidar de su bienestar. Su salud es nuestra prioridad, y trabajamos arduamente para hacer que su experiencia con nosotros sea lo más cómoda y efectiva posible.</p>
                <br />
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
    </main>
<?php
    require_once "templates/footer.php";
?>
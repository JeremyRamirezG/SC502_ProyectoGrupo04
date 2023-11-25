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
<body>
    <br />
    <br />
    <br/>
    <div class="wrapper">
        <section class="users">
            <header>
                <div class="content">
                    <img src="img/perfilChat.png" alt="">
                    <div class="details">
                        <span>Chat</span>
                        <p>Activo</p>
                    </div>
                </div>
                <a href="cerrarsesion.php" class="logout">Cerrar Sesion</a>
            </header>
            <div class="search">
                <span class="text">Seleccione un usuario</span>
                <input type="text" placeholder="Ingrese un nombre...">
                <button><i class="fas fa-search"></i></button>
            </div>
            <div class="users-list">
                <a href="#">
                    <div class="content">
                        <img src="img/perfilChat.png" alt="">
                        <div class="details">
                            <span>Chat 1</span>
                            <p>Mensaje de prueba</p>
                        </div>
                    </div>
                    <div class="status-dot"><i class="fas fa-circle"></i></div>
                </a>
                <a href="#">
                    <div class="content">
                        <img src="img/perfilChat.png" alt="">
                        <div class="details">
                            <span>Chat 2</span>
                            <p>Mensaje de prueba</p>
                        </div>
                    </div>
                    <div class="status-dot"><i class="fas fa-circle"></i></div>
                </a>
                <a href="#">
                    <div class="content">
                        <img src="img/perfilChat.png" alt="">
                        <div class="details">
                            <span>Chat 3</span>
                            <p>Mensaje de prueba</p>
                        </div>
                    </div>
                    <div class="status-dot"><i class="fas fa-circle"></i></div>
                </a>
                <a href="#">
                    <div class="content">
                        <img src="img/perfilChat.png" alt="">
                        <div class="details">
                            <span>Chat 4</span>
                            <p>Mensaje de prueba</p>
                        </div>
                    </div>
                    <div class="status-dot"><i class="fas fa-circle"></i></div>
                </a>
                <a href="#">
                    <div class="content">
                        <img src="img/perfilChat.png" alt="">
                        <div class="details">
                            <span>Chat 5</span>
                            <p>Mensaje de prueba</p>
                        </div>
                    </div>
                    <div class="status-dot"><i class="fas fa-circle"></i></div>
                </a>
                <a href="#">
                    <div class="content">
                        <img src="img/perfilChat.png" alt="">
                        <div class="details">
                            <span>Chat 6</span>
                            <p>Mensaje de prueba</p>
                        </div>
                    </div>
                    <div class="status-dot"><i class="fas fa-circle"></i></div>
                </a>
            </div>
        </section>
    </div>
    <script src="scripts/chat.js"></script>
    <br />
    <br />
</body>
<?php
    require_once "templates/footer.php";
?>

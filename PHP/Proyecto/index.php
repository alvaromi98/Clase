<?php
$carrito="";
if(isset($_COOKIE['user'])){
  $carrito='
  <button class="btn btn-outline-light ml-3" type="button" onclick="cerarsesion();">Cerrar Sesión</button>
    <button class="btn btn-outline-light ml-3" type="button" onclick=" window.location.href=\'carrito.html\';">Carrito</button>
    ';
}
else{
  $carrito='
      <button class="btn btn-outline-light ml-3" type="button" onclick="window.location.href=\'login.html\';">Login</button>
      <button class="btn btn-outline-light ml-3" type="button" onclick=" window.location.href=\'registro.html\';">Registro</button>
      ';
}
echo('<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PC</title>
    <style>
        .overlay {
            height: 100%;
            width: 0;
            position: fixed;
            z-index: 5;
            top: 0;
            left: 0;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.9);
            overflow-x: hidden;
            transition: 0.5s;
        }

        .overlay-content {
            position: relative;
            top: 10%;
            width: 80%;
            text-align: center;
            margin-top: 30px;
        }

        .overlay a {
            padding: 8px;
            text-decoration: none;
            font-size: 36px;
            color: #818181;
            display: block;
            transition: 0.3s;
        }

        .overlay a:hover,
        .overlay a:focus {
            color: #f1f1f1;
        }

        .overlay .closebtn {
            position: absolute;
            top: 20px;
            right: 45px;
            font-size: 60px;
        }

        @media screen and (max-height: 450px) {
            .overlay a {
                font-size: 20px
            }

            .overlay .closebtn {
                font-size: 40px;
                top: 15px;
                right: 40px;
            }
        }
    </style>
</head>
<header>
    <h1 class="banner display-3 font-weight-bold card-title  text-center">Pagina Componentes</h1>
</header>

<body>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- MENU IZQUIERDO! -->
    <script src="https://code.jquery.com/jquery-latest.min.js"></script>
    <script src="jscript.js"></script>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link a" href="index.php">Inicio<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link a" id="comp" href="componentes.php">Componentes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link a" id="comp" href="usuario.html">Zona Usuario</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link a" id="comp" href="admin.php">Zona Admin</a>
                </li>
            </ul>
            '.$carrito.'
        </div>
    </nav>
    <div class="justify-content-center text-center" id="contenido">
        <h3 class="mt-4">Bienvenido</h3>
    <p>
        Notas Para acceder a Componentes es necesario recargar la pagina 6/7 veces para que se creen las cookies correctamente (bug)
    </p>
    <p>
        Usuario de base de datos: alvaro
    </p>
    <p>
        Contraseña base de datos: alvaro
    </p>
    <p>
        Usuario administrador pagina: admin, contraseña: admin
    </p>
    <p>
        Usuario normal pagina: alvaro, contraseña: alvaro
    </p>
    </div>
</body>

</html>
');
?>

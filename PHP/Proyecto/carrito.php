<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <script src='https://code.jquery.com/jquery-3.4.1.min.js' type='text/javascript'></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <title>3GAG</title>
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

    b {
      font-size: 24px;
    }

    .barra {
      font-size: 38px;
      position: -webkit-sticky;
      /* Safari */
      position: sticky;
      top: 0;
      z-index: 2;
    }

    .btn1 {
      font-size: 38px;
    }

    .a {}
  </style>
</head>
<header>
  <h1 class="banner display-3 font-weight-bold card-title  text-center">Pagina Componentes</h1>
</header>

<body onload="visualizarcarrito();">
  <script>
    function visualizarcarrito() {
      numerodeorden = localStorage.getItem("numerodeorden");
      for (i = 1; i <= numerodeorden; i++) {
        nuevopedido = "Order." + i;
        datos = "";
        datos = localStorage.getItem("Order." + i);
        carro=datos.split("|");
        tabla=carro[0];
        id=carro[1];
        stock=carro[2];
        console.log(tabla);
        console.log(id);
        console.log(stock);
        $.ajax({
          url: 'carritoaux.php',
          type: 'POST',
          data: {
            'tabla': tabla,
            'p': id,
          },
          success: function(response) {
            $('#todo').append(response);
          }
        });
    }
  }

    function openNav() {
      if (navigator.userAgent.match(/Android/i) ||
        navigator.userAgent.match(/webOS/i) ||
        navigator.userAgent.match(/iPhone/i) ||
        navigator.userAgent.match(/iPad/i) ||
        navigator.userAgent.match(/iPod/i) ||
        navigator.userAgent.match(/BlackBerry/i) ||
        navigator.userAgent.match(/Windows Phone/i)
      ) {
        document.getElementById("myNav").style.width = "100%";
      } else {
        document.getElementById("myNav").style.width = "18%";
      }
    }

    function closeNav() {
      document.getElementById("myNav").style.width = "0%";
    }
  </script>
  <!-- MENU IZQUIERDO! -->
  <section id="myNav" class="overlay">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()"> &times;</a>
    <article class="overlay-content">
      <a id="mb" href="#">Placas Base</a>
      <a id="cpu" href="#">CPUes</a>
      <a id="ram" href="#">Ram</a>
      <a id="gpu" href="#">Graficas</a>
      <a id="psu" href="#">Fuentes de<br>Alimentacion</a>
      <a id="ssd" href="#">Discos Duros</a>
      <a id="tower" href="#">Torres</a>
    </article>
  </section>

  <nav class="navbar navbar-expand-lg displaynavbar-light bg-dark barra">
    <a class="navbar-brand" href="#"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <span class="nav-link" onclick="openNav()">Menú &#9776;</span>
        </li>

        <li class="nav-item active">
          <a class="nav-link a" href="index.php">Inicio<span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link a" id="comp" href="pieza.php">Componentes</a>
        </li>
        <li class="nav-item">
          <a class="nav-link a" href="registro.php">Registro</a>
        </li>
        <li class="nav-item">
          <a class="nav-link a" href="login.php">Login</a>
        </li>
      </ul>
      <button class="btn btn-outline-light btn1" type="submit">Mirar Carrito de Compra</button>
    </div>
  </nav>

  <div id="todo" class="container-fluid mt-4 ">
  </div>
</body>

</html>
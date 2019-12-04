<?php

$servername = "localhost";
$username = "alvaro";
$password = "alvaro";
$dbname = "alvaro";

$funcion = $_POST['funcion'];
if ($funcion === 'carrito') {
  carrito($servername, $username, $password, $dbname);
} else if ($funcion === 'cookie') {
  cookie();
} elseif ($funcion === 'pedido') {
  realizarpedido($servername, $username, $password, $dbname);
} elseif ($funcion === 'login') {
  login($servername, $username, $password, $dbname);
} elseif ($funcion === 'actualizar') {
  actualizarcarrito($servername, $username, $password, $dbname);
} elseif ($funcion === 'verinfo') {
  veruser($servername, $username, $password, $dbname);
} elseif ($funcion === 'actualizaruser') {
  cambiarinfouser($servername, $username, $password, $dbname);
} elseif ($funcion === 'registro') {
  registro($servername, $username, $password, $dbname);
} elseif ($funcion === 'fcookie') {
  borrarcookie();
} elseif ($funcion === 'mostrardatos') {
  mostrardatos($servername, $username, $password, $dbname);
} elseif ($funcion === 'cargarid') {
  cargarids($servername, $username, $password, $dbname);
} elseif ($funcion === 'modificar') {
  modificarproducto($servername, $username, $password, $dbname);
}
elseif ($funcion === 'eliminar') {
  eliminarproducto($servername, $username, $password, $dbname);
}




//--------------------------------------------AÑADIR AL CARRITO------------------------------------------------------
function carrito($servername, $username, $password, $dbname)
{
  $tabla = $_POST['tabla'];
  $producto = $_POST['p'];
  $stock = $_POST['stock'];
  $conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());
  $idnuevo = "Id" . $tabla;
  $sql = "SELECT * FROM " . $tabla . " where " . $idnuevo . " = '" . $producto . "';";
  $resultset = mysqli_query($conn, $sql) or die("database error:" . mysqli_error($conn));
  while ($record = mysqli_fetch_assoc($resultset)) {
    $img = $record['Imagen'];
    $marca = $record['Marca'];
    $modelo = $record['Modelo'];
    $precio = $record['Precio'];
    echo (' <tr>
    <th scope="row"> <img src="img/' . $img . '" width="20%" ></th>
      <td>' . $marca . '</td>
      <td>' . $modelo . '</td>
      <td>' . $precio . '€</td>
      <td>' . $stock . '</td>
    </tr>
    ');
  }
}

//--------------------------------------------Setear Cookie------------------------------------------------------
function cookie()
{
  $id = $_POST['x'];
  $stock = $_POST['y'];
  setcookie($id, $stock, time() + (86400 * 30), "/");
}

//============================REALIZAR EL PEDIDO=========================================
function realizarpedido($servername, $username, $password, $dbname)
{
  $usuario = $_COOKIE['user'];
  $total = $_COOKIE['total'];
  $pedido = $_POST['pedido'];
  $conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());
  $sql = "INSERT INTO PEDIDO(nick,IdComponentes,total) values('" . $usuario . "','" . $pedido . "'," . $total . ");";
  $result = mysqli_query($conn, $sql) or die("database error:" . mysqli_error($conn));
  if ($result) {
    echo "success";
  } else {
    echo "error";
  }
}
//actualizar stock
function actualizarcarrito($servername, $username, $password, $dbname)
{
  $tabla = $_POST['tabla'];
  $stock = $_POST['stock'];
  $id = $_POST['id'];
  $idnuevo = "Id" . $tabla;

  $conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());
  $sql = "UPDATE " . $tabla . " set stock=" . $stock . " where " . $idnuevo . " = '" . $id . "';";
  $result = mysqli_query($conn, $sql) or die("database error:" . mysqli_error($conn));
  if ($result) {
    echo "success";
  } else {
    echo 'error';
  }
}

//===========================================LOGIN====================================================
function login($servername, $username, $password, $dbname)
{
  $usuario = $_POST['usuario'];
  $pass = $_POST['pass'];
  $booleano = false;
  $conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());
  $sql = "SELECT * FROM clientes where nick = '" . $usuario . "' and pass = '" . $pass . "';";
  $resultset = mysqli_query($conn, $sql) or die("database error:" . mysqli_error($conn));
  while ($record = mysqli_fetch_assoc($resultset)) {
    $booleano = true;
    setcookie('user', $usuario, time() + (86400 * 30), "/");
  }
  echo ($booleano);
}

//===========================================Ver info de usuario====================================================

function veruser($servername, $username, $password, $dbname)
{
  $nick = $_COOKIE['user'];
  $conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());
  $sql = "SELECT * FROM Clientes where nick='" . $nick . "';";
  $result = mysqli_query($conn, $sql) or die("database error:" . mysqli_error($conn));
  while ($record = mysqli_fetch_assoc($result)) {
    $nick2 = $record['nick'];
    $pass = $record['pass'];
    $email = $record['email'];
  }
  echo ($nick2 . "|" . $pass . "|" . $email);
}

//===========================================Cambiarz info de usuario====================================================
function cambiarinfouser($servername, $username, $password, $dbname)
{
  $nick = $_COOKIE['user'];
  $nick2 = $_POST['nick'];
  $pass = $_POST['pass'];
  $email = $_POST['email'];
  $conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());
  $sql = "update clientes set nick='$nick2', email='$email', pass='$pass' where nick ='$nick'";
  $result = mysqli_query($conn, $sql) or die("database error:" . mysqli_error($conn));
  if ($result) {
    echo "Usuario actualizado correctamente\n Es necesario iniciar sesion de nuevo";
    setcookie("user", "", time() - 3600, '/');
    header('Refresh:3; URL=login.php');
  } else {
    echo "error";
  }
}

//===========================================Registro====================================================

function registro($servername, $username, $password, $dbname)
{
  $nick = $_POST['nick'];
  $pass = $_POST['pass'];
  $email = $_POST['email'];
  $conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());
  $sql = "INSERT INTO clientes(nick,email,pass) values('" . $nick . "','" . $email . "','" . $pass . "');";
  $result = mysqli_query($conn, $sql) or die("database error:" . mysqli_error($conn));
  if ($result) {
    echo "Bienvenido \n Es necesario iniciar sesión";
  } else {
    echo "error";
  }
}

function borrarcookie()
{
  setcookie("user", "", time() - 3600, '/');
}

function cargarids($servername, $username, $password, $dbname)
{
  $conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());
  $todo = '<select class="form-control" id="ids">';
  $tabla = $_POST['tabla'];
  $nid = "Id" . $tabla;
  $sql = "SELECT " . $nid . " FROM " . $tabla . " order by " . $nid . ";";
  $resultset = mysqli_query($conn, $sql) or die("database error:" . mysqli_error($conn));
  while ($record = mysqli_fetch_assoc($resultset)) {
    $id = $record[$nid];
    $todo .= '<option value="' . $id . '">' . $id . '</option>';
  }
  $todo .= ' </select>';
  echo $todo;
}



//===========================================Sacar info para admin====================================================

function mostrardatos($servername, $username, $password, $dbname)
{
  $conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());
  $tabla = $_POST['tabla'];
  $id = $_POST['id'];
  $nid = "Id" . $tabla;
  $sql = "SELECT * FROM " . $tabla . " where " . $nid . "='" . $id . "';";
  $resultset = mysqli_query($conn, $sql) or die("database error:" . mysqli_error($conn));
  while ($record = mysqli_fetch_assoc($resultset)) {
    $img = $record['Imagen'];
    $modelo = $record['Modelo'];
    $precio = $record['Precio'];
    $stock = $record['Stock'];
  }
  $todo = '
  <div class="form-group mt-3">
  <label>Modelo</label>
  <input type="text" class="form-control" id="modelo" aria-describedby="emailHelp" value="' . $modelo . '">
  </div>
  <img class="align-center h-25 w-25" src="img/' . $img . '">
  <div class="form-group">
  <label>Stock</label>
  <input type="number" class="form-control" id="stock" aria-describedby="emailHelp" value="' . $stock . '">
  </div>
  <div class="form-group">
  <label>Precio</label>
  <input type="number" class="form-control" id="precio" aria-describedby="emailHelp" step=".01" value="' . $precio . '">
  </div>
  <button id="modificar" class="btn btn-primary w-10 mt-4 mb-4" type="button" onclick="modificar();">Modificar Producto</button>    
  <button id="eliminar" class="btn btn-primary w-10 mt-4 mb-4" type="button" onclick="eliminar();">Eliminar Producto</button>    
  ';
  echo $todo;
}

function modificarproducto($servername, $username, $password, $dbname)
{
  $tabla = $_POST['tabla'];
  $id = $_POST['id'];
  $stock = $_POST['stock'];
  $modelo = $_POST['modelo'];
  $aux = $_POST['precio'];
  $campo = "id" . $tabla;
  $precio = str_replace(',', '.', $aux);
  $conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());
  $sql = "UPDATE " . $tabla . " set stock='$stock', modelo='$modelo', precio='$precio' where " . $campo . " ='$id'";
  $result = mysqli_query($conn, $sql) or die("database error:" . mysqli_error($conn));
  if ($result) {
    echo "success";
  } else {
    echo "error";
  }
}

function eliminarproducto($servername, $username, $password, $dbname)
{
  $tabla = $_POST['tabla'];
  $id = $_POST['id'];
  $campo = "id" . $tabla;
  $conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());
  $sql = "DELETE FROM " . $tabla . " where " . $campo . " = '" . $id . "';";
  $result = mysqli_query($conn, $sql) or die("database error:" . mysqli_error($conn));
  if ($result) {
    echo "success";
  } else {
    echo "error";
  }
}

function pedidos($servername, $username, $password, $dbname)
{
  $conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());
  $sql = "SELECT * FROM pedido where nick='".$_COOKIE['user']."';";
  $resultset = mysqli_query($conn, $sql) or die("database error:" . mysqli_error($conn));
 
  $array = array();

  while ($record = mysqli_fetch_assoc($resultset)) {
    $fecha=$record['idPedido'];
    $pedido=$record['fecha'];
    array_push($array,[$fecha,$pedido]);
  }
  echo$array;
} 
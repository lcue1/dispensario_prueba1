<?php
session_start();
if (!isset($_SESSION['datos_usuario']['NOMBRE_USUARIO'])) {
    header("Location: index.php");
    exit();
}
$NOMBRE_USUARIO=$_SESSION['datos_usuario']['NOMBRE_USUARIO'];
$COD_ROL=$_SESSION['datos_usuario']['COD_ROL'];
$BODEGA_SELECCIONADA=$_SESSION['datos_usuario']['BODEGA_SELECCIONADA'];



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilos/navbar.css">
    <title>Menu principal</title>
</head>
<body>
    
    <header>
        <h1>Dispensario medico</h1>
    </header>

    <h3>Bienvenido :  <?php echo $NOMBRE_USUARIO?></h3>
    <p>Ubicacion   : <?php echo $BODEGA_SELECCIONADA; ?></p>
    
    
<div class="navbar">
  <a href="#home">Inicio</a>
  <a href="#news">News</a>
  <div class="dropdown">
    <button class="dropbtn">Administrar 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a  href="./usuarios.php">Usuarios</a>
      <a href="#">Roles</a>
      <a href="#">Usuarios</a>
      
    </div>
  </div> 
</div>



</body>
</html>
<?php
require_once "./bd/conexion.php";
$mensaje = ""; // Para mostrar mensaje si el login falla

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conexión
    $conectar = obtener_conexion();
    if (!$conectar) {
        die("No se pudo conectar al servidor: " . mysqli_connect_error());
    }

    // Previene inyección SQL
    $nombre_usuario = mysqli_real_escape_string($conectar, $_POST['nombre_usuario']);
    $pass_usuario = mysqli_real_escape_string($conectar, $_POST['pass_usuario']);
    $bodega_seleccionada = mysqli_real_escape_string($conectar, $_POST['bodega_seleccionada']);

    // Consulta con validación de usuario activo
    $sql = "SELECT * FROM usuario WHERE NOMBRE_USUARIO = '$nombre_usuario' AND PASS_USUARIO = '$pass_usuario' AND ESTADO_USUARIO = 'A'";
    $ejecutar = mysqli_query($conectar, $sql);

    if (!$ejecutar) {
        $mensaje = "Error al ejecutar la consulta.";
    } elseif (mysqli_num_rows($ejecutar) > 0) {
        $datos = mysqli_fetch_assoc($ejecutar);
        session_start();
        $_SESSION["datos_usuario"] = [
            "NOMBRE_USUARIO" => $datos["NOMBRE_USUARIO"],
            "COD_ROL" => $datos["COD_ROL"],
            "BODEGA_SELECCIONADA"=>$bodega_seleccionada
        ];
        header("Location: ./paginas/menu_principal.php");
        exit();
    } else {
        $mensaje = "Usuario o contraseña incorrectos .";
    }

    mysqli_close($conectar);
}
?>


<!DOCTYPE html>
<html lang="es"> 
<head>
    <meta charset="UTF-8">
    <title>Dispensario</title>
    <link rel="stylesheet" href="./estilos/styles.css">
</head>
<body>
    <header>
        <h1>Dispensario medico</h1>
    </header>
    
    <form method="POST" action="" class="formulario">
        <h3 class="formulario__titulo">Ingresar al sistema</h3>
        <label  class="formulario__label" for="nombre_usuario">Nombre usuario</label>
        <input  class="formulario_text" id="nombre_usuario" type="text" name="nombre_usuario" placeholder="Ingrese Usuario" required value='eEspinosa'>

        <label class="formulario__label" for="pass_usuario">Clave usuario</label>
        <input class="formulario_text" id="pass_usuario" type="password" name="pass_usuario" placeholder="Ingrese clave" required value='1234'>
   
        <label class="formulario__label" for="seleccionar_dispensario">Selecciona dispensario</label>
         <select name="bodega_seleccionada" required>
        <option value="">Seleccione:</option>
    <?php
    require_once "./bd/conexion.php";

    $conectar = obtener_conexion();
    if (!$conectar) {
        echo "<option value='' disabled>Error al conectar</option>";
    } else {
        $sql = "SELECT * FROM BODEGA WHERE ESTADO_BODEGA = 'A'";
        $ejecutar = mysqli_query($conectar, $sql);
        if (!$ejecutar) {
            echo "<option value='' disabled>Error al ejecutar la consulta</option>";
        } else {
            if (mysqli_num_rows($ejecutar) > 0) {
                while ($fila = mysqli_fetch_assoc($ejecutar)) {
      echo "<option value='". $fila['CODIGO_BODEGA'] .
            "'>" . $fila['DESCRIPCION']. "</option>";                }
            } else {
                echo "<option value='ddd' disabled>No hay bodegas disponibles</option>";
            }
        }
        mysqli_close($conectar);
    }
    ?>
</select>


        <input class="formulario__btn" type="submit" name="login" value="Entrar">
       
        <label  class="formulario__label--error"><?php echo $mensaje?></label>
        
    </form>

    <script>
        const mensaje = document.querySelector(".formulario__label--error")
        if(mensaje.innerHTML!=""){
            setTimeout(() => {
                mensaje.innerHTML=" "
            }, 2000);
        }
        
    </script>

</body>
</html>

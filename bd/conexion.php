<?php
function obtener_conexion() {
    $host = "localhost";
    $usuario = "root";
    $password_bd = "";
    $nombre_bd = "dispensario";

    $coneccion = mysqli_connect($host, $usuario, $password_bd, $nombre_bd);

    if (!$coneccion) {
        return null;
    }

        return $coneccion;
}
?>

<?php

$nombre= $_GET['nombre'];
$apellido= $_GET['apellido'];

if(empty($nombre) || empty($apellido)){
    echo "Por favor ingrese su nombre y apellido";
}
else{
    echo "Gracias " . $nombre . " " . $apellido . "!";
}


?>
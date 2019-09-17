<?php

    var_dump($_SERVER['REQUEST_METHOD']);

    var_dump($_FILES);

    $imagen_temp= $_FILES["imagen"]["tmp_name"];

    // obtener la extension
    $extension= pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION);
    var_dump($extension);

    // mover la imagen de temp a otra ubicacion
    move_uploaded_file($imagen_temp, "./img/lala.$extension");

?>
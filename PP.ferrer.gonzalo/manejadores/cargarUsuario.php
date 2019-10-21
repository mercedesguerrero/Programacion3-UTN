<?php

/*
1- caso: cargarUsuario (post): 
Se deben guardar los siguientes datos: legajo, email, nombre, clave y dos fotos. 
Los datos se guardan en el archivo usuarios.xxx y las fotos en la carpeta img/fotos 
tomando el legajo como
identificador(el legajo no puede estar repetido).
*/

echo "<font size='3' color='blue'  face='verdana' style='font-weight:bold' <br>carga Usuario  <br> </font>";


if (isset($_POST["legajo"]) && isset($_POST["email"]) && isset($_POST["nombre"]) && isset($_POST["clave"]) && isset($_FILES["foto1"]) && isset($_FILES["foto2"])  ) 
{
    Facultad::AltaUsuario($_POST["legajo"], $_POST["email"],  $_POST["nombre"] ,  $_POST["clave"], $_FILES["foto1"] , $_FILES["foto2"]);
}
else
{
    echo "faltan datos";
}


?>




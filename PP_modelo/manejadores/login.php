<?php

/*
2- caso: login (get): 
Se ingresa legajo y clave, si ambos coinciden se devolverán todos los datos del usuario, si no,
se informara que es lo que fallo. La búsqueda tiene que ser case insensitive
*/

echo "<font size='3' color='blue'  face='verdana' style='font-weight:bold' <br>Login <br> </font>";
if (isset($_GET["legajo"])  && isset($_GET["clave"]) ) 
{
    Facultad::login($_GET["legajo"] , $_GET["clave"]);
}
else
{
    echo "faltan datos";
}


?>




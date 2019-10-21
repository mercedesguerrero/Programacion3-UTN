<?php

/*
6- (1pt.) caso: verUsuario (get): 
Se recibe un legajo y se devuelven todos los datos de dicho usuario
*/

//echo "<font size='3' color='blue'  face='verdana' style='font-weight:bold' <br>verUsuario <br> </font>";

echo "<font size='3' color='blue'  face='verdana' style='font-weight:bold' <br>Consultar Alumno  <br> </font>";
if (isset($_GET["legajo"])   ) 
{
    Facultad::verUsuario($_GET["legajo"]);
}
else
{
    echo "faltan datos";
}


?>




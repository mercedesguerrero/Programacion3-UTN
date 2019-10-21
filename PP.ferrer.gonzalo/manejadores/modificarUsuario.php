<?php

/*
4- (1 pts.) caso: modificarUsuario(post): 
    Se reciben todos los datos del usuario para modificarlos. En el caso que
se carguen fotos nuevas, las fotos viejas se moverán a la carpeta img/backup
*/

//echo "<font size='3' color='blue'  face='verdana' style='font-weight:bold' <br>modificar Usuario  <br> </font>";

if (isset($_POST["legajo"]) && isset($_POST["email"]) && isset($_POST["nombre"]) && isset($_POST["clave"]) && isset($_FILES["foto1"]) && isset($_FILES["foto2"])  ) 
{    
    Facultad::modificarUsuario($_POST["legajo"], $_POST["email"],  $_POST["nombre"] ,  $_POST["clave"], $_FILES["foto1"] , $_FILES["foto2"]);
}
else
{
    echo "faltan datos";
}


?>




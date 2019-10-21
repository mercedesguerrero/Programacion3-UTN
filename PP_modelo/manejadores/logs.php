<?php

/*
7- (2pts.) caso: logs (get):
 Se recibe una fecha y se devuelven todos los registros con fecha mayor a la indicada.
*/

echo "<font size='3' color='blue'  face='verdana' style='font-weight:bold' <br>Logs <br> </font>";
if (isset($_GET["fecha"])   ) 
{
    Facultad::logs($_GET["fecha"] );
}
else
{
    echo "faltan datos";
}


?>




<?php
require_once 'clases/Usuario.php';

$RUTA_USUARIOS="./archivos/usuarios.txt";
$RUTA_CARPETA_IMAGENES = "./img/";

$content= file_get_contents("php://input");
$method = $_SERVER['REQUEST_METHOD'];
echo $method . "<br>";
switch ($method) 
{
    case "GET":
    //var_dump($_GET);
        switch (key($_GET)) {
            case 'login':
                include "funciones/login.php";
                break;
        }
        break; 
    case "POST":
    //var_dump($_POST);
        switch (key($_POST)) {
            case 'cargarUsuario'://POST
                include "funciones/cargarUsuario.php";
                break;    
        
        }
        break;
    
}     
?>
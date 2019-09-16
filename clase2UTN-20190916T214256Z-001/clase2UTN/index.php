<?php

require_once './Clases/Alumno.php';

$metodo= $_SERVER['REQUEST_METHOD'];

echo $metodo . "<br>";

switch ($metodo) 
{
    case "GET":
        switch (key($_GET)) {
            case 'listar':
                include "Funciones/Listar.php";
                break;
                }
        break;
    case "POST":
        switch (key($_POST)) {
            case 'guardarAlumno':
                include "Funciones/GuardarAlumno.php";
                break;
                }
        break;
}

?>
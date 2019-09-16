<?php

$method = $_SERVER['REQUEST_METHOD'];
echo $method . "<br>";

switch ($method) 
{
    case "GET":
        switch (key($_GET)) {
            case 'Ej1':
                include "Ej1.php";
                break;
            case 'Ej2':
                include "Ej2.php";
                break;
        }
        break; 
}

?>
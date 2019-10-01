<?php
require_once 'clases/Alumno.php';

define("RUTA_ALUMNOS", "./archivos/alumnos.txt");
define("RUTA_MATERIAS", "./archivos/Materias.txt");
define("RUTA_IMAGENES_BACKUP", "./backUpFotos/");
define("RUTA_CARPETA_IMAGENES", "./imagenesDeAlumnos/");
$content= file_get_contents("php://input");
$method = $_SERVER['REQUEST_METHOD'];
echo $method . "<br>";

switch ($method) 
{
    case "GET":
        switch (key($_GET)) {
            case 'consultaralumno':
                include "funciones/consultarAlumno";
                break;
            case 'inscribiralumno':
                include "funciones/inscribirAlumno.php";
                break;
            case 'inscripciones':
                include "funciones/inscripciones.php";
                break;
            case 'alumnos':
                include "funciones/alumnos.php";
                break;
        }
        break; 
    case "POST":
        switch (key($_POST)) {
            case 'cargaralumno'://POST
                include "funciones/cargarAlumno.php";
                break;    
            case 'cargarmateria':
                include "funciones/cargarMateria.php";
                break;
            case 'modificaralumno':
                include "funciones/modificarAlumno.php";
                break;
            case 'altaventaconimagen'://POST
                include "funciones/AltaVentaConImagen.php";
                break;
        }
        break;
    
}     
?>
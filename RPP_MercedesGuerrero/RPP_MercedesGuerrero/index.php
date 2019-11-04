<?php

require 'vendor/autoload.php';
//require_once 'clases/Pizza.php';

define("RUTA_PIZZA", "./archivos/Pizza.txt"); 
define("RUTA_CARPETA_IMAGENES", "./images/pizzas/"); 
define("RUTA_CARPETA_BACKUP", "./images/backup/");
//$RUTA_CARPETA_IMAGENES = "./img/";

$config['displayErrorDetails']= true;
$config['addContentLenghtHeader']= false;

$app= new \Slim\App(["settings"=>$config]);

$app->group('/pizza', function(){

    $this->get('/', function($req, $res, $args=[]){//[/]-> significa que es opcional la barra
        return $res->withStatus(200)->write('LISTADO por GET');
    });

    //http://localhost:80/Clase5UTN/usuario/Mercedes
    $this->get('/{nombre}', function($req, $res, $args){
        $nombre= $args['nombre'];
        $res->getBody()->write("Hola <h1>$nombre</h1>, bienvenido a la ApiRest");
    });

    $this->post('/', function($req, $res, $args){
        $arrayDeParametros= $req->getParsedBody();
        $precio= $arrayDeParametros['precio'];
        $tipo= $arrayDeParametros['tipo'];
        $cantidad= $arrayDeParametros['cantidad'];
        $sabor= $arrayDeParametros['sabor'];

        $maxId = Pizza::TraerMayorId(RUTA_PIZZA);
        $id= $maxId + 1;

        if($tipo == "molde" || $tipo == "piedra")
        {
            if($sabor == "muzza" || $sabor == "jamon" || $sabor == "especial")
            {
                $pizza= new Pizza($id, $precio, $tipo, $cantidad, $sabor);
                Pizza::AltaPizza(RUTA_PIZZA, $pizza);
            }
            else
            {
                echo 'Error cargue "sabor" como "muzza", "jamon", "especial".';
            }
        }
        else
        {
            echo 'Error cargue "tipo" como "molde" o "piedra".';
        }

        $archivos= $req->getUploadedFiles();
        $destino= RUTA_CARPETA_IMAGENES;
        $nombreAnterior1= $archivos['imagen1'];
        $nombreAnterior2= $archivos['imagen2'];

        $extension1= explode(".", $nombreAnterior1);
        $extension2= explode(".", $nombreAnterior2);

        $extension1= array_reverse($extension1);
        $extension2= array_reverse($extension2);

        $archivos['imagen1']->moveTo($destino . $sabor . $id . "_1." . $extension1[0]);
        $archivos['imagen2']->moveTo($destino . $sabor . $id . "_2." . $extension2[0]);
        $res->getBody()->write("Hola bienvenido a la ApiRest por POST <br> Recibo pizza: $precio, $tipo, $cantidad, $sabor <br> $pizza ");
        //include "funciones/cargarPizza.php";
    });

});



$app->run();


?>
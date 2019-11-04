<?php
// use Psr\Http\Message\ResponseInterface as Response;
// use Psr\Http\Message\ServerRequestInterface as Request;
// use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/Middleware/middleware.php';
//require __DIR__ . '/../src/Clases/Usuario.php';

$config['displayErrorDetails']= true;
$config['addContentLenghtHeader']= false;

// Instantiate the app
$app= new \Slim\App(["settings"=>$config]);


$app->add(\clases\MWUsuario::class.':MW1');

$app->group('/Usuario',function()
{
    $this->get('/', function($request, $response){

        return $response->getBody()->write("GET USUARIO<br>");
    });

    $this->post('/', function($request, $response){

        return $response->getBody()->write("POST USUARIO<br>");
    })->add(\clases\MWUsuario::class.':MW2');

    //SALIDA:
    // Antes1 
    // Antes2 
    // POST USUARIO
    // Despues2 
    // POST USUARIO
    // Despues1 
});


$app->run();

?>

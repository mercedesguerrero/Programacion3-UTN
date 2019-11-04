<?php
namespace clases;
use Slim\Http\Request;
use Slim\Http\Response;
//require __DIR__ . '/Usuario.php';

class MWUsuario
{
    function MW1(Request $request,Response $response, $next)
    {
        $response->write("Antes1 <br>");
        
        $response = $next($request,$response);
        
        $response->write("Despues1 <br>");
        
        return $response;
        
    }

    function MW2(Request $request,Response $response, $next)
    {
        $datos = $request->getParsedBody();
        
        $nombre = $datos['nombre'];
        $sexo = $datos['sexo'];

        $response->write("Antes2 <br>");
        
        if($nombre="mer" && $sexo="f")
        {
            $response = $next($request,$response);
            $response->write("Despues2 <br>");
        }
            $next($request, $response);

        return $response;
    }
   
}
<?php

interface IApiUsable{
    
    public function TraerUno($req, $res, $args);
    public function TraerTodos($req, $res, $args);
    public function CargarUno($req, $res, $args);
    public function BorrarUno($req, $res, $args);
    public function ModificarUno($req, $res, $args);
}

?>
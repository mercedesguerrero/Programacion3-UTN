<?php

class Persona{
    private $nombre;
    private $dni;

    function __construct($nombre, $dni)
    {
        $this->nombre= $nombre;
        $this->dni= $dni;
    }

    public function getNombre()
    {
        return $this->nombre;
    }    
    public function getDni()
    {
        return $this->dni;
    }    
    public function setNombre($nom)
    {
        $this->nombre= $nom;
    }    
    public function setDni($dni)
    {
        $this->dni= $dni;
    }    
} 
?>
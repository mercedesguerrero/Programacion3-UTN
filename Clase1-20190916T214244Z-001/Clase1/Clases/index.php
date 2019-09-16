<?php

require_once './Alumno.php';

    $p= new Persona("Lean", 22);
    $a= new Alumno("Mer", 34, 123, 2);

    echo "Nombre: " . $p->getNombre() . " - Dni: " . $p->getDni();
    echo "</br>";
    echo "Nombre: " . $a->getNombre() . " - Dni: " . $a->getDni() . " Legajo: " . $a->getlegajo() . " Cuatrimestre: " . $a->getcuatrimestre();
?>
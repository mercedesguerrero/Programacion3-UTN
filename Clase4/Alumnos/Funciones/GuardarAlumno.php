<?php

    if (isset($_POST["nombre"]) && isset($_POST['dni']) && isset($_POST['legajo']) && isset($_POST['cuatrimestre'])) {

        $nombre = $_POST['nombre'];
        $dni = $_POST['dni'];
        $legajo = $_POST['legajo'];
        $cuatrimestre = $_POST['cuatrimestre'];

        $a= new Alumno($nombre, $dni, $legajo, $cuatrimestre); 

        if($a->Guardar($RUTA_ALUMNOS))
        {
            echo "Se guardo alumno.";
        }
        else
            echo "No se pudo guardar alumno.";
        
    }
    else
    echo 'Error cargue "nombre", "dni", "legajo" y "cuatrimestre".';

?>
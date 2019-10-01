<?php
if(isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['mail']) && isset($_FILES['imagen']))
{
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $mail = $_POST['mail'];
    $imagen = $_FILES['imagen'];

    $unAlumno = new Alumno($nombre, $apellido, $mail);
            
    if($unAlumno->Guardar(RUTA_ALUMNOS))
    {
        if($unAlumno->CargarImagen($imagen, RUTA_CARPETA_IMAGENES))
        {
            echo "SE CARGO ALUMNO CON FOTO.";
        }
        else
        {
            echo "No se pudo cargar con imagen.";
        }     
    }
    else
        echo "No se pudo guardar.";
}        
?>
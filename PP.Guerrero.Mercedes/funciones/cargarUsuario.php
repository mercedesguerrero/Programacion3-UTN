<?php
if(isset($_POST['email']) && isset($_POST['nombre']) && isset($_POST['clave']) && isset($_FILES['imagen1']) && isset($_FILES['imagen2']))
{
    $email = $_POST['email'];
    $nombre = $_POST['nombre'];
    $clave = $_POST['clave'];
    $imagen1 = $_FILES['imagen1'];
    $imagen2 = $_FILES['imagen2'];

    $unUsuario = new Usuario(1, $email, $nombre, $clave);
            
    if($unUsuario->Guardar($RUTA_USUARIOS))
    {
        if($unUsuario->CargarImagen($imagen1, $RUTA_CARPETA_IMAGENES, 1) && $unUsuario->CargarImagen($imagen2, $RUTA_CARPETA_IMAGENES, 2))
            echo "SE CARGO EL USUARIO CON IMAGENES.";
        else
        {
            $unUsuario->BorrarUsuario($RUTA_USUARIOS);
            echo "No se pudo cargar con imagen.";
        }
    }
    else
        echo "No se pudo guardar.";
    
}
else
    echo 'Error cargue "email", "nombre", "clave" e "imagen".';
?>
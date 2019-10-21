<?php
if(isset($_GET['legajo']) && isset($_GET['clave']))
{
    $legajo = $_GET['legajo'];
    $clave = $_GET['clave'];

    $respuesta = Usuario::ExisteUsuarioPorLegajoYClave($RUTA_USUARIOS, $legajo, $clave);
    
    if($respuesta)
    {
        //$user= Usuario::DevuelveUsuarioxLegajoyClave($RUTA_USUARIOS, $legajo, $clave);
        $user= Usuario::DevuelveArrayPorLegajoyClave($RUTA_USUARIOS, $legajo, $clave);
        //echo json_decode($user);

        //echo Usuario::DevuelveArrayPorLegajoyClave($RUTA_USUARIOS, $legajo, $clave);

        echo "Legajo: " . $legajo . " Clave: " . $clave; 

        
    }
    else{
       
        echo "No existe el usuario.";
    }
}
else
{
    echo 'Error cargue "legajo" y "clave".';
}
?>
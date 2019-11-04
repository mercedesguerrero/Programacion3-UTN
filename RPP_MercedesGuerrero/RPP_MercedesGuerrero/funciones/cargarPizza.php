<?php
if(isset($_POST['precio']) && isset($_POST['tipo']) && isset($_POST['cantidad']) && isset($_POST['sabor']) && isset($_FILES['imagen1'] && isset($_FILES['imagen2']))
{

    $precio= $_POST['precio'];
    $tipo= $_POST['tipo'];
    $cantidad= $_POST['cantidad'];
    $sabor= $_POST['sabor'];
    $imagen1 = $_FILES['imagen1'];
    $imagen2 = $_FILES['imagen2'];

    if($tipo == "molde" || $tipo == "piedra")
    {
        if($sabor == "muzza" || $sabor == "jamon" || $sabor == "especial")
        {
            Pizza::AltaPizza(RUTA_USUARIOS, $precio, $tipo, $cantidad, $sabor, $imagen1, $imagen2);
        }
        else
            echo 'Error cargue "sabor" como "muzza", "jamon", "especial".';
    }
    else
        echo 'Error cargue "tipo" como "molde" o "piedra".';
}
else
    echo 'Error cargue "sabor", "precio", "tipo", "cantidad" e "imagen".';
?>
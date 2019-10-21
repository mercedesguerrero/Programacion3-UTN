<?php
class Usuario
{
    public $legajo;
    public $email;
    public $nombre;
    public $clave;

    function __construct($legajo, $email, $nombre, $clave)
    {
        $this->legajo = $legajo;
        $this->email = $email;
        $this->nombre = $nombre;
        $this->clave = $clave;
    }

    public function Guardar($path)
    {
        $usuariosList = self::Cargar($path);
        if($usuariosList != null)
        {
            $maxId = self::TraerMayorId($usuariosList);
            $this->legajo = $maxId + 1;
            if(!self::ExisteUsuarioEnLista($usuariosList, $this))
            {
                if(file_exists($path))
                {
                    $archivo = fopen($path, "a");
                    return fwrite($archivo, $this->DevolverJson().PHP_EOL);//PHP_EOL (string) El símbolo 'Fin De Línea' correcto de la plataforma en uso
                }
                $archivo = fopen($path, "w");
                return fwrite($archivo, $this->DevolverJson().PHP_EOL);
            }
        }
        else
        {
            if(file_exists($path))
            {
                $archivo = fopen($path, "a");
                return fwrite($archivo, $this->DevolverJson().PHP_EOL);
            }
            $archivo = fopen($path, "w");
            return fwrite($archivo, $this->DevolverJson().PHP_EOL);
        }
        return false;
    }

    public function DevolverJson()
    {
        //json_encode — Retorna la representación JSON del valor dado
        return json_encode($this, JSON_UNESCAPED_UNICODE);//Codificar caracteres Unicode multibyte literalmente
    }

    public static function GuardarTodo($usuariosList, $path)
    {
        if(file_exists($path))
        {
            foreach ($usuariosList as $key => $user)
            {
                if($key == 0)
                {
                    $archivo = fopen($path, "w");//Abre un archivo para sólo escritura. Si no existe, crea uno nuevo. Si existe, borra el contenido.
                    fwrite($archivo, json_encode($usuariosList[0]).PHP_EOL);
                    fclose($archivo);
                }
                else
                {
                    $archivo = fopen($path, "a");//Abre un archivo para sólo escritura. Si no existe, crea uno nuevo. Si existe, mantiene el contenido. El cursor comienza en el final del archivo.
                    fwrite($archivo, json_encode($usuariosList[$key]).PHP_EOL);
                    fclose($archivo);
                }
            }
            return true;
        }
        return false;
    }
    public static function Cargar($path)
    {
        if(file_exists($path))
        {
            $archivo = fopen($path, "r");//Abre un archivo para sólo lectura. El cursor comienza al principio del archivo.
            $usuariosList = array();
            while(!feof($archivo))
            {
                $renglon = fgets($archivo);
                if($renglon != "")
                {
                    $objeto = json_decode($renglon);//Decodifica un string de JSON(array asociativo)
                    if (isset($objeto)!=null) {
                        $usuario = new Usuario($objeto->legajo, $objeto->email, $objeto->nombre, $objeto->clave);
                        array_push($usuariosList, $usuario);
                    }
                    //isset -> Determina si una variable está definida y no es NULL
                }
            }
            fclose($archivo);
            if(count($usuariosList) > 0)//count — Cuenta todos los elementos de un array u objeto
                return $usuariosList;
        }
        return null;
    }

    private static function ExisteUsuarioEnLista($usuariosList, $usuario)
    {
        foreach ($usuariosList as $user)
        {
            if($user->legajo == $usuario->legajo)
                return true;
        }
        return false;
    }

    public static function ExisteUsuarioPorLegajoYClave($path, $legajo, $clave)
    {
        $usuariosList = self::Cargar($path);
        
        if($usuariosList != null)
        {
            foreach ($usuariosList as $user)
            {
                if($legajo == $user->legajo &&
                    $clave == $user->clave){
                        return true;
                    }       
            }
        }
        return false;
    }

    public static function ExistePizzaPorSabor($path, $sabor)
    {
        $usuariosList = self::Cargar($path);
        if($usuariosList != null)
        {
            foreach ($usuariosList as $zapi)
            {
                if(strtolower($sabor) == strtolower($zapi->sabor)){
                    return true;
                }
            }
        }
        return false;
    }

    public static function TraerUsuarioPorLegajo($path, $legajo)
    {
        $usuariosList = self::Cargar($path);
        if($usuariosList != null)
        {
            foreach ($usuariosList as $user)
            {
                if($user->legajo == $legajo)
                    return $user;
            }
        }
        return null;
    }

    public static function DevuelveUsuarioxLegajoyClave($path, $legajo, $clave)
    {
        $usuariosList = self::Cargar($path);

        if($usuariosList != null)
        {
            foreach ($usuariosList as $user)
            {
                if(strtolower($user->legajo) == strtolower($legajo) && strtolower($user->clave) == strtolower($clave))
                    return $user;
            }
        }
        return null;
    }

    public static function devuelveUsuario($user)
    {
        return  $user->legajo && 
                $user->email &&
                $user->nombre &&
                $user->clave;
    }

    public static function DevuelveArrayPorLegajoyClave($path, $legajo, $clave)
    {
        $usuariosList = self::Cargar($path);
        $retorno= array();
        if($usuariosList != null)
        {
            foreach ($usuariosList as $user)
            {
                if($user->legajo == $legajo && $user->clave == $clave)
                {
                    array_push($retorno, $user);
                    //var_dump($retorno);
                    return $retorno;
                }
            }
        }
        return null;
    }

    public static function DevuelveStringPorLegajoyClave($path, $legajo, $clave)
    {
        $usuariosList = self::Cargar($path);
        $retorno= "";
        if($usuariosList != null)
        {
            foreach ($usuariosList as $user)
            {
                if($user->legajo == $legajo && $user->clave == $clave)
                {
                    return $retorno . $user->legajo . $user->email . $user->nombre . $user->clave;
                }
            }
        }
        return null;
    }

    public static function TraerUsuarioPorLegajoyClave($ruta, $legajo, $clave)
    {
        $usuariosList = self::Cargar($ruta);
        if($usuariosList != null)
        {
            foreach ($usuariosList as $user)
            {
                if($user->legajo == $legajo && $user->clave == $clave)
                    return $user;
            }
        }
        return null;
    }

    public static function TraerIdStock($path, $sabor, $tipo, $cantUnidades)
    {
        $usuariosList = self::Cargar($path);
        if($usuariosList != null)
        {
            foreach ($usuariosList as $zapi)
            {
                if($zapi->sabor == $sabor &&
                    $zapi->tipo == $tipo &&
                    $zapi->cantUnidades >= $cantUnidades)
                    return $zapi->id;
            }
        }
        return null;
    }
    
    public static function TraerMayorId($usuariosList)
    {
        $maxId = $usuariosList[0]->legajo;
        foreach ($usuariosList as $user)
        {
            if($user->legajo > $maxId)
                $maxId = $user->legajo;
        }
        return $maxId;
    }

    public function Vender($path, $cantUnidades)
    {
        $usuariosList = self::Cargar($path);
        if($usuariosList != null)
        {
            if(self::ExistePizzaEnLista($usuariosList, $this))
            {
                foreach ($usuariosList as $key => $zapi)
                {
                    if($zapi->id == $this->id)
                    {
                        $usuariosList[$key]->cantUnidades -= $cantUnidades;
                        break;
                    }
                }
                return self::GuardarTodo($usuariosList, $path);
            }
        }
        return false;
    }

    public function CargarImagen($files, $pathCarpetaImagenes, $numero)
    {
        if(isset($files))
        {
            $extension = self::TraerExtensionImagen($files);

            if($extension != null)
            {
                $nombreDelArchivoImagen = $this->legajo."_".$numero.$extension;
                $pathCompletaImagen = $pathCarpetaImagenes.$nombreDelArchivoImagen;
                return move_uploaded_file($files["tmp_name"], $pathCompletaImagen);
            }
        }
        return false;
    }

    public static function TraerExtensionImagen($files)
    {
        switch ($files["type"])
        {
            case 'image/jpeg':
                $extension = ".jpg";
                break;
            case 'image/png':
                $extension = ".png";
                break;
            default:
                return null;
                break;
        }
        return $extension;
    }

    public static function ModificarStockYPrecio($path, $sabor, $tipo, $precio, $cantidad)
    {
        $usuariosList = self::Cargar($path);
        
        if(!$usuariosList || $usuariosList == "NADA")
        {
            echo "<br/>No hay pizzas cargadas.";
            die;
        }
        if(!self::ExistePizzaPorSaborYTipo($path, $sabor, $tipo))
        {
            echo "<br/>No hay pizza de ".$sabor." tipo ".$tipo.".";
        }
        else
        {
            foreach ($usuariosList as $key => $zapi)
            {
                if($zapi->sabor == $sabor && $zapi->tipo == $tipo)
                {
                    $zapi->precio= $precio;
                    $zapi->cantUnidades+= $cantidad;
                    break;
                }
            }
        }
        return self::GuardarTodo($usuariosList, $path);
    }

    public static function DevuelveArrayXsaborYtipo($path, $sabor, $tipo)
    {
        $usuariosList = self::Cargar($path);
        if($usuariosList != null)
        {
            $newusuariosList = array();
            foreach ($usuariosList as $zapi)
            {
                if($zapi->sabor == $sabor && $zapi->tipo == $tipo)
                    array_push($newusuariosList, $zapi);
            }
            if(count($newusuariosList) > 0)
                return $newusuariosList;
        }
        return null;
    }

    public function BorrarUsuario($path, $usuarioABorrar)
    {
        $usuariosList = self::Cargar($path);
        if($usuariosList != null)
        {
            if(self::ExisteUsuarioEnLista($usuariosList, $usuarioABorrar))
            {
                foreach ($usuariosList as $key => $user)
                {
                    if($user->legajo == $usuarioABorrar->legajo && $user->email == $usuarioABorrar->email)
                    {
                        unset($usuariosList[$key]);
                        break;
                    }
                }
                return self::GuardarTodo($usuariosList, $path);
            }
        }
        return false;
    }

    public function MoverImgABackUp($carpetaFotosBackup, $carpetaFotos, $path)
    {
        $usuario = self::DevuelvePizzaxSaboryTipo($path, $this->sabor, $this->tipo);
            
        if(!$usuario)
        {
            echo "<br/>No existe esa pizza.";
            die;
        }
        $extension = ".jpg";        
        $fotoUsuario= $usuario->tipo . "_" . $usuario->sabor . $extension;
        $pathFotoOriginal = $carpetaFotos . $fotousuario;
            
        if(file_exists($pathFotoOriginal))
        {
            date_default_timezone_set("America/Argentina/Buenos_Aires");
            $pathFotoBackUp = $carpetaFotosBackup . date('Ymd') . "_" . $fotoUsuario;
            return rename ($pathFotoOriginal, $pathFotoBackUp);
        }
        else
        {
            echo '<br/>Error! no existe la imagen.';
            die;
        }
    }

    public static function ImgUsuariosEnTabla($path)
    {
        $imagenes = scandir($path);
        $retorno = "<table border = 3 bordercolor = red align = left>";
        $retorno .= "<tbody>";
        foreach ($imagenes as $img)
        {
            if(!file_exists($img))
            {
                $retorno .= "<tr>";
                $retorno .= "<td><img src='" . $path . $img . "' height='160' width='160' /></td>";
                $retorno .= "</tr>";
            }
        }
        $retorno .= "</tbody>"; 
        $retorno .= "</table>";
    
        return "<div> " . $retorno . "</div>";
    }

    public function IsEqual($otroUsuario)
    {
        return  $this->legajo == $otroUsuario->legajo && 
                $this->email == $otroUsuario->email &&
                $this->nombre == $otroUsuario->nombre &&
                $this->clave == $otroUsuario->clave;
    }

    static public function logsDeLaAplicacion($caso, $hora, $ip)
    {
        $usuariosList = self::Cargar($path);
        if($usuariosList != null)
        {
            echo "<br>Datos: $caso, $hora, $ip </br>";
            $logs=new Log($caso, $hora, $ip);
            array_push($lista, $Log);
            self::guardarJSON($lista, PATH_ARCHIVOS ."/Log.txt");
        }
    }


   
}
?>
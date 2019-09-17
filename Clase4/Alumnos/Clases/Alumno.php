<?php

require_once './Clases/Persona.php';

class Alumno extends Persona{

    private $legajo; 
    private $cuatrimestre;

    function __construct($nombre, $dni, $legajo, $cuatrimestre)
    {
        parent::__construct($nombre, $dni);
        $this->legajo= $legajo;
        $this->cuatrimestre= $cuatrimestre;
    }

    public function getlegajo()
    {
        return $this->legajo;
    }    
    public function getcuatrimestre()
    {
        return $this->cuatrimestre;
    }

    public function Guardar($path)
    {
        $alumnosList = self::Cargar($path);
        if($alumnosList != null)
        {
            $maxLegajo = self::TraerMayorLegajo($alumnosList);
            $this->legajo = $maxLegajo + 1;
            if(!self::ExisteAlumnoEnLista($alumnosList, $this))
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

    public static function GuardarTodo($alumnosList, $path)
    {
        if(file_exists($path))
        {
            foreach ($alumnosList as $key => $alumni)
            {
                if($key == 0)
                {
                    $archivo = fopen($path, "w");//Abre un archivo para sólo escritura. Si no existe, crea uno nuevo. Si existe, borra el contenido.
                    fwrite($archivo, json_encode($alumnosList[0]).PHP_EOL);
                    fclose($archivo);
                }
                else
                {
                    $archivo = fopen($path, "a");//Abre un archivo para sólo escritura. Si no existe, crea uno nuevo. Si existe, mantiene el contenido. El cursor comienza en el final del archivo.
                    fwrite($archivo, json_encode($alumnosList[$key]).PHP_EOL);
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
            $alumnosList = array();
            while(!feof($archivo))
            {
                $renglon = fgets($archivo);
                if($renglon != "")
                {
                    $objeto = json_decode($renglon);//Decodifica un string de JSON(array asociativo)
                    if (isset($objeto)!=null) {
                        $alumno = new Alumno($objeto->nombre, $objeto->dni, $objeto->legajo, $objeto->cuatrimestre);
                        array_push($alumnosList, $alumno);
                    }
                    //isset -> Determina si una variable está definida y no es NULL
                }
            }
            fclose($archivo);
            if(count($alumnosList) > 0)//count — Cuenta todos los elementos de un array u objeto
                return $alumnosList;
        }
        return null;
    }
    private static function ExisteAlumnoEnLista($alumnosList, $alumno)
    {
        foreach ($alumnosList as $alumni)
        {
            if($alumni->legajo == $alumno->legajo)
                return true;
        }
        return false;
    }
    
    public static function TraerAlumnoPorLegajo($path, $legajo)
    {
        $alumnosList = self::Cargar($path);
        if($alumnosList != null)
        {
            foreach ($alumnosList as $alumni)
            {
                if($alumni->legajo == $legajo)
                    return $alumni;
            }
        }
        return null;
    }
    
    public static function TraerMayorLegajo($alumnosList)
    {
        $maxLegajo = $alumnosList[0]->legajo;
        foreach ($alumnosList as $alumni)
        {
            if($alumni->legajo > $maxLegajo)
                $maxLegajo = $alumni->legajo;
        }
        return $maxLegajo;
    }
    
    public function CargarImagen($files, $pathCarpetaImagenes)
    {
        if(isset($files))
        {
            $extension = self::TraerExtensionImagen($files);
            if($extension != null)
            {
                $nombreDelArchivoImagen = $this->tipo."_".strtolower($this->legajo).$extension;
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

    // public static function ModificarStockYPrecio($path, $sabor, $tipo, $precio, $cantidad)
    // {
    //     $alumnosList = self::Cargar($path);
        
    //     if(!$alumnosList || $alumnosList == "NADA")
    //     {
    //         echo "<br/>No hay Alumnos cargadas.";
    //         die;
    //     }
    //     if(!self::ExisteAlumnoPorSaborYTipo($path, $sabor, $tipo))
    //     {
    //         echo "<br/>No hay Alumno de ".$sabor." tipo ".$tipo.".";
    //     }
    //     else
    //     {
    //         foreach ($alumnosList as $key => $alumni)
    //         {
    //             if($alumni->sabor == $sabor && $alumni->tipo == $tipo)
    //             {
    //                 $alumni->precio= $precio;
    //                 $alumni->cantUnidades+= $cantidad;
    //                 break;
    //             }
    //         }
    //     }
    //     return self::GuardarTodo($alumnosList, $path);
    // }

    // public static function DevuelveArrayXsaborYtipo($path, $sabor, $tipo)
    // {
    //     $alumnosList = self::Cargar($path);
    //     if($alumnosList != null)
    //     {
    //         $newalumnosList = array();
    //         foreach ($alumnosList as $alumni)
    //         {
    //             if($alumni->sabor == $sabor && $alumni->tipo == $tipo)
    //                 array_push($newalumnosList, $alumni);
    //         }
    //         if(count($newalumnosList) > 0)
    //             return $newalumnosList;
    //     }
    //     return null;
    // }

    public function BorrarAlumno($path, $alumnoABorrar)
    {
        $alumnosList = self::Cargar($path);
        if($alumnosList != null)
        {
            if(self::ExisteAlumnoEnLista($alumnosList, $alumnoABorrar))
            {
                foreach ($alumnosList as $key => $alumni)
                {
                    if($alumni->legajo == $alumnoABorrar->legajo && $alumni->dni == $alumnoABorrar->dni)
                    {
                        unset($alumnosList[$key]);
                        break;
                    }
                }
                return self::GuardarTodo($alumnosList, $path);
            }
        }
        return false;
    }
    
    public function MoverImgABackUp($carpetaFotosBackup, $carpetaFotos, $path)
    {
        $Alumno = self::DevuelveAlumnoxSaboryTipo($path, $this->sabor, $this->tipo);
            
        if(!$Alumno)
        {
            echo "<br/>No existe esa Alumno.";
            die;
        }
        $extension = ".jpg";        
        $fotoAlumno= $Alumno->tipo . "_" . $Alumno->sabor . $extension;
        $pathFotoOriginal = $carpetaFotos . $fotoAlumno;
            
        if(file_exists($pathFotoOriginal))
        {
            date_default_timezone_set("America/Argentina/Buenos_Aires");
            $pathFotoBackUp = $carpetaFotosBackup . date('Ymd') . "_" . $fotoAlumno;
            return rename ($pathFotoOriginal, $pathFotoBackUp);
        }
        else
        {
            echo '<br/>Error! no existe la imagen.';
            die;
        }
    }

    public static function ImgAlumnosEnTabla($path)
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

    public function IsEqual($otroAlumno)
    {
        return  $this->nombre == $otroAlumno->nombre && 
                $this->dni == $otroAlumno->dni &&
                $this->legajo == $otroAlumno->legajo &&
                $this->cuatrimestre == $otroAlumno->cuatrimestre;
    }

}
?>
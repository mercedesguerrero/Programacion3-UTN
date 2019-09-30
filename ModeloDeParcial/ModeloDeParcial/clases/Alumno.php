<?php
class Alumno
{
    public $nombre;
    public $apellido;
    public $mail;
    
    function __construct($nombre, $apellido, $mail)
    {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->mail = $mail;
    }

    public function Guardar($path)
    {
        $alumnosList = self::Cargar($path);
        var_dump($alumnosList);
        if($alumnosList != null)
        {//el archivo existe y no esta vacio
            if(!self::existeMailEnLista($alumnosList, $this))//valido que no haya un alumno con el mismo mail
            {// el alumno no existe, lo tengo que agregar
                if(file_exists($path))
                {
                    $archivo = fopen($path, "a");
                    return fwrite($archivo, $this->DevolverJson().PHP_EOL);//PHP_EOL (string) El símbolo 'Fin De Línea' correcto de la plataforma en uso
                }
                else
                {
                    //push al array
                    //y despues guardas el array
                    $archivo = fopen($path, "w");
                    return fwrite($archivo, $this->DevolverJson().PHP_EOL);
                }   
            }
            else
            {
                echo "El alumno existe";
            }
        }
        else
        {//lista vacia , Escribo el alumno
            $archivo = fopen($path, "w");
            return fwrite($archivo, $this->DevolverJson().PHP_EOL);
        }
        fclose($path);
        return false;
    }

    public function DevolverJson()
    {
        //json_encode — Retorna la representación JSON del valor dado
        //si quiero poner los atributos privados ya no le puedo pasar this
        return json_encode($this, JSON_UNESCAPED_UNICODE);//Codificar caracteres Unicode multibyte literalmente
    }

    public static function GuardarTodo($alumnosList, $path)
    {
        if(file_exists($path))
        {
            foreach ($alumnosList as $key => $alum)
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
                    // var_dump($objeto);
                    if (isset($objeto)!=null) {
                        $alumno = new Alumno($objeto->nombre, $objeto->apellido, $objeto->mail);
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

    private static function existeMailEnLista($alumnosList, $alumno)
    {
        foreach ($alumnosList as $alum)
        {
            if($alum->mail == $alumno->mail)
                return true;
        }
        return false;
    }

    public static function existeAlumnoXmailYapellido($path, $mail, $apellido)
    {
        $alumnosList = self::Cargar($path);
        
        if($alumnosList != null)
        {
            foreach ($alumnosList as $alum)
            {
                if($mail == $alum->mail &&
                    $apellido == $alum->apellido){
                        return true;
                    }       
            }
        }
        return false;
    }


    public static function DevuelveAlumnoXmailYapellido($path, $mail, $apellido)
    {
        $alumnosList = self::Cargar($path);
        if($alumnosList != null)
        {
            foreach ($alumnosList as $alum)
            {
                if($alum->mail == $mail && $alum->apellido == $apellido)
                    return $alum;
            }
        }
        return null;
    }
    
    public function CargarImagen($files, $pathCarpetaImagenes)
    {
        if(isset($files))
        {
            $extension = self::TraerExtensionImagen($files);
            if($extension != null)
            {
                $nombreDelArchivoImagen = $this->nombre . "_" . $this->apellido . $extension;
                $pathCompletaImagen = $pathCarpetaImagenes . $nombreDelArchivoImagen;
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

    public static function ModificarAlumno($path, $nombre, $apellido, $mail)
    {
        $alumnosList = self::Cargar($path);
        
        if(!$alumnosList || $alumnosList == "NADA")
        {
            echo "<br/>No hay alumnos cargados.";
            die;
        }
        if(!self::existeAlumnoXmailYapellido($path, $mail, $apellido))
        {
            echo "<br/>No existe el alumno" . $apellido . " email: " . $mail . ".";
        }
        else
        {
            foreach ($alumnosList as $key => $alum)
            {
                if($alum->mail == $mail && $alum->apellido == $apellido)
                {
                    $alum->$nombre= $nombre;
                    $alum->$apellido= $apellido;
                    break;
                }
            }
        }
        return self::GuardarTodo($alumnosList, $path);
    }

    public function MoverImgABackUp($carpetaFotosBackup, $carpetaFotos, $path)
    {
        $alumno = self::DevuelveAlumnoXmailYapellido($path, $this->mail, $this->apellido);
            
        if(!$alumno)
        {
            echo "<br/>No existe el alumno.";
            die;
        }
        $extension = ".jpg";        
        $fotoAlumno= $alumno->apellido . $extension;
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

    public static function ImglumnosEnTabla($path)
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

}
?>
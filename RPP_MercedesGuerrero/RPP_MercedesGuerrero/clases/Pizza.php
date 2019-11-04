<?php
class Pizza
{
    private $id;
    private $precio;
    private $tipo;
    private $cantidad;
    private $sabor;

    function __construct($id, $precio, $tipo, $cantidad, $sabor)
    {
        $this->id = $id;
        $this->precio = $precio;
        $this->tipo = $tipo;
        $this->cantidad = $cantidad;
        $this->sabor= $sabor;
    }

    public function __get($property){
        if(property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __set($property, $value){
        if(property_exists($this, $property)) {
            $this->$property = $value;
        }
    }
    
    // public function __toString()
    // {        
    //     return "id: $this->id  || precio: $this->precio || tipo: $this->tipo   </br>";
    // }


    /** Devuelve array con tipos de las propiedades de la clase (para los headers de la tabla) */
    public static function getPublicProperties(){        
        return array('id', 'precio', 'tipo', 'cantidad', 'sabor','nomFoto1','nomFoto2');
        
    }

    /** toJSON*/
    public function jsonSerialize()
    {
        return 
        [
            'id'   => $this->id,
            'precio'   => $this->precio,
            'tipo' => $this->tipo,
            'cantidad' => $this->cantidad,
            'sabor' => $this->sabor
        ];
    }

    /** Lee archivo (array de json de objeto)
     * 
     * $path = Ubicacion del archivo
     *  Retorna un listado de json de objetos de la clase
     */
    public static function leerFromJSON($path)
    {
        $retorno = array();
        $json = file_get_contents($path);
        $json_data = json_decode($json,true);
        //var_dump($json_data);
        
        foreach ($json_data as $key => $value) 
        {                                                                                
            array_push($retorno, new Pizza($json_data[$key]['id'],$json_data[$key]['precio'],$json_data[$key]['tipo'],$json_data[$key]['cantidad'],$json_data[$key]['sabor']));
        }

        return $retorno;
    }

    public function AltaPizza($path, $pizza)
    {
        echo "<br>Entro en alta Pizza</br>";
        $lista= self::leerFromJSON($path);    
        
        // $maxId = self::TraerMayorId($lista);
        // $id= $maxId + 1;
        $zapi= self::BuscaXCriterio($lista, "id", $id);
        
        if($zapi!=null)
        {
            echo "<br>La Pizza ya existe.<br>";
        }
        else
        { 
            //$zapi= new Pizza($id, $precio, $tipo, $cantidad, $sabor);     
            array_push($lista, $pizza);
            self::guardarJSON($lista, $path);
            echo "<br>La Pizza se guardó<br>";

            // if(self::CargarImagen($imagen1, $id, RUTA_CARPETA_IMAGENES, 1) && self::CargarImagen($imagen2, $id, RUTA_CARPETA_IMAGENES, 2))
            // {
            //     echo "<br>SE CARGO la Pizza CON IMAGENES.<br>";
            // }

            //echo $zapi->jsonSerialize();
                
            // else
            // {
            //     $unPizza->BorrarPizza($RUTA_PizzaS);
            //     echo "No se pudo cargar con imagen.";
            // }
        }

        
    }

    public static function BuscaXCriterio($lista, $criterio, $dato)
    {
        $retorno=null;
        foreach ($lista as $objeto) {
            if ($objeto->$criterio == $dato) 
            {          
                $retorno= $objeto;
                break;
            }
        }
        return $retorno;
    }

    public static function TraerMayorId($lista)
    {
        $maxId= 0;

        if($lista!=null)
        {
            $maxId= $lista[0]->id;
            foreach ($lista as $zapi)
            {
                if($zapi->id > $maxId)
                {
                    $maxId = $zapi->id;
                }
            }
        }
        return $maxId;
    }

    public static function guardarJSON($listado, $tipoArchivo) 
    {
        $archivo = fopen($tipoArchivo, "w");
        $array = array();
        foreach($listado as $objeto){
            array_push($array, $objeto->jsonSerialize());
        }
        fputs($archivo, json_encode($array) . PHP_EOL);                    

        fclose($archivo);

        return $listado;
    }


    public static function CargarImagen($files, $id, $pathCarpetaImagenes, $numero)
    {
        if(isset($files))
        {
            $extension = self::TraerExtensionImagen($files);

            if($extension != null)
            {
                $tipoDelArchivoImagen = "PIZZA" . $id . "_" . $numero . $extension;
                $pathCompletaImagen = $pathCarpetaImagenes . $tipoDelArchivoImagen;
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

    public static function TraerUnaPizza($id)
    {
        $lista = self::leerFromJSON($path);
        $zapi= self::BuscaXCriterio($lista, "id", $id);
        
        if($zapi==null)
        {
            echo "<br>La Pizza NO existe<br>";
        }
        else
        {
            echo "<br>Se encontrò la pizza<br>";
        }

        return $zapi;

    }

    public static function ImgPizzasEnTabla($path)
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

    // static public function login($id, $cantidad)
    // {
    //     echo "<br>Entro en login con datos:  $id , $cantidad </br>";    
    //     $lista= Pizza::leerFromJSON(RUTA_PizzaS);        
    //     $zapi= self::BuscaXCriterio($lista, "id", $id);
        
    //     if($zapi==null)
    //     {
    //         echo "<br>El zapi NO existe<br>";
    //     }
    //     else
    //     {      
    //         if($zapi->cantidad== $cantidad)
    //         {
    //             echo $zapi;
    //             echo "<br>Contraseña correcta<br>";
    //         }
    //         else
    //         {
    //             echo "<br>Contraseña incorrecta<br>";
    //         }
    //     }
    // }

    // static public function log($caso, $hora, $ip)
    // {
    //     $lista = Log::leerFromJSON(RUTA_LOGS);
    //     echo "<br>Entro log con datos: $caso, $hora, $ip </br>";
    //     $Log= new Log($caso ,$hora,$ip);
    //     array_push($lista, $Log);
    //     self::guardarJSON($lista, RUTA_LOGS);
    // }


    static public function modificarPizza($path, $id, $precio, $tipo, $cantidad, $sabor, $foto1, $foto2)    
    {
        $lista = self::leerFromJSON($path);
        $zapi= self::BuscaXCriterio($lista, "id", $id);
        
        if($zapi==null)
        {
            echo "<br>La Pizza NO existe, no se puede modificar<br>";
        }
        else
        {      
            $zapi->precio= $precio;
            $zapi->tipo= $tipo;
            $zapi->cantidad= $cantidad;
            $zapi->sabor= $sabor;

            $zapi->MoverImgABackUp(RUTA_CARPETA_BACKUP, RUTA_CARPETA_IMAGENES, $id, 1);
            $zapi->MoverImgABackUp(RUTA_CARPETA_BACKUP, RUTA_CARPETA_IMAGENES, $id, 2);
            
            self::guardarJSON($lista, $path);
        }
    }

    public function MoverImgABackUp($carpetaFotosBackup, $carpetaFotos, $id, $numFoto)
    {
        $extension = ".jpg";     
        
        $fotoPizza= "PIZZA" . $id . "_" . $numFoto . $extension;   
        $pathFotoOriginal = $carpetaFotos . $fotoPizza;
            
        if(file_exists($pathFotoOriginal))
        {
            date_default_timezone_set("America/Argentina/Buenos_Aires");
            $pathFotoBackUp = $carpetaFotosBackup . date('Ymd') . "_" . $fotoPizza;
            return rename ($pathFotoOriginal, $pathFotoBackUp);
        }
        else
        {
            echo '<br/>Error! no existe la imagen.';
            die;
        }
    }

    // static public function logs($fecha)
    // {
    //     $lista = Log::leerFromJSON(RUTA_LOGS);
    //     echo "<br>Entro log con fecha: $fecha </br>";
        
    //     foreach($lista as $objeto)
    //     {//campo con formato 20190930_080941

    //         $dia= explode('_', $objeto->hora);

    //         if ($dia[0]>$fecha)
    //         {
    //             echo $objeto;
    //         }
    //     }
        
    // }

    public static function verPizzas($path)
    {
        $lista = self::leerFromJSON($path);  
        $retorno = "";
        
        if($lista != null)
        {
            foreach ($lista as $zapi)
            {
                $retorno .= "<div align='left'>Id: " . $zapi->id . 
                    " || precio: " . $zapi->precio . " || tipo: " . $zapi->tipo . 
                    " || cantidad: " . $zapi->cantidad . "</div>";
                
            }
        }
        return $retorno;
    }

    // static public function verPizzas($path)
    // {  
    //     $lista = self::leerFromJSON($path);   
        
    //     foreach($lista as $objeto)
    //     {            
    //         echo $objeto;
    //     }
    // }
    
    static public function verPizza($id)
    {
         
        $lista = self::leerFromJSON(RUTA_PIZZA);   
        $listaFiltrada= self::SubListaXCriterio($lista, "id", $id, FALSE); 

        foreach($listaFiltrada as $objeto)
        {            
            echo $objeto;
        }
    }

    public static function SubListaXCriterio($lista, $criterio, $dato, $caseSensitive)
    {
        $retorno=null;        
        $sublista=array();
        
        /*  
        if(!$caseSensitive)
        {//Si esta en FALSE paso Todo a minisculas (Array y dato)
            $lista = array_map('strtolower', $lista);  //Esta Mierda no me esta andando aca...
            $dato=strtolower($dato);
        }        
        */
        //self::debugAlgo($lista);        
        foreach ($lista as $objeto) 
        {   
            //echo "$criterio , $dato</br>";
        //    self::debugAlgo($objeto);         
            //if ($objeto->criterio == $dato) 
            if ( strtolower($objeto->$criterio) == strtolower($dato) )
            {//si encuentra lo agrego en la sublista
                array_push($sublista, $objeto);
            }
        }

        if(count($sublista)>0)
        {
            $retorno= $sublista;
        }
        return $retorno;
    }


}
?>
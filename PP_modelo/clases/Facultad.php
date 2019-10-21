
<?php

    require_once './clases/upload.php';
    require_once './clases/Usuario.php';
    require_once './clases/Log.php';

class Facultad {
    
    //PUNTO - 1    PARCIAL 
    static public function AltaUsuario( $legajo, $email, $nombre,  $clave,$foto1, $foto2 )
    {
        echo "<br>Entro en alta Usuario con datos: $legajo, $email, $nombre,  $clave,$foto1, $foto2 </br>";
        $lista = Usuario::leerFromJSON(PATH_ARCHIVOS ."/Usuario.txt");        
        $Usuario=self::BuscaXCriterio($lista, "legajo", $legajo);
        
        if($Usuario!=null)
        {
            echo "<br>El Usuario ya existe<br>";
        }
        else
        {      
            //echo "<br>Nuevo Usuario<br>";             
            $nomFoto1 = "SIN_FOTO"; 
            $nomFoto2 = "SIN_FOTO"; 
            if ($foto1 != null) {                
                $nomFoto1="foto_01_".$legajo;
                Upload::cargarImagenPorNombre($foto1, $nomFoto1, "./fotosUsuario/");
            }
            if ($foto2 != null) {                
                $nomFoto2="foto_02_".$legajo;
                Upload::cargarImagenPorNombre($foto2, $nomFoto2, "./fotosUsuario/");
            }
            $Usuario=new Usuario($legajo, $email, $nombre,  $clave,$nomFoto1, $nomFoto2 );
            array_push($lista, $Usuario);

            self::guardarJSON($lista, PATH_ARCHIVOS ."/Usuario.txt");
        }
    }
    

    //PUNTO -2 PARCIAL
    static public function login($legajo , $clave)
    {
        echo "<br>Entro en login con datos:  $legajo , $clave </br>";    
        $lista = Usuario::leerFromJSON(PATH_ARCHIVOS ."/Usuario.txt");        
        $Usuario=self::BuscaXCriterio($lista, "legajo", $legajo);
        
        if($Usuario==null)
        {
            echo "<br>El Usuario NO existe<br>";
        }
        else
        {      
            echo "<br>validar pass Usuario<br>";
            if($Usuario->clave==$clave)
            {
                echo $Usuario;
            }
            else
            {
                echo "<br>Clave incorrecta<br>";
            }


           
        }
    }

    //Punto - 3 bis
    static public function log($caso ,$hora,$ip)
    {
        $lista = Log::leerFromJSON(PATH_ARCHIVOS ."/Log.txt");
        echo "<br>Entro log con datos: $caso ,$hora,$ip </br>";
        $Log=new Log($caso ,$hora,$ip);
        array_push($lista, $Log);
        self::guardarJSON($lista, PATH_ARCHIVOS ."/Log.txt");
    }

    //PUNTO - 3 PARCIAL
    static public function modificarUsuario($legajo, $email,  $nombre ,  $clave, $foto1 , $foto2)    
    {
        //echo "<br>Entro en modificarUsuario con datos: $legajo, $email,  $nombre ,  $clave, $foto1 , $foto2 </br>";
        $lista = Usuario::leerFromJSON(PATH_ARCHIVOS ."/Usuario.txt");
        $Usuario=self::BuscaXCriterio($lista, "legajo", $legajo);
        
        if($Usuario==null)
        {
            echo "<br>El Usuario NO existe, no se puede modificar<br>";
        }
        else
        {      
            //echo "<br>Modifica Usuario<br>";             
            $nomFoto1 = "SIN_FOTO"; 
            $nomFoto2 = "SIN_FOTO"; 
            if ($foto1 != null) {                
                $nomFoto1="foto_01_".$legajo;
                Upload::cargarImagenPorNombre($foto1, $nomFoto1, "./fotosUsuario/");
            }
            if ($foto2 != null) {                
                $nomFoto2="foto_02_".$legajo;
                Upload::cargarImagenPorNombre($foto2, $nomFoto2, "./fotosUsuario/");
            }            
            //modificado con seters magicos XD            
            $Usuario->email=$email;
            $Usuario->nombre=$nombre;
            $Usuario->clave=$clave;
            $Usuario->nomFoto1=$nomFoto1;
            $Usuario->nomFoto2=$nomFoto2;
            //self::guardarJSON($lista, PATH_ARCHIVOS ."/Usuario.txt", "Usuario");
            self::guardarJSON($lista, PATH_ARCHIVOS ."/Usuario.txt");
        }
    }
    
    //PUNTO - 5 PARCIAL
    static public function verUsuarios()
    {
        //echo "<br>Entro en verUsuarios: </br>";    
        $lista = Usuario::leerFromJSON(PATH_ARCHIVOS ."/Usuario.txt");   
        
        foreach($lista as $objeto)
        {            
            echo $objeto;
        }
    }
    
    //PUNTO - 6 PARCIAL
    static public function verUsuario($legajo)
    {
        //echo "<br>Entro en verUsuario: </br>";    
        $lista = Usuario::leerFromJSON(PATH_ARCHIVOS ."/Usuario.txt");   
        $listaFiltrada=self::SubListaXCriterio($lista, "legajo", $legajo,FALSE); 

        foreach($listaFiltrada as $objeto)
        {            
            echo $objeto;
        }
    }

    //PUNTO -7 PARCIAL
    static public function logs($fecha )
    {
        $lista = Log::leerFromJSON(PATH_ARCHIVOS ."/Log.txt");
        echo "<br>Entro log con datos: $fecha </br>";
        
        foreach($lista as $objeto)
        {//campo con formato 20190930_080941

            $dia=explode('_', $objeto->hora);
            //self::debugAlgo($dia[0]);

            if ($dia[0]>$fecha)
            {
                echo $objeto;
            }
        }
        
    }





    /**Funcion de Busqueda Generica en listado
     * Usa los metodos magicos __get para buscar por atributo del objeto
     * criterio= atributo del objeto
     * dato = dato a buscar en dicho atributo
     * 
     * Si encuentra devuelve el objeto, si no devuelve null
     */
    public static function BuscaXCriterio($lista, $criterio, $dato)
    {
        $retorno=null;
        foreach ($lista as $objeto) {
            if ( $objeto->$criterio == $dato) 
            {          
                $retorno= $objeto;
                break;
            }
        }
        return $retorno;
    }

    /**Genera una lista filtrada por criterio 
     * 
     * lista = lista de objetos donde buscar
     * criterio = atributo del objeto a buscar
     * dato = valor a buscar en el atributo del objeto
     * caseSensitive = TRUE /FALSE
    */
    public static function SubListaXCriterio($lista, $criterio, $dato,$caseSensitive)
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


//************ ARCHIVOS ********** */
    
    public static function guardarJSON($listado, $nombreArchivo) 
    {
        $archivo = fopen($nombreArchivo, "w");
        $array = array();
        foreach($listado as $objeto){
            array_push($array,$objeto->jsonSerialize());
        }
        fputs($archivo,  json_encode($array) . PHP_EOL);                    

        fclose($archivo);
        return $listado;
    }

    
    //************ DEBUG ********** */
    
    public static function debugAlgo($algo)
    {
        echo "</br> ------- var_dump() -------- </br>";
        var_dump($algo);
        echo "</br>";
    }

}//FIN class Facultad 

?>

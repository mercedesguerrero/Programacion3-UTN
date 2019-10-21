<?php
/*
1- caso: cargarUsuario (post): 
Se deben guardar los siguientes datos: legajo, email, nombre, clave y dos fotos. Los
datos se guardan en el archivo usuarios.xxx y las fotos en la carpeta img/fotos tomando el legajo como
identificador(el legajo no puede estar repetido).
*/
class Usuario {

    private $legajo; 
    private $email;
    private $nombre; 
    private $clave; 
    private $nomFoto1;
    private $nomFoto2;
    

    function __construct($legajo, $email,$nombre, $clave,$nomFoto1, $nomFoto2)
    {
        $this->legajo= $legajo;
        $this->email= $email;
        $this->nombre= $nombre;
        $this->clave= $clave;
        $this->nomFoto1= $nomFoto1;        
        $this->nomFoto2= $nomFoto2; 
    }


// ------- Getters && Setters Magicos ------------------- 
// de esta forma me ahorro de hacer todos los getters y setters a mano

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



    
    //------------ Funciones ---------------
    public function __toString()
    {        
        return "legajo: $this->legajo  || email: $this->email ||nombre: $this->nombre   </br>";
    }


    /** Devuelve array con nombres de las propiedades de la clase (para los headers de la tabla) */
    public static function getPublicProperties(){        
        return array('legajo','email','nombre','clave','nomFoto1','nomFoto2');
        
    }

    /** seria un tojson*/
    public function jsonSerialize()
    {
        return 
        [
            'legajo'   => $this->legajo,
            'email'   => $this->email,
            'nombre' => $this->nombre,
            'clave' => $this->clave,
            'nomFoto1' => $this->nomFoto1,
            'nomFoto2' => $this->nomFoto2
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
         //   array_push($retorno,new Usuario($json_data[$key]['nombre'],$json_data[$key]['apellido'],$json_data[$key]['email'],$json_data[$key]['nomFoto']));                                                                                   
            array_push($retorno,new Usuario($json_data[$key]['legajo'],$json_data[$key]['email'],$json_data[$key]['nombre'],$json_data[$key]['clave'],$json_data[$key]['nomFoto1'],$json_data[$key]['nomFoto2']));
        }
        return $retorno;
    }
    

}
?>
<?php

require_once './Clases/Alumno.php';

class Universidad{

    private $nombre;
    private static $AlumnosList= array();

    function __construct($nombre)
    {
        $this->nombre= $nombre;
    }

    public function getNombre()
    {
        return $this->nombre;
    }    

    public function getList()
    {
        return $this->AlumnosList;
    }    
    
    public static function GuardarAlumno($alumno)
    {
        

        echo "</br> ---------------- </br>";
        var_dump($alumno);
        echo "</br> ---------------- </br>";
        array_push(self::$AlumnosList, $alumno);

        var_dump(self::$AlumnosList);
    }

    public static function mostrarAlumnos()
    {
        foreach ($AlumnosList as $alum)
        {
            echo get_object_vars ($alum);
        }
    }

}
?>
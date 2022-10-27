<?php

/*
 * Manejo de la base de datos de mysql
 */

class Mysqldb
{
    // Datos de la conexion
    private $host = 'mysql';
    private $user = 'default';
    private $pass = 'secret';
    private $dbname = 'tiendamvc';

    // Atributos
    private static $instancia = null;
    private $db = null;

    private function __construct()
    {
        // ATTR_DEFAULT_FETCH_MODE devuelve true o false y se lo manda a
            //  FETCH_OBJ que lo recibe y lo convierte en un objeto.
        // ATTR_ERROMODE devuelve un reporte de errores y se lo manda a
            //  ERRMODE_WARNING que "Eleva E_WARNING"
        $options =[
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
        ];

        try {

            $this -> db = new PDO(
                'mysql:host=' . $this->host . ';dbname=' . $this->dbname,
                $this->user,
                $this->pass,
                $options
            );

        } catch (PDOException $error) {

            exit('La base de datos no está accesible');

        }
    }

    public static function getInstance()
    {
        //self hace referencia a la clase para así mandar llamar funciones estáticas.
        //this hace referencia a un objeto ya instanciado para mandar llamar funciones de cualquier otro tipo.
        if (is_null(self::$instancia)) {
            self::$instancia = new Mysqldb();
        }

        return self::$instancia;
    }

    public function getDatabase()
    {
        return $this->db;
    }
}
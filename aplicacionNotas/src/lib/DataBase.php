<?php

namespace Vidamrr\Notas\lib;
use PDO;
use PDOException;

class DataBase{
    private string $host;
    private string $db;
    private string $user;
    private string $password;
    private string $charset;

    //haz el contructor
    public function __construct(){
        $this->host = 'localhost';
        $this->db = 'aplicacionnotas';
        $this->user = 'root';
        $this->password = '5511';
        $this->charset = 'utf8';
    }

    public function connect (){
        try{
            $connection = "mysql:host={$this->host};dbname={$this->db};charset={$this->charset}";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false
            ];
    
            $pdo = new PDO($connection, $this->user, $this->password, $options);
            return $pdo;
        }catch(PDOException $e){
            //throw $th;
            echo "Error de conexión a la base de datos: " . $e->getMessage();
            throw new PDOException("Error de conexión a la base de datos.", 1);
        }
    }
}
?>
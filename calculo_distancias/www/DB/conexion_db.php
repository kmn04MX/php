<?php
include_once "config/config_bd.php";

class Conexion
{

    public $_db;
    public function __construct()
    {
        try {
            $host        = NOMBRE_HOST;
            $port         = PUERTO;
            $database    = BASE_DE_DATOS;
            $user        = USUARIO;
            $passwd        = CONTRASENA;
            $driver        = DRIVER;

            $this->_db = new PDO($driver . ':host=' . $host . '; port=' . $port . '; dbname=' . $database, $user, $passwd);
            $this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "conexion establecida";
        } catch (PDOException $e) {
            echo "Fallo la conexion a la Bd: " . $e->getMessage();
            die();
        }
    }
    function conect_carterah()
    {

        $servidor = "localhost";
        $usuario = "root";
        $password = "";
        $dbname = "carterah";

        try {

            $dsn = "mysql:host=$servidor;dbname=$dbname";


            $dbh = new PDO($dsn, $usuario, $password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "La conexión ha fallado: " . $e->getMessage();
        }

        return $dbh;
    }

    function conect_cp_gadgets()
    {

        $servidor = "localhost";
        $usuario = "root";
        $password = "";
        $dbname = "p_gadgets";

        try {

            $dsn = "mysql:host=$servidor;dbname=$dbname";


            $dbh = new PDO($dsn, $usuario, $password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "La conexión ha fallado: " . $e->getMessage();
        }

        return $dbh;
    }
    function _cierraBase()
    {
        $this->_db = null;
        echo "se cerro la conexion";
    }

    function _procesaQuery($sql)
    {
        try {
            $stmt = $this->_db->prepare($sql);
            if ($stmt->execute()) {
                # code...
                $resSQL = array(
                    "error" => 0,
                    "mensaje" => "Se concreto la instruccion correctamente",
                    "rs" => $stmt
                );
            }
        } catch (PDOException $e) {
            $resSQL = array(
                "error" => 1,
                "mensaje" => "Ocurrio un error en la consulta: " . $e->getMessage()
            );
        }

        return $resSQL;
    }

    function _getDatosQuery($stmt)
    {
        $arrayDatos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $resSQL = array(
            "error" => 0,
            "data" => $arrayDatos
        );
        return $resSQL;
    }

    function _elementosAfectados($stmt)
    {
        $numrows = $stmt->rowCount();
        return $numrows;
    }

    function _registosQuery($stmt)
    {
        $recodset = $stmt->fetchAll(PDO::FETCH_NUM);
        //$recodset = mysqli_fetch_array($resultquery, MYSQLI_NUM);
        return $recodset;
    }

    function _idRegistro()
    {
        $iddregistro = $this->_db->lastInsertId();
        return $iddregistro;
    }

    function _separa_Cadena($delimitador, $cadena)
    {
        if (strlen($cadena) > 0) {
            $count = count(explode($delimitador, $cadena));
            if ($count > 0) {
                $cadenatemp = explode($delimitador, $cadena);
                $cadena = $cadenatemp[1];
            } else {
                $cadenatemp = "";
            }
        } else {
            $cadenatemp = "";
        }
        return $cadena;
    }

    function _FechaMysql($fecha)
    {
        if (strlen($fecha) > 0) {
            $fecha_temp = explode("/", $fecha);
            $fecha_mysql = $fecha_temp[2] . "-" . $fecha_temp[1] . "-" . $fecha_temp[0];
        } else {
            $fecha_mysql = "";
        }
        return $fecha_mysql;
    }

    function _FechaNormal($fecha)
    {
        if (strlen($fecha) > 0) {
            $fecha_temp = explode("-", $fecha);
            $fecha_normal = $fecha_temp[2] . "/" . $fecha_temp[1] . "/" . $fecha_temp[0];
        } else {
            $fecha_normal = "";
        }
        return $fecha_normal;
    }

    function _redondeado($numero, $decimales)
    {
        $factor = pow(10, $decimales);
        return (round($numero * $factor) / $factor);
    }
}

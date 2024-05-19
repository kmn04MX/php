<?php
include_once("conexion_db.php");

class Catalogos
{

    var $nomTabla = "";

    function __construct($tabla)
    {
        $this->nomTabla = $tabla;
    }


    function inserta_Registro($array_campos)
    {
        $conect = new Conexion();
        $count = count($array_campos);
        if ($count > 0) {
            $ncampos = $count;
            $indice = 0;
            $sqlInsert = "INSERT INTO " . $this->nomTabla . " (";
            foreach ($array_campos as $campos) {
                $indice = $indice + 1;
                if ($indice == $ncampos) {
                    $sqlInsert .= $campos[0];
                } else {
                    $sqlInsert .= $campos[0] . ",";
                }
            }
            $sqlInsert .= ") VALUES(";
            $indice = 0;

            foreach ($array_campos as $valores) {
                $indice = $indice + 1;
                if ($indice == $ncampos) {
                    $separador = "";
                } else {
                    $separador = ",";
                }
                if ($valores[2] == 'S') {
                    $sqlInsert .= "'" . mb_convert_encoding($valores[1], 'UTF-8', 'ISO-8859-2') . "'" . $separador;
                } else {
                    $sqlInsert .= $valores[1] . $separador;
                }
            }
            $sqlInsert .= ")";
        } else {
            $sqlInsert = "";
        }

        if (strlen($sqlInsert) > 0) {
            $rs = $conect->_procesaQuery($sqlInsert);
            if ($rs['error'] == 0) {
                $idregistro = $conect->_idRegistro();
                $responce = array(
                    "error" => 0,
                    "mensaje" => "Registro guardado correctamente",
                    "idregistro" => $idregistro
                );
            } else {
                $responce = array(
                    "error" => 1,
                    "mensaje" => "Error verifique que los datos sean correctos ",
                    "idregistro" => 0,
                    "sql" => mb_convert_encoding($sqlInsert, 'UTF-8', 'ISO-8859-2')
                );
            }
        } else {
            $responce = array(
                "error" => 1,
                "mensaje" => "Error de estructura sql",
                "idregistro" => 0
            );
        }

        return $responce;
        $conect->_cierraBase();
    }

    function actualiza_Registro($array_campos, $array_camposid)
    {
        $conect = new Conexion();
        $responce = array();
        $count = count($array_campos);
        if ($count > 0) {
            $ncampos = $count;
            $indice = 0;
            $sqlUpdate = "UPDATE " . $this->nomTabla . " SET ";
            foreach ($array_campos as $valores) {
                $indice = $indice + 1;
                if ($indice == $ncampos) {
                    $separador = "";
                } else {
                    $separador = ",";
                }
                if ($valores[2] == 'S') {
                    $sqlUpdate .= $valores[0] . "='" . mb_convert_encoding($valores[1], 'UTF-8', 'ISO-8859-2') . "'" . $separador;
                } else {
                    $sqlUpdate .= $valores[0] . "=" . $valores[1] . $separador;
                }
            }
            $indice = 0;
            $ncamposid = count($array_camposid);
            $sqlUpdate .= " where ";

            foreach ($array_camposid as $camposid) {
                $indice = $indice + 1;
                if ($indice == $ncamposid) {
                    $condicion = "";
                } else {
                    $condicion = " and ";
                }
                if ($camposid[2] == 'S') {
                    $sqlUpdate .= $camposid[0] . "='" . mb_convert_encoding($camposid[1], 'UTF-8', 'ISO-8859-2') . "'" . $condicion;
                } else {
                    $sqlUpdate .= $camposid = $camposid[0] . "=" . $camposid[1] . $condicion;
                }
            }
        } else {
            $sqlUpdate = "";
        }

        if (strlen($sqlUpdate) > 0) {
            $rs = $conect->_procesaQuery($sqlUpdate);
            if ($rs['error'] == 0) {
                $responce = array(
                    "error" => 0,
                    "mensaje" => "Registro actualizado correctamente ",
                    "idregistro" => $array_camposid[0][1]
                );
            } else {
                $responce = array(
                    "error" => 1,
                    "mensaje" => "Error verifique que los datos sean correctos " . mb_convert_encoding($sqlUpdate, 'UTF-8', 'ISO-8859-2'),
                    "idregistro" => $array_camposid[0][1]
                );
            }
        } else {
            $responce = array(
                "error" => 1,
                "mensaje" => "Error de estructura sql",
                "idregistro" => 0
            );
        }

        return $responce;
        $conect->_cierraBase();
    }

    function borra_Registro($array_camposid, $array_tablasliga)
    {
        $conect = new Conexion();
        $responce = array();
        $count = count($array_tablasliga);
        $ncamposid = count($array_camposid);

        if ($count > 0) {
            // validar las tablas relacionadas
            $error = 0;
            foreach ($array_tablasliga as $tablas) {
                if ($error == 0) {
                    if ($tablas[3] == 'S') {
                        $sqlVal = "SELECT COUNT(*) FROM " . $tablas[0] . " where " . $tablas[1] . "='" . $tablas[2] . "'";
                    } else {
                        $sqlVal = "SELECT COUNT(*) FROM " . $tablas[0] . " where " . $tablas[1] . "=" . $tablas[2];
                    }
                    //$rsVal = $conect->_procesaQuery($sqlVal);
                    $val = $conect->_registosQuery($sqlVal);
                    if ($val[0] > 0) { //observar comportamiento
                        $error = 1;
                    }
                }
            }

            if ($error == 0) {
                if ($ncamposid > 0) {
                    // borrar el registro
                    $sqlDelete = "DELETE FROM " . $this->nomTabla . " where ";
                    $indice = 0;
                    foreach ($array_camposid as $camposid) {
                        $indice = $indice + 1;
                        if ($indice == $ncamposid) {
                            $condicion = "";
                        } else {
                            $condicion = " and ";
                        }
                        if ($camposid[2] == 'S') {
                            $sqlDelete .= $camposid[0] . "='" . $camposid[1] . "'" . $condicion;
                        } else {
                            $sqlDelete .= $camposid[0] . "=" . $camposid[1] . $condicion;
                        }
                    }

                    $rs = $conect->_procesaQuery($sqlDelete);
                    if ($rs['error'] == 0) {
                        $responce = array(
                            "error" => 0,
                            "mensaje" => "El registro se ha borrado correctamente ",
                            "idregistro" => 0
                        );
                    } else {
                        $responce = array(
                            "error" => 1,
                            "mensaje" => "Error verifique que los datos sean correctos ",
                            "idregistro" => 0
                        );
                    }
                } else {
                    $responce = array(
                        "error" => 1,
                        "mensaje" => "Error de estructura sql",
                        "idregistro" => 0
                    );
                }
            } else {
                $responce = array(
                    "error" => 1,
                    "mensaje" => "No es posible borrar porque está  relacionado con otros registros ",
                    "idregistro" => 0
                );
            }
        } else {
            if ($ncamposid > 0) {
                // borrar el registro de manera directa sin valisaciones de
                $sqlDelete = "DELETE FROM " . $this->nomTabla . " where ";
                $indice = 0;
                foreach ($array_camposid as $camposid) {
                    $indice = $indice + 1;
                    if ($indice == $ncamposid) {
                        $condicion = "";
                    } else {
                        $condicion = " and ";
                    }
                    if ($camposid[2] == 'S') {
                        $sqlDelete .= $camposid[0] . "='" . $camposid[1] . "'" . $condicion;
                    } else {
                        $sqlDelete .= $camposid[0] . "=" . $camposid[1] . $condicion;
                    }
                }

                $rs = $conect->_procesaQuery($sqlDelete);
                if ($rs['error'] == 0) {
                    $responce = array(
                        "error" => 0,
                        "mensaje" => "El registro se ha borrado correctamente",
                        "idregistro" => 0
                    );
                } else {
                    $responce = array(
                        "error" => 1,
                        "mensaje" => "Error verifique que los datos sean correctos " . $sqlDelete,
                        "idregistro" => 0
                    );
                }
            } else {
                $responce = array(
                    "error" => 1,
                    "mensaje" => "Error de estructura sql",
                    "idregistro" => 0
                );
            }
        }
        return $responce;
        $conect->_cierraBase();
    }

    function borra_RegistroTablas($array_tablas, $array_ligas)
    {
        $conect = new Conexion();
        $responce = array();
        $countTablas = count($array_tablas);
        $countLigas = count($array_ligas);

        if ($countTablas > 0) {
            // verificar que no existan registros en las tablas ligas para poder
            // hacer el borrado
            $error = 0;

            foreach ($array_ligas as $ligas) {
                if ($error == 0) {
                    if ($ligas[3] == 'S') {
                        $sqlVal = "SELECT COUNT(*) FROM " . $ligas[0] . " WHERE " . $ligas[1] . "='" . $ligas[2] . "'";
                    } else {
                        $sqlVal = "SELECT COUNT(*) FROM " . $ligas[0] . " WHERE " . $ligas[1] . "=" . $ligas[2];
                    }

                    //$rsVal = $conect->_procesaQuery($sqlVal);
                    $val = $conect->_registosQuery($sqlVal);
                    if ($val[0] > 0) {
                        $error = 1;
                    }
                }
            }

            if ($error == 0) {
                // borrar las tablas
                $error_borra = 0;

                foreach ($array_tablas as $tablas) {
                    if ($error_borra == 0) {
                        // Armar el sql para el borrado de los registro
                        $sqlDelete = "DELETE FROM " . $tablas[0] . " where ";

                        $indice = 0;
                        $ncampos = count($tablas['idcampos']);

                        foreach ($tablas['idcampos'] as $campos) {
                            $indice = ($indice + 1);
                            if ($indice == $ncampos) {
                                $condicion = "";
                            } else {
                                $condicion = " and ";
                            }

                            if ($campos[2] == 'S') {
                                $sqlDelete .= $campos[0] . "='" . $campos[1] . "' " . $condicion;
                            } else {
                                $sqlDelete .= $campos[0] . "=" . $campos[1] . " " . $condicion;
                            }
                        }

                        $rs = $conect->_procesaQuery($sqlDelete);
                        if ($rs['error'] != 0) {
                            $error_borra = 1;
                        }
                    }
                }

                if ($error_borra == 0) {
                    $responce = array(
                        "error" => 0,
                        "mensaje" => "Los registros se han borrado correctamente.",
                        "idregistro" => 0
                    );
                } else {
                    $responce = array(
                        "error" => 1,
                        "mensaje" => "Error al intentar borrar los registros verifique que los datos sean correctos " . $sqlDelete,
                        "idregistro" => 0
                    );
                }
            } else {
                $responce = array(
                    "error" => 1,
                    "mensaje" => "No es posible borrar porque está relacionado con otros registros ",
                    "idregistro" => 0
                );
            }
        } else {
            // borrar los registro de las tablas indicadas sin validacion
            $error_borra = 0;

            foreach ($array_tablas as $tablas) {
                if ($error_borra == 0) {
                    // Armar el sql para el borrado de los registro
                    $sqlDelete = "DELETE FROM " . $tablas[0] . " where ";

                    $indice = 0;
                    $ncampos = count($tablas['idcampos']);

                    foreach ($tablas['idcampos'] as $campos) {
                        $indice = ($indice + 1);
                        if ($indice == $ncampos) {
                            $condicion = "";
                        } else {
                            $condicion = " and ";
                        }

                        if ($campos[2] == 'S') {
                            $sqlDelete .= $campos[0] . "='" . $campos[1] . "' " . $condicion;
                        } else {
                            $sqlDelete .= $campos[0] . "=" . $campos[1] . " " . $condicion;
                        }
                    }

                    $rs = $conect->_procesaQuery($sqlDelete);
                    if ($rs['error'] != 0) {
                        $error_borra = 1;
                    }
                }
            }

            if ($error_borra == 0) {
                $responce = array(
                    "error" => 0,
                    "mensaje" => "Los registros se ha borrado correctamente",
                    "idregistro" => 0
                );
            } else {
                $responce = array(
                    "error" => 1,
                    "mensaje" => "Error al intentar borrar los registros verifique que los datos sean correctos",
                    "idregistro" => 0
                );
            }
        }

        return $responce;
        $conect->_cierraBase();
    }

    //corregir instrucciones
    function listado_Datos($pagina, $limit, $sqldatos, $array_encabezados, $paginado)
    {
        $conect = new Conexion();
        $responce = array();
        $datos = array();
        $nencabezados = count($array_encabezados);
        $arraydatos = array();

        if ($nencabezados > 0) {

            if ($pagina <= 0) {
                $pagina = 1;
            }

            if ($limit <= 0) {
                $limit = 10;
            }
            // obtener el numero de registros por pagina
            $rs = $conect->_procesaQuery($sqldatos);
            $countRows = $conect->_elementosAfectados($rs['rs']);
            if ($countRows > 0) {
                $total_pages = ceil($countRows / $limit);
            } else {
                $total_pages = 0;
            }

            if ($pagina > $total_pages)
                $pagina = $total_pages;
            $start = $limit * $pagina - $limit;
            if ($start < 0)
                $start = 0;

            // Obtener los datos
            if ($paginado == 'S') {
                $sqldatos .= " LIMIT " . $start . "," . $limit;
            }
            $rs = $conect->_procesaQuery($sqldatos);
            $countDatos = $conect->_elementosAfectados($rs['rs']);
            if ($countDatos > 0) {
                $nregistros = $countDatos;
                for ($i = 0; $i < $nregistros; $i++) {
                    $rows = $conect->_registosQuery($sqldatos);
                    for ($x = 0; $x < $nencabezados; $x++) { //verficar
                        $arraydatos[$array_encabezados[$x]] = mb_convert_encoding($rows[$x], 'UTF-8', 'ISO-8859-2');
                    }

                    $datos[] = $arraydatos;
                }

                $responce = array(
                    "error" => 0,
                    "nregistros" => $countDatos,
                    "paginaact" => $pagina,
                    "totpag" => $total_pages,
                    "mensaje" => "El query se ejecuto correctamente",
                    "lista" => $datos
                );
            } else {
                $responce = array(
                    "error" => 1,
                    "nregistros" => 0,
                    "paginaact" => $pagina,
                    "totpag" => 1,
                    "mensaje" => "No se encontraron resultados"
                );
            }
        } else {
            $responce = array(
                "error" => 1,
                "nregistros" => 0,
                "paginaact" => 1,
                "totpag" => 1,
                "mensaje" => "Error en los encabezados"
            );
        }

        return $responce;
        $conect->_cierraBase();
    }

    function datos_Tabla($sqldatos, $arra_campos)
    {
        $conect = new Conexion();
        $responce = array();
        $array_datos = array();

        if (strlen($sqldatos) > 0) {
            $ncampos = count($arra_campos);

            $rs = $conect->_procesaQuery($sqldatos);
            $count = $conect->_elementosAfectados($rs['rs']);
            if ($count > 0) {
                $rs = $conect->_procesaQuery($sqldatos);
                $rows = $conect->_registosQuery($rs['rs']);

                for ($i = 0; $i < $count; $i++) {
                    # code...
                    for ($x = 0; $x < $ncampos; $x++) {
                        $array_datos[$i][$arra_campos[$x]] = mb_convert_encoding($rows[$i][$x], 'UTF-8', 'ISO-8859-2');
                    }
                }

                $responce = array(
                    "error" => 0,
                    "mensaje" => "Datos consultados correctamente",
                    "datos" => $array_datos
                );
            } else {
                $responce = array(
                    "error" => 1,
                    "count" => $count,
                    "mensaje" => "Error verifique que los datos sean correctos"
                );
            }
        } else {
            $responce = array(
                "error" => 1,
                "mensaje" => "Error datos inválidos"
            );
        }

        return $responce;
        $conect->_cierraBase();
    }

    function Genera_Passwd($longitud, $sql, $campo_valido)
    {
        $conect = new Conexion();
        $clave = "";
        // Array con los valores a escojer
        $semilla = array();
        $semilla[] = array(
            '0',
            '1',
            '2',
            '3',
            '4',
            '5',
            '6',
            '7',
            '8',
            '9'
        );
        $semilla[] = array(
            'A',
            'E',
            'i',
            'U'
        );
        $semilla[] = array(
            'B',
            'C',
            'D',
            'F',
            'G',
            'H',
            'J',
            'K',
            'L',
            'M',
            'N',
            'P',
            'Q',
            'R',
            'S',
            'T',
            'V',
            'W',
            'X',
            'Y',
            'Z'
        );

        // creamos la clave con la longitud indicada
        for ($bucle = 0; $bucle < $longitud; $bucle++) {
            // seleccionamos un subarray al azar
            $valor = mt_rand(0, count($semilla) - 1);
            // selecccionamos una posicion al azar dentro del subarray
            $posicion = mt_rand(0, count($semilla[$valor]) - 1);
            // cojemos el caracter y lo agregamos a la clave
            $clave .= $semilla[$valor][$posicion];
        }
        $sql = $sql . " where " . $campo_valido . "='" . $clave . "' ";
        $rs = $conect->_procesaQuery($sql);

        $valida = $conect->_registosQuery($rs);
        if ($valida[0] > 0) {
            $conect->_cierraBase();

            $this->Genera_Passwd($longitud, $sql, $campo_valido);
        } else {
            return $clave;
        }
    }

    /**
     * Cambia el formato de fecha en español, el formato de la fecha que recibe es año-mes-dia
     *
     * @param string $fecha            
     * @return string
     */
    function formatoFechaCompleta($fecha)
    {
        $fechaCompleta = '';
        $mes = '';
        $fechaTemporal = explode('-', $fecha);
        switch ($fechaTemporal[1]) {
            case '01':
                $mes = 'Enero';
                break;
            case '02':
                $mes = 'Febrero';
                break;
            case '03':
                $mes = 'Marzo';
                break;
            case '04':
                $mes = 'Abril';
                break;
            case '05':
                $mes = 'Mayo';
                break;
            case '06':
                $mes = 'Junio';
                break;
            case '07':
                $mes = 'Julio';
                break;
            case '08':
                $mes = 'Agosto';
                break;
            case '09':
                $mes = 'Septiembre';
                break;
            case '10':
                $mes = 'Octubre';
                break;
            case '11':
                $mes = 'Noviembre';
                break;
            case '12':
                $mes = 'Diciembre';
                break;
        }

        $fechaCompleta = $fechaTemporal[2] . ' de ' . $mes . ' del ' . $fechaTemporal[0];
        return $fechaCompleta;
    }

    /**
     * Calcula los dias entre un rango de fechas, el formato de las fechas es año-mes-dia
     *
     * @param string $fechaInicio            
     * @param string $fechaFin            
     * @return number
     */
    function diasTranscurridos($fechaInicio, $fechaFin)
    {
        $dias = (strtotime($fechaInicio) - strtotime($fechaFin)) / 86400;
        $dias = abs($dias);
        $dias = floor($dias);
        return $dias;
    }


    /**
     * Regresa los meses del año
     *
     * @return array "id" y "nombre"
     */
    function mesesDelAnio()
    {
        $meses[1] = array('id' => 1, 'nombre' => 'Enero');
        $meses[2] = array('id' => 2, 'nombre' => 'Febrero');
        $meses[3] = array('id' => 3, 'nombre' => 'Marzo');
        $meses[4] = array('id' => 4, 'nombre' => 'Abril');
        $meses[5] = array('id' => 5, 'nombre' => 'Mayo');
        $meses[6] = array('id' => 6, 'nombre' => 'Junio');
        $meses[7] = array('id' => 7, 'nombre' => 'Julio');
        $meses[8] = array('id' => 8, 'nombre' => 'Agosto');
        $meses[9] = array('id' => 9, 'nombre' => 'Septiembre');
        $meses[10] = array('id' => 10, 'nombre' => 'Octubre');
        $meses[11] = array('id' => 11, 'nombre' => 'Noviembre');
        $meses[12] = array('id' => 12, 'nombre' => 'Diciembre');

        return $meses;
    }

    /**
     * Convertir un String a Hexadecimal
     * @param String $string
     * @return String
     */
    function strToHex($string)
    {
        $hex = '';
        for ($i = 0; $i < strlen($string); $i++) {
            $hex .= dechex(ord($string[$i]));
        }
        return $hex;
    }

    /**
     * Convertir Hexadecimal a String 
     * @param String $hex
     * @return String
     */
    function hexToStr($hex)
    {
        $string = '';
        for ($i = 0; $i < strlen($hex) - 1; $i += 2) {
            $string .= chr(hexdec($hex[$i] . $hex[$i + 1]));
        }
        return $string;
    }
}

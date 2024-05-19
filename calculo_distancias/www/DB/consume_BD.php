<?php
require_once('conexion_db.php');


class consume_bd extends Conexion
{
    public $nomTabla = "";
    public $contadorMeses = 0;

    function get_bancos_bd($tabla)
    {
        $all_bancos = array();
        $responses = array();

        $sqlBancos = "SELECT * FROM " . $tabla;
        $proccesSql = $this->_procesaQuery($sqlBancos);

        if ($proccesSql["error"] == 0) {

            $listadoBancos = $this->_getDatosQuery($proccesSql["rs"]);
            foreach ($listadoBancos["data"] as $key => $value) {
                # code...
                $all_bancos[] = array('nombre_bancos' => $value['nombre_banco']);
            }
            $responses = array(
                "error" => 0,
                "datos_bancos" => $all_bancos
            );
        } else {
            $responses = array(
                "error" => 1,
                "mensaje" => $proccesSql["mensaje"]
            );
        }
        return $responses;
    }

    //Bloque de obtencion de datos para historico
    public function getMesesByAnioTipoBase($listadoAnios, $listadoTipoBase)
    {
        $respuesta = array();
        try {
            //code...
            $consultaIn = $this->consultaIn($listadoAnios);
            //echo json_encode($consultaIn);

            $conexion = $this->_db;
            $sqlMesesbytipoAnioyTipoBase = "SELECT tipo_mes.id_tipo_mes, tipo_mes.descripcion_mes FROM tipo_mes WHERE id_tipo_mes IN (SELECT DISTINCT id_tipo_mes FROM datos_banamex WHERE id_tipo_año IN (" . $consultaIn["consultaInAnios"] . ") AND id_tipo_base IN (" . $consultaIn["consultaInTipoBase"] . "))";
            $arrayMesesbytipoAnioyTipoBase = $conexion->prepare($sqlMesesbytipoAnioyTipoBase);
            $arrayMesesbytipoAnioyTipoBase->setFetchMode(PDO::FETCH_ASSOC);
            if ($arrayMesesbytipoAnioyTipoBase->execute()) {
                # code...
                $arrayMesesDatos = $arrayMesesbytipoAnioyTipoBase->fetchAll();
                return $arrayMesesDatos;
            }
        } catch (PDOException $th) {
            //throw $th;
            $respuesta = array(
                "error" => 1,
                "mensaje" => "No se pudo generar la consulta " . $th
            );
            return $respuesta;
        }
    }

    public function getAniosVenta($listadoAniosVentas, $listadoTipoBase)
    {
        $respuesta = array();
        try {
            //code...
            $consultaIn = $this->consultaIn($listadoAniosVentas);
            $conexion = $this->_db;

            //$sqlAniosVenta = "SELECT av.descripcion, db.anio_venta , db.mes_venta, tpm.descripcion FROM (SELECT anio_venta, mes_venta FROM datos_banamex WHERE id_tipo_año = " . intval($value["anios"]) . " AND id_tipo_base = 1 AND id_tipo_mes = 1 ) as db INNER JOIN anios_ventas AS av ON av.id_anio_venta = db.anio_venta INNER JOIN tipo_mes AS tpm ON tpm.id_tipo_mes = db.mes_venta;";
            $sqlAniosVenta = "SELECT av.descripcion_anios_venta FROM anios_ventas as av WHERE av.id_anio_venta IN (SELECT DISTINCT anio_venta FROM datos_banamex WHERE id_tipo_año IN (" . $consultaIn["consultaInAnios"] . ") AND id_tipo_base IN (" . $consultaIn["consultaInTipoBase"] . "))";
            $arrayAniosVenta = $conexion->prepare($sqlAniosVenta);
            $arrayAniosVenta->setFetchMode(PDO::FETCH_ASSOC);
            if ($arrayAniosVenta->execute()) {
                # code...
                $arrayAniosVentaDatos = $arrayAniosVenta->fetchAll();
                $sqlDatosVenta = "SELECT av.descripcion_anios_venta as descripcion_anio_venta, ndb.anio_venta , ndb.mes_venta, tpm.descripcion_mes FROM ((SELECT db.anio_venta, db.mes_venta FROM datos_banamex db WHERE db.id_tipo_año IN (" . $consultaIn["consultaInAnios"] . ") AND db.id_tipo_base IN (" . $consultaIn["consultaInTipoBase"] . ")) as ndb LEFT JOIN anios_ventas as av ON av.id_anio_venta = ndb.anio_venta)LEFT JOIN tipo_mes as tpm ON tpm.id_tipo_mes = ndb.mes_venta;";
                $arraymesesVenta = $conexion->prepare($sqlDatosVenta);
                $arraymesesVenta->setFetchMode(PDO::FETCH_ASSOC);

                if ($arraymesesVenta->execute()) {
                    $arrayDatosVenta = $arraymesesVenta->fetchAll();
                    $listadoGrupoMesesVenta = $this->groupArray($arrayDatosVenta, "descripcion_anio_venta");

                    $contadorMesesVenta = 0;
                    foreach ($listadoGrupoMesesVenta as $key => $value) {
                        # code...
                        $pruebaDatos = $this->groupArray($value["groupData"], "mes_venta");
                        $contadorMesesVenta += count($pruebaDatos);
                    }
                    //echo json_encode($pruebaDatos);
                    $respuesta = array(
                        "error" => 0,
                        "listadoAniosVenta" => $arrayAniosVentaDatos,
                        "listadoDatosVenta" => $arrayDatosVenta,
                        "listadoMesesVenta" => $contadorMesesVenta,
                        "datosByAnioVenta" => $pruebaDatos
                    );
                    return $respuesta;
                }
            }
        } catch (PDOException $th) {
            //throw $th;
            $respuesta = array(
                "error" => 1,
                "mensaje" => "No se pudo generar la consulta " . $th
            );
            return $respuesta;
        }
    }

    public function getAniosyTipoBaseCobro($listadoAnios, $listadoTipoBase)
    {
        $respuesta = array();
        $all_anios = array();
        $all_tipoBase = array();
        try {
            //code...
            $con_PDO = $this->_db;
            foreach ($listadoAnios as $key => $anio) {
                # code...
                $sqlAniosFiltro = "SELECT id_tipo_año,descripcion_anio FROM tipo_año Where descripcion_anio = " . $anio;
                $descripcionAnio = $con_PDO->prepare($sqlAniosFiltro);
                $descripcionAnio->setFetchMode(PDO::FETCH_ASSOC);
                if ($descripcionAnio->execute()) {
                    while ($row = $descripcionAnio->fetch()) {
                        $all_anios[] = array(
                            "id_anio" => $row['id_tipo_año'],
                            'descripcion' => $row['descripcion_anio']
                        );
                    }
                }
            }

            foreach ($listadoTipoBase as $key => $tipoBase) {
                # code...
                $sqlTipoBase = "SELECT id_tipo_base,nombre_base FROM tipo_base Where nombre_base = '" . $tipoBase . "'";
                $tipoBase = $con_PDO->prepare($sqlTipoBase);
                $tipoBase->setFetchMode(PDO::FETCH_ASSOC);
                if ($tipoBase->execute()) {
                    while ($row = $tipoBase->fetch()) {
                        $all_tipoBase[] = array(
                            "id_tipoBase" => $row['id_tipo_base'],
                            'descripcion' => $row['nombre_base']
                        );
                    }
                }
            }
            $respuesta = array(
                "error" => 0,
                "anios" => $all_anios,
                "tipoBase" => $all_tipoBase
            );

            return $respuesta;
        } catch (PDOException $th) {
            //throw $th;
            $respuesta = array(
                "error" => 1,
                "mensaje" => "No se pudo generar la consulta " . $th
            );
            return $respuesta;
        }
    }

    public function getAniosyTipoBaseVenta($listadoAnios)
    {
        $respuesta = array();
        $all_anios = array();
        $all_tipoBase = array();
        try {
            //code...
            $con_PDO = $this->_db;
            foreach ($listadoAnios as $key => $anio) {
                # code...
                $sqlAniosFiltro = "SELECT descripcion FROM tipo_año Where id_tipo_año = " . intval($anio);
                $descripcionAnio = $con_PDO->prepare($sqlAniosFiltro);
                $descripcionAnio->setFetchMode(PDO::FETCH_ASSOC);
                if ($descripcionAnio->execute()) {
                    while ($row = $descripcionAnio->fetch()) {
                        $all_anios[] = array(
                            'descripcion' => $row['descripcion']
                        );
                    }
                }
            }
        } catch (PDOException $th) {
            //throw $th;
            $respuesta = array(
                "error" => 1,
                "mensaje" => "No se pudo generar la consulta " . $th
            );
            return $respuesta;
        }
    }

    public function getDatosCuerpoTabla($listadoAnios, $arregloTipoBase, $listadosMesesEncabezado)
    {
        try {
            //code...
            $consultaIn = $this->consultaIn($listadoAnios);
            $datosTabla = array();
            $con_PDO = $this->_db;
            $datosGorupMesCobro = array();
            $respuesta = array();
            # code...
            //obtener registros por año de venta
            $sqlDatosTabla = "SELECT db.registros_cobrados,db.importe_cobrado,db.registros_comisionables,db.comision_neta, db.fondo_comunicacion, db.id_tipo_mes, db.mes_venta, db.id_tipo_año From datos_banamex as db WHERE db.id_tipo_año IN (" . $consultaIn["consultaInAnios"] . ") AND db.id_tipo_base IN (" . $consultaIn["consultaInTipoBase"] . ")";
            $descripcionAnio = $con_PDO->prepare($sqlDatosTabla);
            $descripcionAnio->setFetchMode(PDO::FETCH_ASSOC);
            if ($descripcionAnio->execute()) {
                $datosTabla = $descripcionAnio->fetchAll();
                $datosPrueba = $this->groupArray($datosTabla, "id_tipo_año");
                foreach ($datosPrueba as $key => $value) {
                    # code...
                    $datosGorupMesCobro = $this->groupArray($value["groupData"], "id_tipo_mes");
                    array_push($respuesta, $datosGorupMesCobro);
                }
                return $respuesta;
            }
        } catch (PDOException $th) {
            //throw $th;
            $respuesta = array(
                "error" => 1,
                "mensaje" => "No se pudo generar la consulta " . $th
            );
            return $respuesta;
        }
    }

    function groupArray($array, $groupkey)
    {
        if (count($array) > 0) {
            $keys = array_keys($array[0]);
            $removekey = array_search($groupkey, $keys);
            if ($removekey === false)
                return array("Clave \"$groupkey\" no existe");
            else
                unset($keys[$removekey]);
            $groupcriteria = array();
            $return = array();
            foreach ($array as $value) {
                $item = null;
                foreach ($keys as $key) {
                    $item[$key] = $value[$key];
                }
                $busca = array_search($value[$groupkey], $groupcriteria);
                if ($busca === false) {
                    $groupcriteria[] = $value[$groupkey];
                    $return[] = array($groupkey => $value[$groupkey], 'groupData' => array());
                    $busca = count($return) - 1;
                }
                $return[$busca]['groupData'][] = $item;
            }
            return $return;
        } else
            return array();
    }

    public function consultaIn($listadoAnios)
    {
        $respuesta = array();
        $consultaInAnios = "";
        $consultaInTipoBase = "";
        $totalAnios = count($listadoAnios["anios"]);
        $totalBases = count($listadoAnios["tipoBase"]);
        if ($totalAnios > 0) {
            # code...
            foreach ($listadoAnios["anios"] as $key => $value) {
                # code...
                ($key == ($totalAnios - 1)) ?  $consultaInAnios .= $value["id_anio"] : $consultaInAnios .= $value["id_anio"] . ",";
            }
        } else {
            # code...
            $consultaInAnios .= $listadoAnios["anios"][0]["id_anio"];
        }

        if ($totalBases > 0) {
            # code...
            foreach ($listadoAnios["tipoBase"] as $key => $value) {
                # code...
                //veririfcar id de las bases
                ($key == ($totalBases - 1)) ?  $consultaInTipoBase .= $value["id_tipoBase"] : $consultaInTipoBase .= $value["id_tipoBase"] . ",";
            }
        } else {
            # code...
            $consultaInTipoBase .= $listadoAnios["tipoBase"][0]["id_tipoBase"];
        }

        $respuesta = array(
            "consultaInAnios" => $consultaInAnios,
            "consultaInTipoBase" => $consultaInTipoBase
        );

        return $respuesta;
    }

    //Fin Bloque

    function inserta_Registro($array_campos, $conect)
    {

        switch ($conect) {
            case 'carterah':
                $conect = $this->conect_carterah();
                break;
            case 'gadgets':
                $conect = $this->conect_cp_gadgets();
                break;

            default:
                $conect = $this->_db;
                break;
        }

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

                $sqlInsert .= $valores[1] . $separador;
            }

            $sqlInsert .= ")";
        } else {
            $sqlInsert = "Error en la estructura SQL";
        }
        $indice = 0;

        $registros = $conect->prepare($sqlInsert);
        foreach ($array_campos as $valores) {
            $indice = $indice + 1;

            $registros->bindParam($indice, $valores[2]);
        }

        if ($registros->execute()) {

            $responses = array(
                "error" => 0,
                "mensaje" => "Registro guardado correctamente"
            );
        } else {
            $responses = array(
                "error" => 1,
                "mensaje" => "Error verifique que los datos sean correctos ",
            );
        }


        return $responses;
        $conect = null;
    }

    function actualiza_Registro($array_campos, $array_camposid, $nomTabla, $datos)
    {
        $conect = $this->_db;

        $responce = "";
        $count = count($array_campos);
        if ($count > 0) {
            $ncampos = $count;
            $indice = 0;
            $sqlUpdate = "UPDATE " . $nomTabla . " SET ";
            foreach ($array_campos as $valores) {
                $indice = $indice + 1;
                if ($indice == $ncampos) {
                    $separador = "";
                } else {
                    $separador = ",";
                }

                $sqlUpdate .= $valores[0] . "=" . $valores[1] . $separador;
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

                $sqlUpdate .= $camposid = $camposid[0] . "=" . $camposid[1] . $condicion;
            }
        } else {
            $sqlUpdate = "Error en la estrucutra del SQLupdate";
        }

        $registros = $conect->prepare($sqlUpdate);


        if ($registros->execute($datos)) {

            $responses = array(
                "error" => 0,
                "mensaje" => "Datos actualizados correctamente"
            );
        } else {
            $responses = array(
                "error" => 1,
                "mensaje" => "Error No se actualizaron los datos",
            );
        }


        return $responses;

        $conect = null;
    }

    function borra_Registro($array_camposid, $nomTabla, $datos)
    {
        $conect = $this->_db;
        $responce = "";
        $ncamposid = count($array_camposid);

        if ($ncamposid > 0) {
            // borrar el registro
            $sqlDelete = "DELETE FROM " . $nomTabla . " where ";
            $indice = 0;
            foreach ($array_camposid as $camposid) {
                $indice = $indice + 1;
                if ($indice == $ncamposid) {
                    $condicion = "";
                } else {
                    $condicion = " and ";
                }

                $sqlDelete .= $camposid[0] . "=" . $camposid[1] . $condicion;
            }

            $registros = $conect->prepare($sqlDelete);


            if ($registros->execute($datos)) {

                $responses = array(
                    "error" => 0,
                    "mensaje" => "Datos eliminados correctamente"
                );
            } else {
                $responses = array(
                    "error" => 1,
                    "mensaje" => "Error No se actualizaron los datos",
                );
            }
        } else {
            $responses = array(
                "error" => 1,
                "mensaje" => "Error de estructura sql",
                "idregistro" => 0
            );
        }


        return $responses;
        $conect = null;
    }
}

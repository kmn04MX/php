<?php
header("Access-Control-Allow-Origin: *");
header('Content-type: text/html; charset=utf-8');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Cache-Control: max-age=0');

date_default_timezone_set('America/Mazatlan');
require_once "../../Models/Api/apiGoogle.php";
require '../../vendor/autoload.php';

use \PhpOffice\PhpSpreadsheet\IOFactory;

\PhpOffice\PhpSpreadsheet\Cell\Cell::setValueBinder(new \PhpOffice\PhpSpreadsheet\Cell\AdvancedValueBinder());

$google = new apiGoogle();
$responce = array();
$arrayDatos = array();
$resAPI = array();

$origen = array();
$destino = array();

set_time_limit(0);
//leer fichero de excel
if ($_FILES["file"]["name"] != '') {

    $allowedFileType = ['application/vnd.ms-excel', 'text/xls', 'text/xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

    if (in_array($_FILES["file"]["type"], $allowedFileType)) {
        # code...
        try {
            //code...
            $pathFile = '../../App/Data/' . $_FILES['file']['name'];
            move_uploaded_file($_FILES['file']['tmp_name'], $pathFile);

            $Formats = [
                \PhpOffice\PhpSpreadsheet\IOFactory::READER_XLS,
                \PhpOffice\PhpSpreadsheet\IOFactory::READER_XLSX,
            ];

            $inputFileType = IOFactory::identify($pathFile, $Formats);
            $objReader = IOFactory::createReader($inputFileType);
            $objReader->setReadDataOnly(true);

            $objPHPLee = $objReader->load($pathFile);
            $sheet = $objPHPLee->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();

            for ($row = 2; $row <= $highestRow; $row++) {
                $arrayDatos[] = array(
                    "CDASISTE" => trim($sheet->getCell("A" . $row)->getValue()),
                    "RGPRESTA" => trim($sheet->getCell("B" . $row)->getValue()),
                    "LATITUD_ORIGEN" => trim($sheet->getCell("C" . $row)->getValue()),
                    "LONGITUD_ORIGEN" => trim($sheet->getCell("D" . $row)->getValue()),
                    "TXUBICACIONO" => trim($sheet->getCell("E" . $row)->getValue()),
                    "LATITUD_DESTINO" => trim($sheet->getCell("F" . $row)->getValue()),
                    "LONGITUD_DESTINO" => trim($sheet->getCell("G" . $row)->getValue()),
                    "TXUBICACIOND" => trim($sheet->getCell("H" . $row)->getValue()),
                    "Distancia_1" => trim($sheet->getCell("I" . $row)->getValue()),
                    "Distancia_2" => trim($sheet->getCell("J" . $row)->getValue()),
                    "Distancia_3" => trim($sheet->getCell("K" . $row)->getValue())
                );
            }
            $nomexcel = "";
            if (count($arrayDatos) > 0) {

                foreach ($arrayDatos as $item => $val) {
                    //Se calcula la distancia entre el origen y destino
                    $latdOrigen = trim($arrayDatos[$item]['LATITUD_ORIGEN']);
                    $longOrigen = trim($arrayDatos[$item]['LONGITUD_ORIGEN']);

                    $latDestino = trim($arrayDatos[$item]['LATITUD_DESTINO']);
                    $longDestino = trim($arrayDatos[$item]['LONGITUD_DESTINO']);

                    $origen = array();
                    $destino = array();

                    if (strlen($latdOrigen) > 0 && strlen($longOrigen) > 0) {
                        $origen = array(
                            "latitud" => $latdOrigen,
                            "longitud" => $longOrigen
                        );

                        $destino = array(
                            "latitud" => $latDestino,
                            "longitud" => $longDestino
                        );
                        //Consultar Api
                        $resdistancia = $google->calculaDistancia($origen, $destino);

                        if ($resdistancia["status"] == 'OK') {
                            foreach ($resdistancia['rows'] as $value) {
                                $rows = $value;
                            }

                            $distancia = "";
                            $duracion = "";
                            $trafico = "";

                            $distancia = $rows['elements'][0]['distance']['text'];
                            $tiempo = $rows['elements'][0]['duration']['text'];
                            $trafico = $rows['elements'][0]['duration_in_traffic']['text'];
                        } else {
                            $distancia = "0 km";
                            $tiempo = "0 min";
                            $trafico = "0 min";
                        }
                    } else {
                        $distancia = "0 km";
                        $tiempo = "0 min";
                        $trafico = "0 min";
                    }

                    $resAPI[] = array(
                        "CDASISTE" => trim($arrayDatos[$item]['CDASISTE']),
                        "RGPRESTA" => trim($arrayDatos[$item]['RGPRESTA']),
                        "LATITUD_ORIGEN" => trim($arrayDatos[$item]['LATITUD_ORIGEN']),
                        "LONGITUD_ORIGEN" => trim($arrayDatos[$item]['LONGITUD_ORIGEN']),
                        "TXUBICACIONO" => trim($arrayDatos[$item]['TXUBICACIONO']),
                        "LATITUD_DESTINO" => trim($arrayDatos[$item]['LATITUD_DESTINO']),
                        "LONGITUD_DESTINO" => trim($arrayDatos[$item]['LONGITUD_DESTINO']),
                        "TXUBICACIOND" => trim($arrayDatos[$item]['TXUBICACIOND']),
                        "Distancia_1" => trim($arrayDatos[$item]['Distancia_1']),
                        "Distancia_2" => trim($arrayDatos[$item]['Distancia_2']),
                        "Distancia_3" => trim($arrayDatos[$item]['Distancia_3']),
                        "distanciaC" => $distancia,
                        "tiempo" => $tiempo,
                        "trafico" => $trafico
                    );
                }
                //Proceso de Exportacion del archivo
                $nomexcel = "acuse" . date("d-m-Y");
                if (count($resAPI) > 0) {
                    //leer el arrego generado con las coordenadas
                    $indice = 0;
                    $celda = 2;

                    $inputFileName = '../../App/Data/generado.Xls';

                    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);

                    $spreadsheet->setActiveSheetIndex(0); //se indica que hoja de calculo se estara usando
                    $objPHPExcel = $spreadsheet->getActiveSheet(); //para utilizar la hoja 

                    foreach ($resAPI as $item => $val) {
                        $objPHPExcel->SetCellValue('A' . $celda, mb_convert_encoding($resAPI[$item]['CDASISTE'], 'UTF-8', 'ISO-8859-2'));
                        $objPHPExcel->SetCellValue('B' . $celda, mb_convert_encoding($resAPI[$item]['RGPRESTA'], 'UTF-8', 'ISO-8859-2'));
                        $objPHPExcel->SetCellValue('C' . $celda, mb_convert_encoding($resAPI[$item]['LATITUD_ORIGEN'], 'UTF-8', 'ISO-8859-2'));
                        $objPHPExcel->SetCellValue('D' . $celda, mb_convert_encoding($resAPI[$item]['LONGITUD_ORIGEN'], 'UTF-8', 'ISO-8859-2'));
                        $objPHPExcel->SetCellValue('E' . $celda, mb_convert_encoding($resAPI[$item]['TXUBICACIONO'], 'UTF-8', 'ISO-8859-2'));
                        $objPHPExcel->SetCellValue('F' . $celda, mb_convert_encoding($resAPI[$item]['LATITUD_DESTINO'], 'UTF-8', 'ISO-8859-2'));
                        $objPHPExcel->SetCellValue('G' . $celda, mb_convert_encoding($resAPI[$item]['LONGITUD_DESTINO'], 'UTF-8', 'ISO-8859-2'));
                        $objPHPExcel->SetCellValue('H' . $celda, mb_convert_encoding($resAPI[$item]['TXUBICACIOND'], 'UTF-8', 'ISO-8859-2'));
                        $objPHPExcel->SetCellValue('I' . $celda, "'".$resAPI[$item]['distanciaC']);
                        $objPHPExcel->SetCellValue('J' . $celda, "'".$resAPI[$item]['tiempo']);
                        $objPHPExcel->SetCellValue('K' . $celda, "'".$resAPI[$item]['trafico']);

                        $celda += 1;
                    }

                    $objWriter = IOFactory::createWriter($spreadsheet, 'Xls');
                    //$objWriter->save('../../App/Data/' . $nomexcel . '.xls');
                    $objWriter->save('php://output');
                }
                $responce = array("error" => 0, "mensaje" => $resdistancia["status"]);
            }
            
            $responce = $resAPI;


        } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
            die('Error loading file: ' . $e->getMessage());
        }
    } else {
        # code...
        $responce = array("error" => 1, "mensaje" => "El archivo cargado no corresponde al formato XLS/XLSX");
    }
} else {
    $responce = array("error" => 1, "mensaje" => "No se ha cargado ningun archivo");
}


echo json_encode($responce);

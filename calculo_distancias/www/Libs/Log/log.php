<?php

class Log
{

    private $fileLog;

    function __construct($path)
    {
        $this->fileLog = fopen($path, "a");
    }

    function escribirLog($tipo, $mensaje)
    {
        $date = new DateTime();
        fputs($this->fileLog, "[" . $tipo . "][" . $date->format('d/m/Y H:i:s') . "]:" . $mensaje . "\n");
    }

    function closeFile()
    {
        fclose($this->fileLog);
    }
}

<?php
//Sistema de ruteo muy sencillo

//Isset sirve para comprobar si una variable está definida
if(isset($_GET['view'])){
    $view = $_GET['view'];
    require 'views/'.$view.'.php';
}else{
    require 'views/home.php';
}
?>
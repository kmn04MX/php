<?php
    include("template/cabecera.php");
    include("administrador/confg/database.php");

    $sentencia = $conexion->prepare("SELECT * FROM libros");
    $sentencia->execute();
    $listaLibros = $sentencia->fetchAll(PDO::FETCH_ASSOC);

?>

<?php
    foreach($listaLibros as $libro){   
?>
<div class="col-md-3">
    <div class="card">
        <!-- <img class="card-img-top" src="https://www.w3schools.com/bootstrap4/img_avatar1.png" alt=""> -->
        <img class="card-img-top" src="./img/<?php echo $libro['imagen'];?>" alt="">
        <div class="card-body">
            <h4 class="card-title"><?php echo $libro['nombre']?></h4>
            <a name="" id="" class="btn btn-primary" href="#" role="button">ver más</a>
        </div>
    </div>
    <br/>
</div>
<?php
    }
?>

<?php
    include("template/pie.php");
?>

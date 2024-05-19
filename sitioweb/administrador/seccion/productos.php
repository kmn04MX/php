<?php
include('../template/cabecera.php');

$txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : "";
$txtNombre = (isset($_POST['txtNombre'])) ? $_POST['txtNombre'] : "";
$txtImagen = (isset($_FILES['txtImagen']['name'])) ? $_FILES['txtImagen'][ 'name'] : "";
$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";

include('../confg/database.php');

switch ($accion) {
    case 'Agregar':
        $sentencia= $conexion->prepare("INSERT INTO libros (id, nombre, imagen) VALUES (NULL, :nombre, :imagen);");
        $sentencia->bindParam(':nombre', $txtNombre);
        
        $fecha = new DateTime();
        $nombreArchivo = ($txtImagen != "") ? $fecha->getTimestamp() . "_" . $_FILES["txtImagen"]["name"] : "imagen.jpg";
        $tmpImagen = $_FILES["txtImagen"]["tmp_name"];
        if($tmpImagen != ""){
            move_uploaded_file($tmpImagen, "../../img/" . $nombreArchivo);
        }

        $sentencia->bindParam(':imagen', $nombreArchivo);
        $sentencia->execute();
        header('Location:productos.php');
        exit();
        
        break;
    case 'Modificar':
        $sentencia= $conexion->prepare("UPDATE libros SET nombre=:nombre WHERE id=:id");
        $sentencia->bindParam(':id', $txtID);
        $sentencia->bindParam(':nombre', $txtNombre);
        $sentencia->execute();
        if($txtImagen != ""){


            $fecha = new DateTime();
            $nombreArchivo = ($txtImagen != "") ? $fecha->getTimestamp() . "_" . $_FILES["txtImagen"]["name"] : "imagen.jpg";
            $tmpImagen = $_FILES["txtImagen"]["tmp_name"];  
            move_uploaded_file($tmpImagen, "../../img/" . $nombreArchivo);

            $sentencia= $conexion->prepare("SELECT * FROM libros WHERE id=:id");
            $sentencia->bindParam(':id', $txtID);
            $sentencia->execute();
            $libro = $sentencia->fetch(PDO::FETCH_LAZY);

            if(isset($libro['imagen']) && ($libro['imagen'] != "imagen.jpg")){
                if(file_exists("../../img/" . $libro['imagen'])){
                    unlink("../../img/" . $libro['imagen']);
                }
            }

            $sentencia= $conexion->prepare("UPDATE libros SET imagen=:imagen WHERE id=:id");
            $sentencia->bindParam(':id', $txtID);
            $sentencia->bindParam(':imagen', $nombreArchivo);
            $sentencia->execute();
        }


        break;
    case 'Cancelar':
        header('Location:productos.php');
        break;
    case 'Seleccionar':
        $sentencia= $conexion->prepare("SELECT * FROM libros WHERE id=:id");
        $sentencia->bindParam(':id', $txtID);
        $sentencia->execute();
        $libro = $sentencia->fetch(PDO::FETCH_LAZY);
        $txtNombre = $libro['nombre'];
        $txtImagen = $libro['imagen'];
        $txtID = $libro['id'];
        break;
    case 'Borrar':
        $sentencia= $conexion->prepare("SELECT * FROM libros WHERE id=:id");
        $sentencia->bindParam(':id', $txtID);
        $sentencia->execute();
        $libro = $sentencia->fetch(PDO::FETCH_LAZY);

        if(isset($libro['imagen']) && ($libro['imagen'] != "imagen.jpg")){
            if(file_exists("../../img/" . $libro['imagen'])){
                unlink("../../img/" . $libro['imagen']);
            }
        }

        $sentencia= $conexion->prepare("DELETE FROM libros WHERE id=:id");
        $sentencia->bindParam(':id', $txtID);
        $sentencia->execute();

        break;
    
}

$sentencia = $conexion->prepare("SELECT * FROM libros");
$sentencia->execute();
$listaLibros = $sentencia->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="col-md-5">
    <div class="card">
        <div class="card-header">
            Datos del formulario
            
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="txtID">ID</label>
                    <input type="text" required readonly class="form-control" name="txtID" id="txtID" placeholder="ID" value="<?php echo $txtID ?>">
                </div>
                <div class="form-group">
                    <label for="txtNombre">Nombre</label>
                    <input type="text" required class="form-control" name="txtNombre" id="txtNombre" placeholder="Nombre" value="<?php echo $txtNombre ?>">
                </div>
                <div class="form-group">
                    <label for="txtImagen">Imagen</label>
                    <!-- <?php echo $txtImagen ?> -->
                    <?php
                        if($txtImagen != ""){
                    ?>

                    <img class="img-thumbnail" src="../../img/<?php echo $txtImagen?>" alt="" width="100">

                    <?php
                        }
                    ?>
                    <input type="file" class="form-control" name="txtImagen" id="txtImagen" placeholder="Nombre" value="<?php echo $txtImagen?>">
                </div>
                <div class="btn-group" role="group" aria-label="">
                    <button type="submit" name="accion" <?php echo ($accion=="Seleccionar")? "disabled":"";?> value="Agregar" class="btn btn-success">Agregar</button>
                    <button type="submit" name="accion" <?php echo ($accion!="Seleccionar")? "disabled":"";?> value="Modificar" class="btn btn-warning">Modificar</button>
                    <button type="submit" name="accion" <?php echo ($accion!="Seleccionar")? "disabled":"";?> value="Cancelar" class="btn btn-info">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="col-md-7">
    Tabla de libros
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($listaLibros as $libro) {?>
            <tr>
                <td><?php echo $libro['id']?></td>
                <td><?php echo $libro['nombre']?></td>
                <td>
                    <!-- <img src="https://via.placeholder.com/100x100" alt=""> -->
                    <img class="img-thumbnail" src="../../img/<?php echo $libro['imagen']?>" alt="" width="100">
                    <!-- <?php echo $libro['imagen']?>  -->
                </td>
                <td>
                    <form method="post">
                        <div class="btn-group" role="group" aria-label="">
                            <input type="hidden" name="txtID" id="txtID" value="<?php echo $libro['id']?>">
                            <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary"> &nbsp;
                            <input type="submit" name="accion" value="Borrar" class="btn btn-danger">
                        </div>
                    </form>
                </td>
            </tr>
            <?php } ?>
            
        </tbody>
    </table>
</div>


<?php 
include ('../template/pie.php');
?>
<?php

try{
    $conn = new PDO('mysql:host=localhost;dbname=todolist', 'root', '5511');
}catch (PDOException $e){
    echo "Error: " . $e->getMessage();
}  

$sql = "SELECT * FROM tareas";
$resultados= $conn->query($sql);
/* print_r($resultados); */
/* $resultados = json_decode($resultados);
echo $resultados; */

/* foreach ($resultados as $tarea) {
    echo "<li class='list-group-item'>";
    echo "<input class='form-check-input' type='checkbox' value='' id='' checked />" . $tarea['tarea'];
    echo "</li>";
} */

/* if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $completado = (isset($_POST['completado']))? 1 : 0;
    $sql = "UPDATE tareas SET completado=? WHERE id=?";
    $sentencia= $conn->prepare($sql);
    $sentencia->execute([$completado, $id]);
} */

if (isset($_POST['id'])) {
    // Obtener el ID de la tarea y el estado completado del formulario POST
    $id = $_POST['id'];
    $completado = isset($_POST['completado']) ? 1 : 0;

    // Preparar la consulta SQL
    $sql = "UPDATE tareas SET completado=? WHERE id=?";
    $sentencia = $conn->prepare($sql);

    // Ejecutar la consulta con los valores vinculados
    $sentencia->execute([$completado, $id]);

    header('Location: index.php');
}


if (isset($_POST['agregar_tarea'])) {
    $tarea = $_POST['tarea'];
    $sql = 'INSERT INTO tareas (tarea, completado) VALUES (?, 0)';
    $sentencia= $conn->prepare($sql);
    $sentencia->execute([$tarea]);

    header('Location: index.php');
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = 'DELETE FROM tareas WHERE id=?';
    $sentencia= $conn->prepare($sql);
    $sentencia->execute([$id]);

    header('Location: index.php');
}
?>
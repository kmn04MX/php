<?php
use Vidamrr\Notas\models\Note;

//Validar con el post
if(count($_POST) > 0){
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $content = isset($_POST['content']) ? $_POST['content'] : '';
    $uuid = $_POST['id'];
    $note = Note::get($uuid);
    $note -> setTitle($title);
    $note -> setContent($content);
    $note -> update();
}

if(isset($_GET['id'])){
    $note = Note::get($_GET['id']);
    
}else{
    echo 'No se encontro la nota';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/views/resorces/main.css">
    <title>Document</title>
    
</head>
<body>
    <?php require 'resorces/navbar.php'?>
    <h1>Esta es una viewsss</h1>
    <form action="?view=view&id=<?php echo $note -> getUuid()?>" method="POST">
        <input type="text" name="title" placeholder="Title . . ." value="<?php echo $note->getTitle()?>">
        <input type="hidden" name="id" value="<?php echo $note->getUuid()?>">
        <textarea name="content" placeholder="Content . . ." id="" cols="30" rows="10"><?php echo $note->getContent()?></textarea>
        <input type="submit" value="Update note">
    </form>
</body>
</html>
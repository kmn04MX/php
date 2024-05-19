<?php
use Vidamrr\Notas\models\Note;
if(count($_POST) > 0){
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $content = isset($_POST['content']) ? $_POST['content'] : '';
    $note = new Note($title, $content);
    $note->save();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/views/resorces/main.css">
    <title>Create new note</title>
    
</head>
<body>
    <?php require 'resorces/navbar.php'?>
    <h1>Create new note</h1>
    <form action="?view=create" method="POST">
        <input type="text" name="title" placeholder="Title . . .">
        <textarea name="content" placeholder="Content . . ." id="" cols="30" rows="10"></textarea>
        <input type="submit" value="Create note">
    </form>
</body>
</html>
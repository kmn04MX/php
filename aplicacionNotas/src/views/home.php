<?php
use Vidamrr\Notas\models\Note;

// Obtener todas las notas
$notes = Note::getAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="src/views/resorces/main.css">
</head>
<body>
    <?php require 'resorces/navbar.php'?>
    <h1>HOME</h1>
    <div class="note-container">
        <?php
            // Verificar si hay notas
            if(count($notes) == 0) {
                echo '<p>No hay notas</p>';
            }

            // Iterar sobre cada nota
            foreach ($notes as $note) {
        ?>
        <a href="?view=view&id=<?php echo $note->getUuid()?>">
            <div class="note-preview">
                <div class="title"><?php echo $note->getTitle(); ?></div>
            </div>
        </a>
        <?php
            }
        ?>
    </div>
</body>
</html>

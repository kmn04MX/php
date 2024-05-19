<?php
namespace Vidamrr\Notas\models;

use Vidamrr\Notas\lib\DataBase;
use PDO;

class Note extends DataBase {
    private string $uuid;
    private string $title;
    private string $content;

    public function __construct(string $title, string $content) {
        parent::__construct();
        $this->uuid = uniqid();
        $this->title = $title;
        $this->content = $content;
    }

    public function save() {
        $query = $this ->connect()->prepare('INSERT INTO notes (uuid, title, content, updated) VALUES (:uuid, :title, :content, NOW())');
        $query->execute([
            'title' => $this->title,
            'uuid' => $this->uuid,
            'content' => $this->content
        ]);
    }

    public function update() {
        $query = $this ->connect()->prepare('UPDATE notes SET title = :title, content = :content, updated = NOW() WHERE uuid = :uuid');
        $query->execute([
            'title' => $this->title,
            'uuid' => $this->uuid,
            'content' => $this->content
        ]);
    }

    //Va a llamar a la base de datos y va a traer todas las notas en cualquier lugar
    public static function get ($uuid) {
        $db = new DataBase();
        $query = $db->connect()->prepare('SELECT * FROM notes WHERE uuid = :uuid');
        $query->execute([
            'uuid' => $uuid
        ]);

        $note = Note::createFromArray($query->fetch(PDO::FETCH_ASSOC));
        return $note;
    }

    public static function getAll() {
        $db = new DataBase();
        $query = $db->connect()->query('SELECT * FROM notes');
        $notes = [];
        foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $note) {
            $notes[] = Note::createFromArray($note);
        }
        return $notes;
    }

    public static function createFromArray($arr):Note{
        $note = new Note($arr['title'], $arr['content']);
        $note->setUuid($arr['uuid']);
        return $note;
    }

    //Crear métodos getter & seeters de uuid, title y content
    public function getUuid(){
        return $this->uuid;
    }

    public function setUuid($uuid){
        $this->uuid = $uuid;
    }

    public function getTitle(){
        return $this->title;
    }

    public function setTitle($title){
        $this->title = $title;
    }

    public function getContent(){
        return $this->content;
    }

    public function setContent($content){
        $this->content = $content;
    }
}
?>

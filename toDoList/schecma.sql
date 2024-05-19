CREATE DATABASE todolist;

use todolist;


CREATE TABLE tareas(
    id int NOT NULL auto_increment,
    tarea VARCHAR(255) NOT NULL,
    completado TINYINT(1),
    PRIMARY KEY (id)
);


drop DATABASE todolist;
```
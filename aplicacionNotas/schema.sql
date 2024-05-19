CREATE DATABASE aplicacionNotas;

use aplicacionNotas;


CREATE TABLE notes(
    id int NOT NULL auto_increment,
    uuid varchar(255) NOT NULL UNIQUE,
    title VARCHAR(255) NOT NULL,
    content text NOT NULL,
    updated date NOT NULL,
    PRIMARY KEY (id)
);

select * FROM notes
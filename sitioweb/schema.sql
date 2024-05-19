CREATE DATABASE sitio;
DROP DATABASE sitio;

use sitio;


CREATE TABLE libros(
    id int NOT NULL auto_increment,
    nombre varchar(255) NOT NULL,
    imagen VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);

select * FROM libros;

INSERT INTO libros (id, nombre, imagen) VALUES (NULL, 'Este es el primer pdf que se inserta', 'pdf1.pdf');
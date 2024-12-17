CREATE DATABASE notes ; 

CREATE TABLE users (
  user_id INT AUTO_INCREMENT not null PRIMARY KEY,
  name varchar(100) not null,
  last_name varchar(100) not null,
  email varchar(255) unique, 
  password varchar(100) not null,
);

-- añadir un campo extra a la DB
ALTER TABLE users ADD COLUMN password varchar(100) ; 
ALTER TABLE users ADD COLUMN bio TEXT;
ALTER TABLE users ADD COLUMN avatar varchar(200) ;


CREATE TABLE categories (
  category_id INT AUTO_INCREMENT not null PRIMARY KEY,
  name varchar(120) not null

)

CREATE TABLE notes (
  note_id INT AUTO_INCREMENT not null PRIMARY KEY,
  title varchar(150) not null ,
  description TEXT, 
  date_at DATE default CURDATE(),
  completed BOOLEAN,
  category INT ,
  user INT ,
  FOREIGN KEY(category) REFERENCES categories( category_id),
  FOREIGN KEY(user) REFERENCES users(user_id)

); 



-- insertar usuario
INSERT INTO users (name, lastname, email, password) VALUES ("CARLOS", "ORTIZ", "carlos1gmail.com", "123456"); 

-- buscar usuario en especifico
SELECT * FROM users WHERE email = "carlos1@gmail.com";

-- eliminar usuario

DELETE users WHERE user_id == 1


-- actualizar usuario

UPDATE users SET nombrecampo = 'cambiado', nombrecampo1='cambiado1'
WHERE user_id = 1




-- actualizar una nota
UPDATE notes SET title = 'nuevo', description = 'nuevo', date_at = 'nuevo', completed = 0, category = 'nuevo' WHERE note_id = 1 AND user = 10;


-- insertar una nota
INSERT INTO notes (title, description, date_at, completed, category, user) VALUES ('my first title', '12/10/2024', 'ocio', '123');


-- eliminar una nota

DELETE FROM notes WHERE note_id = 1 AND user = 15;


-- buscar notas de un usuario en especifico y tambien traer la data de su categoria
-- correspondiente

SELECT notes.*, categories.name FROM notes  INNER JOIN categories 
    ON notes.category = categories.category_id WHERE notes.user = 1;


-- buscar una nota de un usuario en especifico

SELECT * FROM notes WHERE user = 1 AND note_id = 7;

-- insertar una categoria en especifico

INSERT INTO categories (name) VALUES ('trabajo');
INSERT INTO categories (name) VALUES ('deporte');
INSERT INTO categories (name) VALUES ('ocio');
INSERT INTO categories (name) VALUES ('familia');
INSERT INTO categories (name) VALUES ('estudios');


-- buscar todas las categorias

SELECT * FROM categories

-- eliminar columna 
ALTER TABLE users DROP COLUMN last_name;

-- crear columna

ALTER TABLE users ADD COLUMN lastname VARCHAR(100) not null


-- cambiando el tipo de dato de un campo
ALTER TABLE notes MODIFY completed BOOLEAN DEFAULT 0



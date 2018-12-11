DROP TABLE IF EXISTS generos CASCADE;

CREATE TABLE generos
(
    id     BIGSERIAL    PRIMARY KEY
  , genero VARCHAR(255) NOT NULL UNIQUE
);

DROP TABLE IF EXISTS peliculas CASCADE;

CREATE TABLE peliculas
(
    id        BIGSERIAL    PRIMARY KEY
  , titulo    VARCHAR(255) NOT NULL
  , anyo      NUMERIC(4)
  , sinopsis  TEXT
  , duracion  SMALLINT     DEFAULT 0
                           CONSTRAINT ck_peliculas_duracion_positiva
                           CHECK (coalesce(duracion, 0) >= 0)
  , genero_id BIGINT       NOT NULL
                           REFERENCES generos (id)
                           ON DELETE NO ACTION
                           ON UPDATE CASCADE
);

DROP TABLE IF EXISTS usuarios CASCADE;

CREATE TABLE usuarios
(
    id       BIGSERIAL   PRIMARY KEY
  , login    VARCHAR(50) NOT NULL UNIQUE
                         CONSTRAINT ck_login_sin_espacios
                         CHECK (login NOT LIKE '% %')
  , password VARCHAR(60) NOT NULL
);

DROP TABLE IF EXISTS personas CASCADE;

CREATE TABLE personas
(
    id      BIGSERIAL   PRIMARY KEY
  , nombre  VARCHAR(255) NOT NULL
);

DROP TABLE IF EXISTS roles CASCADE;

CREATE TABLE roles
(
    id      BIGSERIAL PRIMARY KEY
  , rol     VARCHAR(255) NOT NULL UNIQUE
);

DROP TABLE IF EXISTS participantes CASCADE;

CREATE TABLE participantes
(
    pelicula_id BIGINT REFERENCES peliculas (id)
  , persona_id  BIGINT REFERENCES personas (id)
  , rol_id      BIGINT REFERENCES roles (id)
  , PRIMARY KEY (pelicula_id, persona_id,rol_id)
);


-- INSERT

INSERT INTO usuarios (login, password)
VALUES ('pepe', crypt('pepe', gen_salt('bf', 10)))
     , ('admin', crypt('admin', gen_salt('bf', 10)));

INSERT INTO generos (genero)
VALUES ('Comedia')
     , ('Terror')
     , ('Ciencia-Ficción')
     , ('Drama')
     , ('Aventuras');

INSERT INTO peliculas (titulo, anyo, sinopsis, duracion, genero_id)
VALUES ('Los últimos Jedi', 2017, 'Va uno y se cae...', 204, 3)
     , ('Los Goonies', 1985, 'Unos niños encuentran un tesoro', 120, 5)
     , ('Aquí llega Condemor', 1996, 'Mejor no cuento nada...', 90, 1);

INSERT INTO personas (nombre)
VALUES ('Chiquito')
    , ('Torrente')
    , ('Jason Brugal')
    , ('Vin Diesel');

INSERT INTO roles (rol)
VALUES ('Intérprete')
    ,  ('Director')
    ,  ('Protagonista')
    ,  ('Antagonista');

INSERT INTO participantes (pelicula_id, persona_id, rol_id)
VALUES (1,2,2)
    ,  (2,4,4)
    ,  (3,1,3)
    ,  (3,4,2);

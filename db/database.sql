-- CREACIÓN DE LA BASE DE DATOS

-- 0. CREAR UNA BASE DE DATOS

-- Database: Eventos

-- DROP DATABASE "Eventos";

CREATE DATABASE "Eventos"
    WITH 
    OWNER = postgres
    ENCODING = 'UTF8'
    LC_COLLATE = 'Spanish_Spain.1252'
    LC_CTYPE = 'Spanish_Spain.1252'
    TABLESPACE = pg_default
    CONNECTION LIMIT = -1;

-- PARTE DE GEORREFERENCIACIÓN

-- 1. Tablas auxiliares

-- Creación de tabla categoría

CREATE TABLE categoria_evento (
		id_categoria integer NOT NULL PRIMARY KEY,
		nombre_categoria text NOT NULL);
		
-- Ingreso de categorías
		
INSERT INTO categoria_evento VALUES ('1', 'Artístico');
INSERT INTO categoria_evento VALUES ('2', 'Deportivo');
INSERT INTO categoria_evento VALUES ('3', 'Formativo');
INSERT INTO categoria_evento VALUES ('4', 'Medioambiental');
INSERT INTO categoria_evento VALUES ('5', 'Reivindicativo');

-- Creación tabla clase de evento

CREATE TABLE clase_evento (
		id_clase integer NOT NULL PRIMARY KEY,
		id_categoria integer NOT NULL,
		nombre_clase text NOT NULL);

-- Creación clave foranea en clase_evento con id de tabla categori_eventos
	
ALTER TABLE clase_evento 
		ADD CONSTRAINT FKtest
		FOREIGN KEY (id_categoria)
		REFERENCES categoria_evento (id_categoria);

-- Inserción de valores de la clase_evento con id de categoría evento
		
INSERT INTO clase_evento VALUES ('1','1','Proyección');
INSERT INTO clase_evento VALUES ('2','1','Exposición');
INSERT INTO clase_evento VALUES ('3','1','Teatro');
INSERT INTO clase_evento VALUES ('4','1','Danza');
INSERT INTO clase_evento VALUES ('5','1','Circo');
INSERT INTO clase_evento VALUES ('6','1','Concierto');
INSERT INTO clase_evento VALUES ('7','1','Festival');
INSERT INTO clase_evento VALUES ('8','1','Performance');
INSERT INTO clase_evento VALUES ('9','1','Pasacalles');
INSERT INTO clase_evento VALUES ('10','1','Encuentro');
INSERT INTO clase_evento VALUES ('11','2','Partido');
INSERT INTO clase_evento VALUES('12','2','Quedada');
INSERT INTO clase_evento VALUES ('13','2','Competición');
INSERT INTO clase_evento VALUES ('14','2','Entrenamiento');
INSERT INTO clase_evento VALUES ('15','2','Carrera');
INSERT INTO clase_evento VALUES ('16','2','Encuentro');
INSERT INTO clase_evento VALUES ('17','3','Charla');
INSERT INTO clase_evento VALUES ('18','3','Taller');
INSERT INTO clase_evento VALUES ('19','3','Curso');
INSERT INTO clase_evento VALUES ('20','3','Seminario');
INSERT INTO clase_evento VALUES ('21','3','Asesoría');
INSERT INTO clase_evento VALUES ('22','3','Clase');
INSERT INTO clase_evento VALUES ('23','4','Excursión');
INSERT INTO clase_evento VALUES ('24','4','Batida');
INSERT INTO clase_evento VALUES ('25','5','Manifestación');
INSERT INTO clase_evento VALUES ('26','5','Concentración');
INSERT INTO clase_evento VALUES ('27','5','Acción directa');
INSERT INTO clase_evento VALUES ('28','5','Asamblea');
INSERT INTO clase_evento VALUES ('29','1','Presentación');


-- 2. Creación de tabla principal (con campos espaciales) y sus claves foraneas con las auxiliares

	
CREATE TABLE evento (
	id_evento BIGSERIAL NOT NULL PRIMARY KEY, 
	tipo_evento INTEGER NOT NULL,
	geom_evento geometry (POINT,4326),
	nombre_evento VARCHAR (100) NOT NULL,
	organizador_evento TEXT NOT NULL,
	descripcion_evento TEXT NOT NULL,
	inicio_evento TIMESTAMP NOT NULL,
	final_evento  TIMESTAMP NOT NULL,
	precio_evento INTEGER,
	aforo_evento INTEGER,
	imagen_evento TEXT,
	URL_evento TEXT,
	registro_evento TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (tipo_evento) REFERENCES clase_evento(id_clase) ON UPDATE CASCADE
	);

-- PARTE DE GEOLOCALIZACIÓN

-- 1. Creación de tabla principal conexion (con campos espaciales)
                
CREATE TABLE conexion (
	id_conexion BIGSERIAL NOT NULL PRIMARY KEY, 
	geom_conexion geometry (POINT,4326),
	tipo_conexion TEXT NOT NULL,
	idemc_conexion TEXT,
	distemc_conexion INTEGER,
	radiouno_conexion INTEGER,
	radiodos_conexion INTEGER,
	radiocinco_conexion INTEGER,
	registro_conexion TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
	);
-- 2. Creación de tabla principal filtros (con campos espaciales)

CREATE TABLE filtro (
	id_filtro BIGSERIAL NOT NULL PRIMARY KEY, 
	geom_filtro geometry (POINT,4326),
	clase_filtro TEXT NOT NULL,
	tipo_filtro TEXT NOT NULL,
	registro_filtro TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
	);

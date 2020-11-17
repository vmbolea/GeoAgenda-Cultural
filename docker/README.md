# Notas sobre Docker

Esta carpeta contiene los archivos para la puesta en marcha de los servicios del proyecto a través de la tecnología Docker en los servidores que gestiona la Asociación de Software Libre de la Universidad de Zaragoza (Pulsar) y de la que es miembro el director del TFM.

La idea es tener corriendo diversos contenedores de Docker con los servicios necesarios (web, base de datos y servidos de datos espaciales) que se lancen con un compositor (Docker compose). A través de este sistema lo que se consigue es que corran simultáneamente varios servicios de Docker relacionados. Véase:

- un gestor de bases de datos (Postgres),
- un servicio web (Apache + PHP) y
- un servicio de capas y teselas geográficas (Geoserver).

Se puede leer más de por qué usar Docker y qué es en [este artículo de explicación](https://www.edureka.co/blog/docker-explained/) pero hay muchos más por la red.

Básicamente la tecnología docker permite recrear una especie de máquina virtual con un sistema GNU/Linux sobre el que se corren aplicaciones específicas y que gracias a su naturaleza en imágenes y contenedores es fácilmente de poner en uso y es replicable en diferentes máquinas. 

# Imágenes de docker a usar

A continuación detallo las imágenes y comandos, por separado, para correr las imágenes de docker requeridas para cada uno de los servicios necesarios:

## Apache con PHP

Apache 2 + PHP 7.4

Usaremos una imagen del proyecto PHP en el que ya viene instalado el servicio web Apache y el lenguaje de programación para uso web PHP [Enlace a la documentación de la imagen en Docker Hub](https://hub.docker.com/_/php?tab=description)

Código para crear contenedor:

```bash
docker run -d \
    --name my-apache-php-app \
    -p 82:80  \
    -v /home/miguel/git/TFM/www:/var/www/html  \
    php:7.4-apache
```
Este es un ejemplo de código sobre la máquina de Miguel usando de salida el puerto 82 de la misma y diciendo que los archivos web están en `/home/miguel/git/TFM/www`

Si usamos `-v "$PWD":/var/www/html` correrá el servicio dando por sentado que la carpeta sobre la que se corre, $PWD, es la que debe tener `/www/html` de contenedor de Apache.

ATENCIÓN! La imagen que se usa **no es válida** para los propósitos del TFM al no disponer de la extensión PHP de postgres. Esto se ha corregido en el [compositor de docker](docker-compose.yml) en el que se le ha añadido a través de una [dockerfile](php_pg.dockerfile) la extensión requerida.

## Postgres con PostGIS

[Enlace a la documentación de la imagen en Docker Hub](https://hub.docker.com/r/postgis/postgis)

Código para crear contenedor:

```bash
docker run -d             \
    --name postgis-11-2.5 \
    -p 5432:5432          \
    -e POSTGRES_PASSWORD=secret                 \
    -e PGDATA=/var/lib/postgresql/data          \
    -v ./data-postgres:/var/lib/postgresql/data \
    postgis/postgis:11-2.5
```
En realidad esta imagen de PostGIS es una de postgres con la extensión espacial incluida. Más información sobre la imagen de postgres [en su página de Docker Hub](https://registry.hub.docker.com/_/postgres/)

Con esta opción de volúmen `-v ./data-postgres:/var/lib/postgresql/data` nos creará una carpeta de datos de postgres en el interior de la carpeta en la uqe estemos corriendo el comando. Esta carpeta y los archivos internos tendrán privilegios de administrador (usuario root en Linux) y no se podrán visibilizar con un usuario ordinario.

## Geoserver

Imagen a usar: [oscarfonts/geoserver - Docker Hub](https://hub.docker.com/r/oscarfonts/geoserver)

```bash
docker run -d             \
    --name geoserver-2.17 \
    -p 8080:8080          \
    -v /opt/dockerv/geoserver/data_dir:/var/local/geoserver \
    oscarfonts/geoserver:2.17.2
```
Es deseable tener __al menos 3 Gb de RAM__, incluso más si se van a manejar datos ráster o grandes conjuntos de datos.

a los anteriores containers se les puede añadir la opción `--restart=always` que permitirá que si se cae el servicio se reinicie

## Enlazar redes de contenedores

Esta opción está en desuso como se puede leer aquí [Legacy container links | Docker Documentation](https://docs.docker.com/network/links/).

Si añadimos la opción `link` al generar un contenedor podremos enlazar internamente con la red de otros contenedores con su nombre. O sea con la opción `--link db:db` podremos usar conectar con el contenedor llamado `db` usando el nombre `db` sin tener que salir o usar el típico `localhost` que sería el del sistema sobre el que se corre docker. 


# Docker Compose

Con el _compositor_ de docker, _docker compose_, podemos correr desde un archivo de configuración varios servicios a la vez que mantengan dependencias para su manejo. Los servicios indicados para el TFM son interdependientes, las páginas que sirve Apache con PHP necesitan conectarse con la base de datos en el servidor Postgres (que está en otro contenedor) o Geoserver depende, igualmente de los datos espaciales que sirve PostGIS.

Para ello es necesario tener instalado `docker-compose` en el equipo y editar una archivo en formato [YAML](https://en.wikipedia.org/wiki/YAML) para indicar las opciones de los servicios a lanzar con Docker.

## Instalación de docker-compose

Fuente: [Install Docker Compose | Docker Documentation](https://docs.docker.com/compose/install/)

Revisar última versión en: https://github.com/docker/compose/releases/

En debian/ubuntu:

```bash
sudo curl -L "https://github.com/docker/compose/releases/download/1.27.4/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose
```

## Archivo compositor

El archivo es [docker-compose.yml](docker-compose.yml)
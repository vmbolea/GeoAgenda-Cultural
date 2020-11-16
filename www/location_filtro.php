<!-- Archivo de consulta sobre la tabla filtro de la base de datos (BD) --->


<?php
include "conexion.php"; // incluye el archivo de conexion
$flatitud = $_POST['lat']; // latitud de posición del usuario
$flongitud = $_POST['lng']; // longitud de posición del usuario
$fclase = $_POST['clase']; // clase de filtro utilizado por el usuario
$ftipo = $_POST['tipo']; // tipo de filtro utilizado por el usuario



$sql = "INSERT INTO filtro(geom_filtro, clase_filtro, tipo_filtro)
VALUES ( ST_GeomFromText('POINT($flongitud $flatitud)', 4326),'$fclase','$ftipo')"; // creación de consulta

$run = pg_query ($conn,$sql); // ejecutar función de consulta (consulta + conexion)

/*  if($run== TRUE) // Devolver tipo cuando se ejectua o el error 
    echo $ftipo;
else
    echo "Error cuántico, las comillas simples"; */ 


?>
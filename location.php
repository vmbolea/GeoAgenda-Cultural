<!-- Archivo de consulta sobre la tabla conexion de la base de datos (BD) --->


<?php
include "conexion.php"; // incluye el archivo de conexion 
$flatitud = $_POST['lat']; // latitud de posición del usuario
$flongitud = $_POST['lng']; // longitud de posición del usuario
$ftipo = $_POST['tipo']; // tipo (solo existe c de conexión)
$fnearid = $_POST['ev_near_id']; // evento más cercano al usuario
$fdist = $_POST['distance']; // distancia al evento más cercano
$fdist = !empty($fdist) ? "$fdist" : "0.0"; // si la distancia esta vacía darle valor estipulado
$fradiouno = $_POST['pointsuno']; // cantidad de eventos en un radio 
$fradiouno = !empty($fradiouno) ? "$fradiouno" : "0"; // si la cantidad esta vacía darle valor 0
$fradiodos = $_POST['pointsdos']; // cantidad de eventos en un radio 
$fradiodos = !empty($fradiodos) ? "$fradiodos" : "0"; // si la cantidad esta vacía darle valor 0
$fradiocinco = $_POST['pointscinco']; // cantidad de eventos en un radio 
$fradiocinco = !empty($fradiocinco) ? "$fradiocinco" : "0"; // si la cantidad esta vacía darle valor 0


$sql = "INSERT INTO conexion(geom_conexion, tipo_conexion, idemc_conexion, distemc_conexion, radiouno_conexion, radiodos_conexion, radiocinco_conexion)
VALUES ( ST_GeomFromText('POINT($flongitud $flatitud)', 4326),'$ftipo','$fnearid','$fdist','$fradiouno','$fradiodos','$fradiocinco')"; // creación de consulta

$run = pg_query ($conn,$sql); // ejecutar función de consulta (consulta + conexion)

/* if($run== TRUE) // Devolver mensaje de éxito o error
    echo "Registro realizado correctamente";
else
echo "Error cuántico, las comillas simples";  */



?>
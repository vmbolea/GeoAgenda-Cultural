<!-- Archivo de consulta sobre las tablas categoria_evento y tipo_evento de la base de datos (BD) --->

<?php
include "conexion.php"; // se incluye el archivo de conexion 
$output=''; // se declara variable vacía
$sql= "SELECT * FROM tipo_evento WHERE id_categoria='".$_POST["idcategoria"]."'";  // creación de consulta
$result = pg_query($conn, $sql);  // ejecutar función de consulta (consulta + conexion)
$output='<option value="">Selecciona una tipo de evento</option>'; // se alimenta la variable vacia
while($row=pg_fetch_array($result)) // mientras se declara variable que es un array del resultado de ejecución de función
{
        $output .= '<option value="'.$row["id_tipo"].'">'.$row["nombre_tipo"]. '</option>'; // desplegable del nombre mientras se selecciona el id   
}
echo $output; // se devuelve la variable alimentada
?>


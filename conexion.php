<!-- Archivo de conexión a la base de datos (BD) --->
<?php
    $cadena =          // Creación URL anfitrión, puerto, nombre de la BD, usuario y contraseña
        "host='postgres'    
        port='5432'
        dbname='eventos'
        user='vmbolea'
        password=unizar@geo2020";

    $conn=pg_connect($cadena) // Función de conexión
    
    /* or die ("Error de conexión." . pg_last_error());
    echo "Conexión existosa <hr />";  */
?>
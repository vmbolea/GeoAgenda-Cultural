<!-- Archivo de consulta sobre la tabla evento de la base de datos (BD) --->

<?php
include "conexion.php"; // incluye el archivo de conexion 
    $ftipo = $_POST['tipo']; // variable con referencia tipo
    $flatitud = $_POST['latitud']; // variable con referencia de latitud
    $flongitud = $_POST['longitud'];  // variable con referencia de longitud
    $fnombre = $_POST['nombre'];  // variable con referencia de nombre
    $forganizador = $_POST['organizador']; // variable con referencia de organizador
    $fdescripcion = $_POST['descripcion'];// variable con referencia de descripcion
    $finicio = $_POST['inicio']; // variable con referencia de fecha de inicio
    $fdefault = date('Y-m-d H:i:s', strtotime($finicio.'+3 hours')); // variable con referencia de fecha de inicio + 3 horas
    $ffinal = $_POST['final']; // variable con referencia de fecha de final
    $ffinal = !empty($ffinal) ? "'$ffinal'" : "'$fdefault'"; // si esta vacía darle valor de variable default (inicio + 3 horas)
    $fprecio = $_POST['precio']; // variable con referencia de precio
    $fprecio = !empty($fprecio) ? "'$fprecio'" : "NULL"; // si esta vacía darle valor NULL
    $faforo = $_POST['aforo']; // variable con referencia de aforo
    $faforo = !empty($faforo) ? "'$faforo'" : "NULL"; // si esta vacía darle valor NULL
    $furl = $_POST['url']; // variable con referencia de url
    $fimagen = $_FILES['imagen']['name'];  // variable con referencia de nombre de imagen
    $ftempimagen = $_FILES['imagen']['tmp_name'];  // variable temporal de nombre de imagen

    move_uploaded_file($ftempimagen,"imagenes/$fimagen"); //mover archivo (imagen) al directorio del servidor donde se almacenan

    $sql = "INSERT INTO evento( tipo_evento, geom_evento, nombre_evento, organizador_evento, descripcion_evento, inicio_evento, final_evento, precio_evento, aforo_evento, imagen_evento, url_evento)
    VALUES ($ftipo, ST_GeomFromText('POINT($flongitud $flatitud)', 4326), '$fnombre', '$forganizador', '$fdescripcion', '$finicio' , $ffinal , $fprecio, $faforo, '$fimagen', '$furl')"; // creación de consulta

    $run = pg_query ($conn,$sql); // ejecutar función de consulta (consulta + conexion)

/* if($run== TRUE)
    echo "Registro realizado correctamente";
;
else
    echo "Error cuántico, las comillas simples"; */
    

?>

<!-- Se muestran los resultados del evento que se acaba de registrar--->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml">
    <head>

      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <!-- enlace a los estilos de entrada de datos css -->
        <link href="estilos/style_in.css" rel="stylesheet" type="text/css" />

          <title>Evento registrado</title>
    </head>

    </body>
    <div  >
          <h1>Evento registrado</h1>
    <div>
    <div class="container"> <!-- estilo elemento-->
<table>  <!-- Comienzo elemento de tabla-->
  <tr>
    <td>Categoria: </td>
    <td><?php // consulta para obtener el nombre de la categoria seleccionada a partir del id del tipo de evento
        include "conexion.php";
            $sql = "SELECT     *
            FROM       categoria_evento INNER JOIN tipo_evento ON categoria_evento.id_categoria = tipo_evento.id_categoria
            WHERE      tipo_evento.id_tipo ='".$_POST["tipo"]."'";
            $result = pg_query($conn, $sql);
            while($row = pg_fetch_array($result)) {
            echo $row['nombre_categoria']; 
            }
            ?> </td>
  </tr>
  <tr>
    <td>Tipo:</td> 
    <td><?php // consulta para obtener el nombre del tipo de evento seleccionada a partir del id del tipo de evento
        include "conexion.php";
            $sql= "SELECT * FROM tipo_evento WHERE id_tipo='".$_POST["tipo"]."'";
            $result = pg_query($conn, $sql);
            while($row = pg_fetch_array($result)) {
            echo $row['nombre_tipo']; 
            }
            ?></td>
  </tr>
  <tr>
    <td>Nombre: </td>
    <td><?php  // consulta para obtener el nombre del evento
    include "conexion.php"; echo $_POST['nombre']?></td>
  </tr>
  <tr>
    <td>Organizador: </td>
    <td><?php  // consulta para obtener el organizador del evento
    include "conexion.php"; echo $_POST['organizador']?></td>
  </tr>
  <tr>
    <td>Descripción:</td> 
    <td><?php  // consulta para obtener la descripción del evento
    include "conexion.php"; echo $_POST['descripcion']?></td>
  </tr>
  <tr>
    <td>Inicio:</td>
    <td><?php // consulta para obtener la fecha de inicio del evento
    include "conexion.php"; echo $_POST['inicio']?></td>
  </tr> 
  <tr>
    <td>Final:</td> 
    <td><?php  // consulta para obtener la fecha de final (o default) del evento
    include "conexion.php"; 
    $fdefault = date('Y-m-d H:i:s', strtotime($finicio.'+3 hours'));
    $ffinal = $_POST['final'];
    $ffinal = !empty($ffinal) ? "'$ffinal'" : "'$fdefault'"; 
    echo $ffinal; 
    ?>
    </td>
  </tr>
  <tr>
    <td>Coordenadas (lat,lng):</td>
    <td><?php // consulta para obtener las coordenadas del evento
    include "conexion.php";
            $flatitud = $_POST['latitud'];
            $flongitud = $_POST['longitud'];
            echo " $flatitud , $flongitud ";
    ?>
    </td>
  </tr>  
  <tr>
    <td>Precio:</td>
    <td><?php // consulta para obtener el precio del evento
    include "conexion.php"; $fprecio = $_POST['precio'];
    $fprecio = !empty($fprecio) ? "'$fprecio'" : "No especificado"; echo $fprecio; ?></td>
  </tr> 
  <tr>
    <td>Aforo:</td>
    <td><?php  // consulta para obtener el aforo del evento
    include "conexion.php"; $faforo = $_POST['aforo'];
                $faforo = !empty($faforo) ? "'$faforo'" : "No especificado"; 
                echo $faforo; ?>
    </td>
  </tr> 
  <tr>
    <td>URL: </td>
    <td><?php // consulta para obtener la url del evento
    include "conexion.php";  $furl = $_POST['url'];
               $furl =!empty($furl) ? "'$furl'" : "No especificado";
               echo $furl; ?></td>
  </tr>
  <tr>
    <td>Imagen: </td>
    <td><?php include "conexion.php";
        // Echo out a sample image

        if ($_FILES['imagen']['name'] == null ) {
          echo "Sin imagen";
        }else {
          $fimagen = $_FILES['imagen']['name']; // variable de archivo de imagen y nombre
          $image = "imagenes/$fimagen"; // variable de directorio de la imagen
        $imageData = base64_encode(file_get_contents($image)); // variable leer directorio y convertirlo a codificación base64
        // Format the image SRC:  data:{mime};base64,{data};
        $src = 'data: '.mime_content_type($image).';base64,'.$imageData; // variable formateada mime y base64
        
        echo '<a href="'.$image.'" ><img src="' . $src . '"  display: "block"
        margin-left: "auto" margin-right: "auto" width: "50%" / ></a>'; // Devuelve la referencia de la imagen y la variable SRC con la imagen formateada y convertida
      }
        ?></td>
  </tr>
</table>  <!-- Final elemento de tabla-->
<form name= "action" action="index.html" method="POST">  <!-- Botón para volver al visor principal-->
    <div class="form-group">
        <button type="submit" name="action" value="index">Volver al visor principal</button>
    </div>
</form>
</div>
</body>
</html>

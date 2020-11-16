<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!-- enlace a CSS de Leaflet  Leaflet 1.7.1 en el directorio -->
        <link rel="stylesheet" href="js/leaflet.css"/>
        <!-- enlace a CSS de Leaflet  Leaflet 1.7.1 en la nube -->
       <!--  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
   integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
   crossorigin=""/> -->

        <!-- enlace a los estilos css -->
        <link href="estilos/style.css" rel="stylesheet" type="text/css" />
        
        <!-- Iconos diseñados por <a href="https://www.flaticon.es/autores/freepik" title="Freepik">Freepik</a> from <a href="https://www.flaticon.es/" title="Flaticon"> www.flaticon.es</a> -->       

          <title>Registre su evento</title>

      </head>
          <body>
            <div class="container">  <!-- estilo container -->
              <!-- Aquí se opera fuera del formulario porque aún se esta trabajando sobre las tablas auxiliares tipo_evento y categoria_evento -->
              <div class="form-group" id="categoria"> <!-- estilo elemento-->
                <h3>Categoría de evento</h3>
              <select name= "categoria" id="categoria_lista" required> <!-- desplegable de categoria con id enviado función a la AJAX + consulta PHP (abajo en script) -->
                <option value disabled selected>Seleciona una categoría de evento</option> <!-- opciones del desplegable -->
                  <!-- Uso de php para mostrar la tabla auxiliar de categoria_evento por el nombre de las mismas -->
                    <?php
                    include ('conexion.php'); // incluye la conexión a la DB
                    $query = "SELECT * FROM categoria_evento"; // consulta a la tabla categoria_evento
                    $do = pg_query($conn, $query); // ejecución consulta + conexion
                    while($row = pg_fetch_array($do)){
                      echo '<option value="'.$row['id_categoria'].'">'.$row['nombre_categoria'].'</option>';
                    } // devuelve columna con los nombres de categoria pero la referencia es el id
                    ?> 
              </select>
            </div>

        <!-- Aquí comienzan los elementos cuyas referencias serán registradas-->
            <form name= "registrar" action="registrado.php" method="POST" enctype="multipart/form-data" > <!-- método de envio, acción de la página de destino y enctype para imagenes -->
                <div class="form-group" id="tipo">  <!-- estilo elemento-->
                    <h3>Tipo de evento</h3>
                  <select name="tipo" id="tipo_lista" required> <!-- desplegable de tipo con id recibido de la función AJAX + consulta PHP (abajo en script) -->
                  <option value=""> Seleciona un tipo de evento</option> <!-- opciones del desplegable -->
                  </select>  
                </div>

        <!-- Apartado de localización -->
                <div class="form-group"> <!-- estilo elemento-->
                    <h3>Localización del evento</h3>
                  <div id="map" style="width: 100%; height: 600px;"> <!-- estilo elemento mapa (abajo en script)-->
                  </div>
                      </div>
          <div class="form-group"> <!-- estilo elemento-->
          <h3>Coordenadas del evento</h3>
          <input class="coord" type="text" name="latitud" id="latitud" placeholder="Latitud del evento" required/> <!-- cuadro de texto alimentado con la latitud del elemento mapa-->
          <input class="coord" type="text" name="longitud" id="longitud" placeholder="Longitud del evento" required/> <!-- cuadro de texto alimentado con la longitud del elemento mapa-->
        </div>     
        <div class="form-group"> <!-- estilo elemento-->
          <h3>Nombre de evento</h3>
          <input type="text" name="nombre" placeholder="Introduce el nombre del evento" required/> <!-- cuadro de texto de nombre del evento-->
        </div>
        <div class="form-group"> <!-- estilo elemento-->
          <h3>Organizador de evento
            <input type="text" name="organizador" placeholder="Introduce el nombre del organizador del evento" required /> <!-- cuadro de texto de organizador del evento-->
          </h3>
        </div>
        <div class="form-group"> <!-- estilo elemento-->
          <h3>Descripción del evento</h3>
          <textarea id="subject" name="descripcion" placeholder="Introduce la descripción..." style="height:200px" required></textarea> <!-- cuadro de área de texto de descripción del evento-->
        </div>
        <div class="form-group"> <!-- estilo elemento-->
          <h3>Selecciona el inicio del evento</h3>
          <input type="datetime-local"  
                  name="inicio"  
                  value="<?php echo date('Y-m-d').'T'.date('H:i'); // valor en la fecha y el momento actual ?>" 
                  min="<?php echo date('Y-m-d').'T'.date('H:i');// mínimo en la fecha y el momento actual ?>"
                  required> <!-- cuadro de fecha de inicio del evento--> 
        </div>
        <div class="form-group"> <!-- estilo elemento-->
          <h3>Selecciona el final del evento</h3>
          <input type="datetime-local" 
                 name="final" 
                 value=""
                 min="<?php echo date('Y-m-d').'T'.date('H:i'); // mínimo en la fecha y el momento actual (habría que vincularlo a la fecha elegida de inicio) ?>"
                  ><!-- cuadro de fecha de final del evento--> 
          <br> Este campo es opcional y si no se rellena el final del evento se establecerá 3 horas despúes del inicio.
        </div>
        <div class="form-group"> <!-- estilo elemento-->
          <h3>Imagen del evento</h3>
          <input
            
            type="file"
            name="imagen"
          > <!-- mirar poner límite de tamaño en la imagen-->
          <br> Este campo es opcional y los formatos admitidos son ....
        </div>
        <div class="form-group">  <!-- estilo elemento-->
          <h3>URL del evento</h3>
          <input
            type="text"
            name="url"
          > <!-- cuadro de texto para url del evento-->
          <br> Este campo es opcional.
        </div>
        <div class="form-group"> <!-- estilo elemento-->
          <h3>Precio del evento</h3>
          <input
            type="integer"
            name="precio"
          > <!-- cuadro numérico de precio del evento-->
          <br> Si se deja en blanco no aparecera referencia al precio del evento, cualquier número (incluido "0") aparecera como el precio del evento.
        </div>
        <div class="form-group"> <!-- estilo elemento-->
          <h3>Aforo del evento</h3>
          <input
            type="integer"
            name="aforo"
          > <!-- cuadro numérico de aforo del evento-->
          <br> Si se deja en blanco no se hara referencia al aforo del evento, cualquier número (incluido "0") aparecera como el precio del evento.
        </div>
        <div class="form-group"> <!-- estilo elemento-->
          <input 
            type="submit"
            name="registrar"
            id="registrar"
            >
        </div> <!-- cuadro tipo bóton para acabar formulario -->
                </form>
</body>
<!-- enlace a JavaScript de Leaflet 1.7.1 en el directorio -->
<script src="js/leaflet.js"></script>
<!-- enlace a JavaScript de Leaflet 1.7.1 en la nube -->
<!-- <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
   integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
   crossorigin=""></script>-->

<!-- enlace a jquery-3.5.1 en el directorio -->
<script src="js/jquery-3.5.1.min.js" type="text/javascript"></script>
<!-- enlace a jquery-3.5.1 en la nube -->
<!-- <script
  src="https://code.jquery.com/jquery-3.5.1.js"
  integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
  crossorigin="anonymous"></script>-->

<!-- Se crea con jquery y ayax una función por la que jquery funciona cuando #categoria_lista cambia y le da a la var categoria ese valor
        entonces ajax llama a tipo.php por el metodo POST, tipo de dato texto y en caso de exito que muestre el resultado en el id tipo_lista -->

        <script type="text/javascript">
  
        $(document).ready(function(){ // que se active cuando en el documento
        $('#categoria_lista').change(function(){ //cambie el id de categoria
        var idcategoria=$(this).val(); // se declara variable con el valor de la categoria seleccionada
        $.ajax({                      // función asincrona ajax
          url:"tipo.php",             // archivo php con consulta
          method: "POST",             // metodo de envio de referencia
          data:{idcategoria},         // datos enviados (la variable declarada arriba)
          dataType:"text",            // tipo de datos
          success: function(data){$('#tipo_lista').html(data);} // devuelve el valor que da el archivo php al id tipo lista
              });
                                              });
                                    });

/* El mapa con el que se recogen las referencias de latitud y longitud */

var osmUrl ='http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png'; // variable con url del mapa base
var osmAttrib='&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors' // variable con la atribución
var osm = new L.TileLayer(osmUrl, {attribution: osmAttrib}); // variable con la capa creada a partir de url y atribución
var map = new L.Map('map').addLayer(osm).setView([41.66, -0.88], 13); // variable de mapa, añadida al id del documento map con la capa y la localización

/* Función para que al presionar sobre un punto en el mapa se tomen las coordenadas y que solo pueda existir un marcador */
  var marker; // declara variable vacía

      map.on('click', function(e) {    // al presionar sobre el mapa                        
        var lat = e.latlng.lat; // declara variable con el valor de la latitud
          document.getElementById('latitud').value = lat; // este valor se recoge con el id con el que sera enviado al documento
        var lng = e.latlng.lng; // declara variable con el valor de la longitud
          document.getElementById('longitud').value = lng; // este valor se recoge con el id con el que sera enviado al documento
            if (marker) {map.removeLayer(marker);} // condición para que si existe ya un marcador borre el anterior
                marker = new L.Marker(e.latlng).addTo(map); // añadir nuevo marcador en el punto en el que presiona el usuario
                                  });


/* Pruebas para limitar el tamaño de la imagen a subir*/
                                 
/* function checkSize(max_img_size)
{
    var input = document.getElementById("upload");
    // check for browser support (may need to be modified)
    if(input.files && input.files.length == 1)
    {           
        if (input.files[0].size > max_img_size) 
        {
            alert("The file must be less than " + (max_img_size/1024/1024) + "MB");
            return false;
        }
    }

    return true;
} */


          </script>





</html>

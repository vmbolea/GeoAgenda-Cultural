# Construcción de la base de datos

La construcción y el diseño de la base de datos es realizada con PostgreSQL. La base de datos esta compuesta por cinco tablas de las que tres tienen un campo con información espacial, a saber: `conexion`, `filtro` y `evento`. El modelo de datos es vectorial de puntos y el sistema de referencia de coordenadas configurado es EPSG:4326. Además, la tabla `evento` incluye dos tablas auxiliares que codifican las categorías y tipos de eventos disponibles.

![Esquema de la BD](images/esquema_bd.png)

La tabla `evento` será alimentada con información tanto espacial como temática generada por el denominado insumidor voluntariamente. Por lo tanto, cuenta con otros campos que son de texto, numéricos o temporales para almacenar la información temática. Estos campos pueden ser 
- obligatorios: `tipo_evento`, `nombre_evento`, `organizador_evento`, `descripcion_evento`, `inicio_evento` y `final_evento`,
- no obligatorios: `precio_evento`, `aforo_evento`, `imagen_evento` y `url_evento`
- o inherentes a la consulta: `id_evento` y `registro_evento`

Las tablas auxiliares definen las categorías y los tipos de evento configurados en la plataforma. A partir de `id_tipo` se alimenta el campo con referencia foránea de la tabla principal `tipo_evento`. Esta preconfiguración se define en base a la observación de la disposición de otras bases de datos sobre eventos culturales. 

Las otras dos tablas cumplimentan su campo espacial con la posición del denominado consumidor. En el caso de la tabla `conexion`; al conectarse a la plataforma y autorizar su localización, se rellenan el resto de campos en base a su relación con la información que contiene la tabla evento. Así pues, se obtiene la referencia del evento cultural más cercano, la distancia hasta este y la cantidad de eventos en un radio de uno, dos y cinco kilómetros. La tabla `filtro` recoge las interacciones del consumidor con las funciones de filtros de la información. Se toma la localización autorizada por el consumidor y se le añade la clase y el tipo de filtros utilizados desde su posición.

La construcción y el diseño de la base de datos ha estado sometida a un proceso de retroalimentación durante el desarrollo de esta herramienta. Así se decide no incluir la tabla `usuario` que funcionaba como referencia del campo `organizador_evento` convertido a tipo numérico de la tabla `evento` o se cambiaron los formatos de los campos temporales para mejorar su posterior manipulación.

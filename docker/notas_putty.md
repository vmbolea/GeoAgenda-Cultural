# SSH en Windows

Para el uso de una conexión de SSH desde windows se puede usar el programa **Putty** desde el cual gestionaremos el acceso a la terminal de la máquina remota y podremos lanzar aplicaciones (incluso gráficas) o traer los puertos del servidor.

Se puede instalar vía Chocolatey: `choco install putty`

# Opciones para conexión en Putty

- Session
    - Host Name: nombredelservidor
    - Port: puertodeconexion
- Connection
    - Data
        - Login details --> Autologin username: (omitido por seguridad)
    - SSH
        - Auth
            - Private key file for autentication: enlazar con archivo de clave privada `*.ppk`
        - X11
            - Activar la opción "Enable X11 forwarding" y dejar el resto por defecto
        - Tunnels -- Aquí crearemos túneles para pasar puertos del equipo local al remoto y viceversa
            - Útiles para añadir:
                - Source port: 9000; Destination: localhost:9000, Local --> para ver el 9000 del servidor en local
                - Source port: 5432; Destination: localhost:5433, Local --> para ver el 5432 (postgres) del servidor en el 5433 del local

# Usar programas gráficos 

Para traernos las aplicaciones gráficas al equipo local con windows necesitamos un programa que sea capaz de manejar las ventanas de GNU/Linux (las X11) y para ello podemos usar `xming`.

Se puede instalar vía Chocolatey: `choco install xming`

Recuerda que ANTES de correr una aplicación gráfica desde la consola de Putty hay que correr la aplicación `xming` que se encargará de recoger las ventanas que lleguen desde las aplicaciones gráficas del servidor.


# DOS SERVICIOS CON DOCKER SWARM 
## Pasos:
### Codear y luego crear los dockerfile de los servidores apache y node
Para crear las imagenes que van a utilizar los servicios, hay que abrir la consola en la raiz del repositorio clonado y luego utilizar los siguientes comandos:
- El comando para crear la imagen del servidor apache es: 
```sh
docker build -t image_apache ./apache-datos
```
- El comando para crear la imagen el servidor node es: 
```sh
docker build -t image_node ./node-datos
```
### Preparar el archivo .yml para desplegar los servicios
- El archivo .yml en este caso se llama: "servicios.yml"
- Se preparó el archivo luego de haber hecho pruebas en los servidores con la base de datos definiendo los volumenes para cada servicio

### Conexión de la base de datos
- Para conectar el servicio de la base de datos a los demas servicios, se configuro el host de cada servicio con el nombre del servicio que contendrá a la base de datos, en este caso se llama "mysql"
### Crear los servicios con Docker Swarm
- Para crear los servicios hay que pasarle las imagenes creadas de cada servidor a los servicios que correrán dichas imagenes
- Para desplegar los servicios se utiliza el siguiente comando en la consola: 
```sh
docker stack deploy -c servicios.yml services
``` 
Donde servicios.yml es el archivo .yml con la configuracion para el despliegue y services es el nombre de los servicios.

### Acceso a los servicios
- Para acceder al servicio de apache hay que situarse en:
```
http://localhost:8080
```
- Para acceder al servicio de node hay que situarse en:
```
http://localhost:8090
```
En el caso del servidor node, hay que esperar unos segundos para que inicie.
### Borrar servicios 
Una forma de verificar si trabajamos bien la persistencia de datos es borrar los servicios y volverlos a desplegar.
Para borrar los servicios se utiliza el comando docker service rm.
- Para borrar el servicio de node el comando a utilizar es: 
```
docker service rm services_node
```
- Para borrar el servicio de apache el comando a utilizar es: 
```
docker service rm services_apache
```
- Para borrar el servicio de la base de datos el comando a utilizar es: 
```
docker service rm services_mysql
```
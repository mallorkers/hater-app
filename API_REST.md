


## Códigos de respusta
 | Código | Descripción |
|--------|--------|
|  200     |Succes        |
|  201      | Succes - nuevo recurso creado.   |
|    204    |  Succes - no hay contenido para responder.      |
| 400       |   Bad Request - i.e su solicidud no se pudo evaluar.     |
|  401      |   Unauthorized - usuario no esta autenticado para este recurso.     |
|   404    |   Not Found - recurso no existente.     |
|  418    |   Soy una tacita :)      |
|   422     |    Unprocessable Entiti - i.e errores de validación.     |
|   429     |    Límite de uso excedido, intente más tarde.    |
|   500     |    Error de servidor.   |
|   503     |    Servidor no disponible.    |

#Datos básicos
**Nombre bd:** haterapp
### Colecciones 

|Publicar |Moderar | Comentarios  | Usuarios |
|--------|--------| ---------|------- |
| Contiene los mensajes publicados. | Contiene los mensajes que están por moderar.   |  Contiene los comentarios de cada publicación. | Contiene información de los usuarios. |
##Esquemas

#### Esquema publicar:

``` javascript
 {
    "_id": 
    "tags": [
      
    ]
    "usuario": // id
    "sexo":  // "m" o "f"
    "fecha":  // new Date()
    "mensaje":
    "num_comentarios":
    "votos_positivos":   //cuando ambas votaciones lleguen a cierto número
    "votos_negativos":	// se evalua para saber si publicarlo o elimiarlo
    "comentarios": [
          id1, id2
     ]
     }
```  
   Tags: 'Amor',  'Dinero', 'Estudios', 'Familia', 'Política', 'Tecnologia', 'Sexo', 'Trabajo', 'Televisión', 'Salud', 'Otros'
   
####Esquema moderar:

``` javascript
 {
    "_id": 
    "tags": 
    "usuario": // id
    "sexo":  
    "mensaje":
    "aprobado": 
    "rechazado":
    "usuarios_moderado": //id
     }

``` 







#Rutas

#### Publicados
| Ruta | Método |  Descripción|
|--------|--------|-------|
|      api/publicados  |     GET   |   Obtiene 10 publicaciones.   |
|	[api/publicados](#api/publicados)|	POST| 	Añade una publicación.				|
|api/publicados/p/:pag|GET|Obtiene las siguientes 10 publicaciones|



#### Moderar
| Ruta | Método |       Descripción|
|--------|--------|-------|
| api/moderar/{id}  | GET  | Obtiene una publicación de la colección de moderados |
|	[api/moderar](#api/moderar_POST)	|	POST| Añade una publicacion a la colección moderados.|
|api/moderar/:id/:[positivo/negativo]| PUT | Actualiza los campos de votación |
| api/moderar/:id | DELETE | Elimina una publicación de la colección moderados|


#### Usuarios
| Ruta | Método |  Descripción|
|--------|--------|-------|
|      api/usuarios| GET   |   Obtiene todos los usuarios.   |
|	api/usuarios/id |	GET | 	Obtiene un usuario por su id.	|
|	api/usuarios	|		POST	| 	Añade un usuario.		|
|	api/usuarios	|	DELETE		| 	Elimina un usuario.		|


---

#PUBLICAR


## Nueva publicacón

######Solicitud [POST] /api/moderar

``` javascript
  {
    "tags": 
    "usuario": //id
    "sexo": 
    "mensaje":   
    }
``` 
respuesta
    
``` javascript
 {
    "_id": 
    "tags": 
    "usuario": // id
    "sexo":  
    "mensaje":
	"aprobado":
    "rechazado":
     }

``` 

## Crear un nueva publicación
<a name="api/publicados">
######Solicitud [POST] /publiaciones

``` javascript
	{
    "tags": 
    "usuario": 
    "sexo": 
    "mensaje":    
    }
``` 
 Respuesta
    
``` javascript

	{
	"id": 
    "tags": 
    "sexo": 
    "mensaje": 
    "num_comentarios"
 	"votos_positivos":
    "votos_negativos"
	"comentarios": [
      //	id1,id2...
     ] 
``` 

#MODERAR
<a name="api/moderar_POST">
###### Solicitud [POST] /api/moderar/

``` javascript
  {
    "tags": 
    "usuario": //id 
    "sexo": 
    "mensaje":   
    }
```  

Respuesta
``` javascript
 
  {
    "_id": 
    "tag": 
    "usuario": // id
    "sexo":  
    "mensaje":
    "aprobado": 
    "rechazado":
     }

```


Solicitud [PUT] /api/moderados/:id/:[positivo|negativo]


``` javascript
//vacio
```  

Respuesta
``` javascript
 
  {
    "_id": 
    "tag": 
    "usuario": // id
    "sexo":  
    "mensaje":
    "aprobado": incrementado //aumenta en una unidad la votación elegida
    "rechazado":
     }

``` 







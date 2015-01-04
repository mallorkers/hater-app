


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

|Publicaciones |Moderados | Comentarios  |
|--------|--------| ---------|
| Contiene los mensajes publicados. | Contiene los mensajes que están por moderar.   |  Contiene los comentarios de cada publicación. |

#Rutas

#### Publicaciones
| Ruta | Método |  Descripción|
|--------|--------|-------|
|      api/publicaciones  |     GET   |   Obtiene 10 publicaciones.   |
|	api/publicaciones|	POST| 	Añade una publicación.				|
|api/publicaciones/p/:pag|GET|Obtiene las siguientes 10 publicaciones|



#### Moderados
| Ruta | Método |       Descripción|
|--------|--------|-------|
| api/moderados/{id}  | GET  | Obtiene una publicación de la colección de moderados |
|	api/moderados	|	POST| Añade una publicacion a la colección moderados.|
|api/moderados/:id/:[positivo/negativo]| PUT | Actualiza los campos de votación |
| api/moderar/:id | DELETE | Elimina una publicación de la colección moderados|


#### Usuarios
| Ruta | Método |  Descripción|
|--------|--------|-------|
|      api/usuario | GET   |   Obtiene todos los usuarios.   |
|	api/usuario/id |	GET | 	Obtiene un usuario por su id.	|
|	api/usuario	|		POST	| 	Añade un usuario.		|
|	api/usuario	|	DELETE		| 	Elimina un usuario.		|

Esquema publicación:
``` javascript
{
    "_id": 
    "tag": 
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

## Nueva publicacón  (se debe añadir primero a moderados)

Solicitud [POST] /api/moderados

``` javascript
  {
    "tag": 
    "usuario": //id
    "sexo": 
    "mensaje":   
    }
``` 
respuesta
    
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



## Crear un nueva publicación

Solicitud [POST] /publiaciones

``` javascript
	{
    "tag": 
    "usuario": 
    "sexo": 
    "mensaje":    
    }
``` 
 Respuesta
    
``` javascript

	{
	"id": 
    "tag": 
    "sexo": 
    "mensaje": 
    "num_comentarios"
 	"votos_positivos":
    "votos_negativos"
	"comentarios": [
      //	id1,id2...
     ] 
``` 



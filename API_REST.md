

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

|Publicados |Moderar | Comentarios  | Usuarios |
|--------|--------| ---------|------- |
| Contiene los mensajes publicados. | Contiene los mensajes que están por moderar.   |  Contiene los comentarios de cada publicación. | Contiene información de los usuarios. |

##Esquemas

### Esquema publicar:

``` javascript
 {
    "_id":
    "tags": [
    ]
    "usuario": // id
    "sexo":  // Hombre o Mujer
    "fecha":  // new Date()
    "mensaje":
    "num_comentarios":
    "votos_positivos":   //cuando ambas votaciones lleguen a cierto número
    "votos_negativos"
    "comentarios": [
          id1, id2
     ]
     }
```
   Tags: 'Amor',  'Dinero', 'Estudios', 'Familia', 'Política', 'Tecnologia', 'Sexo', 'Trabajo', 'Televisión', 'Salud', 'Otros'

###Esquema moderar:

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
###Esquema Comentarios:

``` javascript
 {

     }

```
###Esquema Usuarios:

``` javascript
 {
     }

```




#Rutas

#### Publicados
| Ruta | Método |  Descripción|
|--------|--------|-------|
|     [v1/publicados]()  |     GET   |   Obtiene 10 publicaciones.   |
|	[v1/publicados]() **¿sobra?**|	POST| 	Añade una publicación.				|
|v1/publicados/p/:pag|GET|Obtiene las siguientes 10 publicaciones|
|v1/publicados/:id |DELETE|   Elimina una publicación de la colección de publicados.|

#### Moderar
| Ruta | Método |       Descripción|
|--------|--------|-------|
| [v1/moderar/:idUsuario](#[get]v1moderar/:idusuario) | GET  | Obtiene una publicación de la colección de moderados que no haya sido moderada ya por el usuario con el id enviado. |
|	[v1/moderar](#[post]v1moderar/)	|	POST| Añade una publicacion a la colección moderados.|
|[v1/moderar/:_idPost/:_idUsuario/:[aprobar/rechazar\]](#[put]v1/moderar/:_idpost/:_idusuario/:[aprobar/rechazar])| PUT | Actualiza los campos de votación |
| [v1/moderar/:id](#[delete]v1/moderar/:id) | DELETE | Elimina una publicación de la colección moderados|


#MODERAR

####[GET]v1moderar/:idUsuario

Envio:
``` javascript
//vacio
```

Respuesta: 
``` javascript
  {
    "_id": 
    "tag": 
    "usuario": // id
    "sexo":  
    "mensaje":
    "aprobado": 
    "rechazado":
    "usuarios_moderado": // [ id, ... ]
     }

```


####[POST]v1moderar/

Envio: 

``` javascript
  {
    "tags": ["Humor", "Sexo"],
    "usuario": "_id",  // usuario no registrado -> _id de la cookie de sesión.
    "sexo": "Hombre",
    "mensaje":  "Hay que acabar esto ya."
    }
```
Respuesta:
``` javascript
    {
       "_id": "afdb1ca2-8f69-436c-844e-eb7f924832e2",
       "tags":
       [
           "Humor",
           "Sexo"
       ],
       "usuario": "_id",
       "sexo": "Hombre",
       "mensaje": "Hay que acabar esto ya.",
       "aprobado": 0,
       "rechazado": 0,
       "usuarios_moderado":
       [
       ]
    }
```
####[PUT]v1/moderar/:_idPost/:_idUsuario/:[aprobar/rechazar]
Envio:
``` javascript
//vacio
```

Respuesta:
``` javascript
{
	"code": 400,
	"message": "No se ha encontrado el registro."
}

ó

{
	"code":200,
	"message":"El campo \"usuarios_moderado\", ha sido actualizado."
}


```
####[DELETE]v1/moderar/:id
Envio:
``` javascript
//vacio
```

Respuesta:
``` javascript

{
"code": 200,
"message": "La publicación: c29e9295-7055-4778-8e79-314934cf76b8 ha sido eliminada correctamente."
}

ó

{
"code":400,
"message":"No existe una publiación con ese id."
}

```

#### Comentarios
| Ruta | Método |  Descripción|
|--------|--------|-------|
|      v1/comentarios:_idPublicaión | GET   |   Obtiene todos los comentarios de una determinada publicación.   |



---
#### Usuarios
| Ruta | Método |  Descripción|
|--------|--------|-------|
|      v1/usuarios| GET   |   Obtiene todos los usuarios.   |
|	v1/usuarios/id |	GET | 	Obtiene un usuario por su id.	|
|	v1/usuarios	|		POST	| 	Añade un usuario.		|
|	v1/usuarios	|	DELETE		| 	Elimina un usuario.		|


---

#PUBLICAR


## Nueva publicacón
###Solicitud1
######[POST] /v1/moderar

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








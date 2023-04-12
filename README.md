
# Libreria Codeigniter para conectar API OCR

Extraer datos de una factura en formato JPG/PNG/PDF
a formato JSON.


## Installation

Copiar la carpeta del proyecto en el servidor PHP.
Instalar las dependencias

```bash
  cd /path/project
  composer install 
  
```
    
## API Reference

#### Set apiKey 

```route
  rootFolder/aplication/libraries/Extract_invoice.php
  Line 23
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `api_key` | `string` | **Required**. Your API key |

#### Set apiUrl

```http
  rootFolder/aplication/libraries/Extract_invoice.php
  Line 22
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `apiUrl`      | `string` | **Required**. url del api |

#### Create DB mysql


```http
  rootFolder/basededatos/facturasjson.sql
```
Import DB mysql facturasjson

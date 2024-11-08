# api-decampoacampo

API hecha en PHP Nativo.

## Levantar Proyecto

1. Clonar el repositorio.

2. Ejecutar el siguiente comando en la raiz del proyecto.


```bash

docker-compose up -d

------------------------------------
```

Para configurar la variable del Valor del DOLAR se debe ir al config/config.php
y cambiar el valor aqui:

define('PRECIO_USD', 1120);

# Endpoints

[GET] http://localhost:8000/productos - Obtener todos los productos

[GET] http://localhost:8000/productos/{id} - Obtener por ID

[POST] http://localhost:8000/productos/create - Crear  producto

[PUT] http://localhost:8000/productos/{id} - Actualizar producto

[DELETE] http://localhost:8000/productos/{id} - Eliminar producto
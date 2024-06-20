- Pasos para levantar el proyecto
- Conectar la base de datos al motor copian el .env-example y crear un .env
- Ejecutar el comando composer update para instalar las dependencias
- Ejecutar el comando php artisan migrate para migrar las tablas a la base de datos
- Ejecutar la apliacion con el comando php artisan serve

Hacer las peticiones desde el cliente ejemplo Postman
- Depositar dinero en el cajero con un metodo post al endpoint 
    http://127.0.0.1:8000/api/cashier 

{
    ""bills_1": 5,
    "bills_5": 10,
    "bills_10": 20,
    "bills_20": 5,
    "bills_50": 2,
    "bills_100": 1"
}

- Hacer un retiro hacer una peticion post al endpoint 
    http://127.0.0.1:8000/api/cashier/withdraw

{
    "amoint": 200
}

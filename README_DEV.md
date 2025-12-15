•	Instrucciones de configuración del proyecto:
    o	Instalar la tecnología definida en el diagrama previamente presentado, así como tenerlos en ejecución (Apache o Nginx).
        	Nota: En caso de no utilizar un servidor, se puede utilizar la consola del sistema operativo para iniciar el proyecto con el siguiente comando (posicionado sobre la ruta del proyecto {PATH_LOCAL}/CitasMedicas/public): 
            -	php artisan serve
        	En el PHP se recomienda remover el comentario de una extensión en el archivo php.ini llamado “;extension=sudium”.

    o	Al descargar el proyecto desde GitHub, posicionarse en la carpeta CitasMedicas y realizar lo siguiente: 
        	Configurar el archivo. env (posicionado en la raíz del proyecto) para realizar la configuración a la base de datos (DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSOWORD). Una vez se ingresen los valores de conexión, 
        
        	Ejecutar desde la línea de comandos lo siguiente:  
            -	php artisan migrate:fresh --seed
        Esto creara las tablas necesarias y algunos registros del core del proyecto.
        
        	Ejecutar desde la línea de comandos lo siguiente:  
            -	composer install
        Esto ejecutara e instalara todas las dependencias que utiliza el proyecto.
        
    o	Para visualizar el proyecto se deben posicionar sobre la ruta 
        -	{PATH_LOCAL}/CitasMedicas/public

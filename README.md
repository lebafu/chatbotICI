# chatbotICI
Modificando base de datos Botpress

1-Descargar carpeta del proyecto
2-Colocar carpeta de Botpress que se llamará botpress12120 dentro de carpeta Public,
el nombre public\botpress12120\data\bots en esta ruta colocar la carpeta ucm-botpress1
que contendrá nuestro chatbot
3-Ahora debemos crear en php admin la base de datos bd_botpress
4-Ejecutar el comando php artisan migrate
5-Ejecutar el comando php artisan db:seed para asi completar la base de datos de mysql
con la información del chatbo de botpress
6-Ejecutar php artisan serve
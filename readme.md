## OpenWallet - An OpenBadges solution!

Necesita :
[composer](https://getcomposer.org/)
[bower](http://bower.io/)


## Instalacion

Clona o 'forkea' este repo y ejecuta en tu terminal:

```

composer update
bower update

```

Copia el archivo `.env.local.php.sample` y renombralo a `.env.local.php`

Crea la base de datos y edita el archivo para que coincida con tu configuración y ejecuta:

Copia el archivo `bootstrap/environment.php.sample` y renombralo a `environment.php`

Edita el archivo cambiando `local` por el nombre del entorno que estes usando.



```

php artisan db:fireup


```

### Licencia

Creative Commons: [Reconocimiento-NoComercial-SinObraDerivada 4.0 Internacional](http://creativecommons.org/licenses/by-nc-nd/4.0/)
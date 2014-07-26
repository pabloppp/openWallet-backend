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

```

php artisan migrate:refresh
php artisan db:seed

```

### Licencia

Creative Commons: [Reconocimiento-NoComercial-SinObraDerivada 4.0 Internacional](http://creativecommons.org/licenses/by-nc-nd/4.0/)
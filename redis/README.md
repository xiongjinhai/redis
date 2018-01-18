
composer require dsweixin/redis

```php
    'providers' => [
        // ...
        Redis\PredisServiceProvider::class,
    ]
```

Find the `aliases` key in `config/app.php`.

```php
    'aliases' => [
        // ...
        'predis' => Redis\Facades\Predis::class,
    ]
```
```php
 Predis::set($key,$value);
```

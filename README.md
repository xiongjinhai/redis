
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
> laravel 5.5+ 版本不需要手动注册

```php
 Predis::set($key,$value);
```

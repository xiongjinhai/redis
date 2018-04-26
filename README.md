
composer require dsweixin/redis

```php

larave5.5版本以上可以不用添加下面操作

```

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

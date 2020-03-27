laravel-filters
=================
[![Laravel 6](https://img.shields.io/badge/Laravel-5-orange.svg?style=flat-square)](http://laravel.com)
[![License](http://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://tldrlegal.com/license/mit-license)

Пакет для работы с фильтрами в Laravel-6

  * Фильтры для магазинов и каталогов.
  * ЧПУ и GET параметры.
  * Кеширование.
  * Работают с дефолтными настройками.
  * Набор примеров кастомизации под частные задачи.


  
Установка
------------------
Установка пакета с помощью Composer.

```
composer require alvariumsoft/laravel-filters
```

Добавьте в файл `config/app.php` вашего проекта в конец массива `providers` :

```php
Alvarium\Filters\FiltersServiceProvider::class,
```


После этого выполните в консоли команду публикации нужных ресурсов:

```
php artisan vendor:publish --provider="Alvarium\Filters\FiltersServiceProvider"
```


Использование
-------------

В файле `config\filters.php` находится массив, в котором нужно указать классы сервисов. Например:
```php
'state' => \App\Alvarium\Filters\Services\Data\Defaults\DefaultState::class,
```

Классы для своих сервисов нужно создавать в папке `app\Alvarium`.

Класс сервиса должен иметь соответствующее пространство имен: `namespace App\Alvarium\Filters\Services\Data`. Так же класс сервиса должен включать соответствующий интерфейс и реализовывать его методы. 


Примеры
-------------

В публикуемых папках Defaults (App\Alvarium\Filters\Services\Data\Defaults) есть примеры всех сервисов по умолчанию. Для большинства случаев их будет достаточно.
Если же нужно изменить или дополнить функциональность, создаем по примерам свои сервисы и подключаем их в файле конфигурации.
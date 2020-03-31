laravel-filters
=================
[![Laravel 6](https://img.shields.io/badge/Laravel-6-orange.svg?style=flat-square)](http://laravel.com)
[![License](http://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://tldrlegal.com/license/mit-license)

Пакет для работы с фильтрами в Laravel-6

  * Фильтры для магазинов и каталогов.
  * ЧПУ и GET параметры.
  * Кеширование.
  * Работают с дефолтными настройками.
  * Набор примеров, которые можно переделать под частные задачи.


  
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


Принцип работы
-------------

Допустим мы имеем следующие таблицы и соответствующие им модели (приведены основные поля):

```
categories:
id
name
slug
category_id

products:
id
name
price
properties - json
category_id

properties:
id
name
type
sort

property_enums:
id
property_id
value
slug
sort
```

У нас есть маршрут фильтров для подкатегорий:

```php
Route::get('/catalog/{category}/{subcategory}/filter/{param1?}/{param2?}', 'CategoryController@subcategory')->name('subcategory');
```

Т.е. два первых параметра фильтров уйдут в сегменты, о стальные в GET параметры.

У нас есть action контроллера:

```php
    // Класс фильтров регистрируется в сервис контейнере в сервис провайдере, поэтому мы можем сделать инъекцию прямо в контроллере.
    public function subcategory(Filters $filters, Request $request, Category $category, Category $subcategory, ...$params)
    {
        $categories = Category::with('categories')->whereNull('category_id')->get();

        // Получаем менеджер фильтров, передаем параметры в сегментах, все GET-параметры, название маршрута, параметры не являющиеся фильтрами
        $filterManager = $filters->getManager($params, $request->all(), 'subcategory', [$category, $subcategory]);

        // Получаем массив фильтров
        $filters = $filterManager->getFilters();
        // Получаем массив выбрвнных фильтров
        $chosenFilters = $filterManager->getChosenFilters($filters);

        // Получаем ид отфильтрованных товаров
        $productIds = $filterManager->getProductIds(Product::where('category_id', $subcategory->id));

        $products = Product::with('category')->whereIn('id', $productIds)->paginate(10);

        return view('catalog', compact('categories', 'products', 'filters', 'chosenFilters'));
    }
```

Сервисы
-------------

В папку `app\Alvarium` публикуется структура папок сервисов и все сервисы по умолчанию, которые подойдут для большинства случаев. Вы можете по образу создать свои сервисы и переподключить их в файле `config\filters.php`.

```php
        'state' => \App\Alvarium\Filters\Services\Data\Defaults\DefaultState::class,
```

Сервис для запросов к базе и получения всех необработанных данных из базы. Реализован синглтон, чтобы не было повторных запросов и был доступ в любых других сервисах. Рекомендуется все запросы к базе выполнять только здесь, а потом обрабатывать их сервисами.

```php
        'raw_data' => \App\Alvarium\Filters\Services\Data\Defaults\DefaultRawData::class,
```

Сервис для обработки полученных данных из базы, вытягивания и группирования фильтров. Это самый трудоемкий участок, поэтому его результаты кешируются. Кеши нужно бужет сбрасывать при обновлении данных в базе самостоятельно. Время кеша определяется в файле конфигурации.

```php
        'receive_filter' => \App\Alvarium\Filters\Services\Filters\Defaults\DefaultReceiveFilter::class,
```

Сервис для генерации классов фильтров, классы также необходимо создать. Класссы фильтров отвечают за формирование конечных данных из сырых дфнных. Сервис отвечает за определение того объекты, какого класса создавать.

```php
        'filters_creator' => \App\Alvarium\Filters\Services\Filters\Defaults\DefaultFiltersCreator::class,
```

Сервис формирующий результирующий массив, здесь можно изменить его структуру. Массив формируется с помощью классов, описанных в предыдущем сервисе.

```php
        'links_creator' => \App\Alvarium\Filters\Services\Links\Defaults\DefaultLinksCreator::class,
```

Сервис для генерации ссылок.

```php
    'middleware' => [
        \App\Alvarium\Filters\Services\Middleware\Defaults\SortFilters::class,
    ],
```
В этом разделе файла конфигурации указываем классы middleware, которые выполнятся по порядку и произведут дополнительные операции над сформированными фильтрами. Они все должны реализовывать интерфейс `Alvarium\Filters\Middlewares\Middleware`. По умолчанию реализована сортировка фильтров.

```php
        'params_strategy' => \App\Alvarium\Filters\Services\Params\Defaults\DefaultParamsStrategy::class,
```

Сервис, который разбирает входящие параметры, также здесь можно определить какие будут в сегментах, какие в GET-параметрах.

```php
        'query_decorator' => \App\Alvarium\Filters\Services\Queries\Defaults\DefaultQueryDecorator::class,
```
Сервис, который декорирует все запросы по выбранным фильтрам, чтобы отфильтровать продукты. Также в этом неймспейсе определяем сами запросы.









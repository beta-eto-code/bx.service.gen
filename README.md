# Mock сервер для OpenApi

Данный модуль позволяет запустить mock сервер в соотвествии со схемой swagger 3 с использованием модуля bx.router.

Пример использования:

```php
use BX\Router\RestApplication;
use Bx\Service\Gen\YamlParser;


$app = new RestApplication();
$router = $app->getRouter();

$yamlPath = $_SERVER['DOCUMENT_ROOT'].'/swagger/swagger.yaml';  // путь к схеме swagger
$parser = new YamlParser($yamlPath);
$routes = $parser->getRoutes();
$routes->compile($router);  // загружаем прочитанные маршруты в наше приложение

$router->default(new DefaultController); // Контроллер по-умолчанию

$app->run();
```

###Модулем предусмотрено несколько колючей для обозначения типа данных в схеме swagger:

* type
* format 
* x-faker-type

###Возможные значения:

* integer - целое число, доступны дополнительные настройки:
    * x-faker-offset - начальное значение
    * x-faker-limit - предельное значение
    * x-faker-source - подгружает значение по указаному ключу из строки/тела запроса или из аргументов REST метода в текущее поле
* number - целое число, доступны дополнительные настройки:
    * x-faker-offset - начальное значение
    * x-faker-limit - предельное значение
    * x-faker-source - подгружает значение по указаному ключу из строки/тела запроса или из аргументов REST метода в текущее поле
* increment - целочисленный инкремент, доступны дополнительные настройки: 
  * x-faker-offset - начальное значение
  * x-faker-limit - предельное значение
  * x-faker-step-from - начальное значение шага инкремента
  * x-faker-step-to - предельное значение шага инкремента
  * x-faker-source - подгружает значение по указаному ключу из строки/тела запроса или из аргументов REST метода в текущее поле
* float - число с плавающей точкой
    * x-faker-source - подгружает значение по указаному ключу из строки/тела запроса или из аргументов REST метода в текущее поле
* double - число с плавающей точкой
    * x-faker-source - подгружает значение по указаному ключу из строки/тела запроса или из аргументов REST метода в текущее поле
* boolean
    * x-faker-source - подгружает значение по указаному ключу из строки/тела запроса или из аргументов REST метода в текущее поле
* date - дата в формате ISO 8601, доступны дополнительные настройки:
    * x-faker-offset - начальное значение, например: -30 years (https://github.com/fzaninotto/Faker#fakerproviderdatetime)
    * x-faker-limit - предельное значение, например: now (https://github.com/fzaninotto/Faker#fakerproviderdatetime)
    * x-faker-source - подгружает значение по указаному ключу из строки/тела запроса или из аргументов REST метода в текущее поле
* date-time дата в формате Y-d-m, доступны дополнительные настройки:
    * x-faker-offset - начальное значение, например: -30 years (https://github.com/fzaninotto/Faker#fakerproviderdatetime)
    * x-faker-limit - предельное значение, например: now (https://github.com/fzaninotto/Faker#fakerproviderdatetime)
    * x-faker-source - подгружает значение по указаному ключу из строки/тела запроса или из аргументов REST метода в текущее поле
* enum - список значений
    * x-faker-source - подгружает значение по указаному ключу из строки/тела запроса или из аргументов REST метода в текущее поле
* file - отбражеет путь к файлу от директории /tmp/fake
    * x-faker-source - подгружает значение по указаному ключу из строки/тела запроса или из аргументов REST метода в текущее поле
* image - url изображению-заглушке
    * x-faker-source - подгружает значение по указаному ключу из строки/тела запроса или из аргументов REST метода в текущее поле
* email - случайный email
    * x-faker-source - подгружает значение по указаному ключу из строки/тела запроса или из аргументов REST метода в текущее поле
* phone - случайный номер телефона
    * x-faker-source - подгружает значение по указаному ключу из строки/тела запроса или из аргументов REST метода в текущее поле
* first-name - случайное имя
    * x-faker-source - подгружает значение по указаному ключу из строки/тела запроса или из аргументов REST метода в текущее поле
* last-name - случайная фамилия
    * x-faker-source - подгружает значение по указаному ключу из строки/тела запроса или из аргументов REST метода в текущее поле
* full-name - имя и фамилия
    * x-faker-source - подгружает значение по указаному ключу из строки/тела запроса или из аргументов REST метода в текущее поле
* array - массив значений
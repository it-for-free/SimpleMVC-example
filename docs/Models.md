
# Модели. SimpleMVC


Модели служат для работы с базой данных, в SMVC именно к моделям обращаются [контроллеры](Controllers.md), чтобы извлечь данные из СУБД.

## Создание пользовательской модели

Любая модель внутри Приложения:

* должна наследовать [базовый класс модели](https://github.com/it-for-free/SimpleMVC/blob/master/src/mvc/Model.php)  `\ItForFree\SimpleMVC\MVC\Model` из пакета Ядра.
* может определить имя используемой таблицы, переопределяя свойство `$tableName` родительского класса

-- после этого можно использовать методы уже определенные в базовом классе

## Базовый класс \ItForFree\SimpleMVC\MVC\Model

Класс \ItForFree\SimpleMVC\MVC\Model реализует следующие методы, которые становятся доступны классу-потомку сразу же после наследования базового класса (+ для корректной работы надо переопределить имя таблицы):

* `getById()` -- получение сущности с конкретным id
* `getList()` -- получение списка сущностей
* `getPage()` -- получение части списка (для пейджинации)
* `loadFromArray()` -- создание объекта модели на основе данных из массива
* `delete()` -- удаление из БД кортежа, соответствующего текущему объекту модели

Подробнее см. [исходный код \ItForFree\SimpleMVC\MVC\Model](https://github.com/it-for-free/SimpleMVC/blob/master/src/mvc/Model.php).

Если какой-то из перечисленных методов работает не так как вас надо (скажем в ситуации, когда родительский `getList()` выбирает данные только из основной таблицы сущности, а вам надо чтобы он выполнял ещё и `JOIN` с другими таблицами), то в качестве решения вы всегда можете _переопределить_ нужный метод в классе-потомке (в вашей модели), написав там свой код. 

Если нужного вам метода в базовой модели нет, то его всегда можно реализовать в классе-потомке.
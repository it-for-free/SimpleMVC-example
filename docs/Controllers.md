
# Контроллеры. SimpleMVC


Как уже было [сказано ранее](Start.md), SMCV реализует концепцию MVC.

Что это означает на практике? Обычно то, что запрос пользователя (каким бы он ни был) _всегда_ обрабатывается действием какого-то контроллера -- т.е. вызывается код, написанный в контроллере и уже код этого контроллера "решает", что делать дальше.

 При этом, опять же, на практике в SMVC справедливы следующие утверждения:
 * **Контроллер** - это _класс_, унаследованный от родительского класса контроллера  `\ItForFree\SimpleMVC\MVC\Controller` из Ядра _(см. [раздел о разделении универсальной и частной логики в SMVC](Start.md))_.
 * **Действие контроллера** (action, "экшн") -- _метод класса_ контроллера, отвечающий за какую-то конкретную задачу. Например, за получение списка статей (из СУБД или как-то ещё), или за вывод формы редактирования пользователя и обработку запроса, приходящего в результате отправки этой формы пользователем.

## Когда выполняется код контроллера

Код контроллера выполняется Ядром системы, когда она "понимает", что запрос пользователя соответствует маршруту, за который отвечает данный контроллер.

 Подробнее об этом и том как сделать, чтобы контролллер выполнился, читайте [в разделе "Маршрутизация"](Routing.md).

##  Базовый класс контроллера \ItForFree\SimpleMVC\MVC\Controller

Базовый класс контроллера  ([см. исходный код](https://github.com/it-for-free/SimpleMVC/blob/master/src/mvc/Controller.php#L1)), определяет следующие основные свойства:
* свойство `$view` -- тут хранится экземпляр класса `ItForFree\SimpleMVC\MVC\View`, который позволяет работать с представлениями (подробнее см. [раздел Представления](Views.md)), это свойство устанавливается прямо в конструкторе базового класса контроллера:
```php
public function __construct() {
    $this->view = new View($this->layoutPath);
}
```
* свойство `$layoutPath` -- тут хранится путь к _макету_ данного контроллера. Кратко уточним, что именно это свойство задает путь к коду, который определяется общие части верстки страниц (см. подробности в разделе ["Макеты представлений"](Layouts.md)).


-- по сути это два самых главных атрибута базового класса контроллера, именно они позволяют [пользовательским](http://fkn.ktu10.com/?q=node/11132) контроллерам, работать с Представлениями, передавая туда переменные и в принципе вызывая отображения Представлений (подробности см. в разделе ["Представления"](Views.md)).

Также в базовом классе контроллера имеется метод редиректа:
```php
public function redirect($path) { // 302 редирект
        header("Location: $path");
    }
}
```
-- это метод _не играет_ какой-то существенной роли в архитектуре, но вынесен в родительский класс для удобства, чтобы его можно было просто унаследовать контроллерах потомках и использовать, в случае необходимости.

## Пример пользовательского контроллера

В качестве примера возьмем класс контроллера домашней страницы `HomepageController` ([исх. код](https://github.com/it-for-free/SimpleMVC-example/blob/master/application/controllers/HomepageController.php#L1))):

```php
<?php

namespace application\controllers;

/**
 * Контроллер для домашней страницы
 */
class HomepageController extends \ItForFree\SimpleMVC\MVC\Controller
{
    /**
     * @var string Название страницы
     */
    public $homepageTitle = "Домашняя страница";
    
    /**
     * @var string Пусть к файлу макета 
     */
    public $layoutPath = 'main.php';
      
    /**
     * Выводит на экран страницу "Домашняя страница"
     */
    public function indexAction()
    {
        $this->view->addVar('homepageTitle', $this->homepageTitle); // передаём переменную по view
        $this->view->render('homepage/index.php');
    }
}
```

-- у этого контроллера:
* есть единственное _действие_ `indexAction()`,  в коде выше оно отвечает за вывод домашней страницы (при этом вообще у контроллера действий может быть много, один контроллер группирует действия связанные какой-то общей темой или назначением в системе).
* свойство класса `$homepageTitle` служит просто для удобного хранения данных (т.е. это свойство можно назвать пользовательским, наследуя базовый класс котроллера, вы можете также добавлять свои новые свойства, если требуются, но учитывайте, что у контроллера есть и специальные свойста, на которые опирается Ядро системы).
* свойство `$layoutPath` задает конкретное имя _макета_ (или путь к нему), который нужно использовать для представлений данного контроллера (см. подробности в разделе ["Макеты представлений"](Layouts.md)). 

## Что ещё почитать по контроллерам

* Проектирование контроллеров (сколько, как много их нужно создавать): http://fkn.ktu10.com/?q=node/10717

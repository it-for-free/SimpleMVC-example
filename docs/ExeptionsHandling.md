# Обработка ошибок

В ходе использования приложении SimpleMVC могут возникать различные ошибки и в 
этом случае будут сгенерированы исключения, в их числе:

* Ошибки маршрутизации
* Ошибки доступа
* Ошибки конфигурации
* Ошибки использования

В методе run()  класса Application код обработки запроса обёрнут в блок 
try/catch

```php
// \ItForFree\SimpleMVC\Application.php
...
   public function run() {
        
        $exceptionHandler = new ExceptionHandler();
        try{
            if (!empty($this->config)) {
                $route = $this->getConfigObject('core.router.class')::getRoute();
                /**
                 * @var ItForFree\SimpleMVC\Router\WebRouter
                 */
                $Router = $this->getConfigObject('core.router.class');

                $Router->callControllerAction($route);

            } else {
                throw new SmvcCoreException('Не задан конфигурационный массив приложения!');
            }


            return $this;
        
        } catch (Exception $exc) {
            $exceptionHandler->handleException($exc);
        }
    }
...
```

В случае возникновения ошибки результат будет передан в специальный обработчик 
который перехватывает все возникающие исключения и либо  передает 
пользовательскому обработчику описанному в конфигурации, либо  если не находит 
подходящий обработчик пробрасывает дальше. 

В пользовательском коде демонстрационного приложения создан пример  обработчика 
который реализует интерфейс ExceptionHandlerInterface и служит для обработки 
ошибок маршрутизации и доступа.



## Создаём собственный обработчик

При необходимости, можно создать собственный обработчик. В качестве примера 
создадим обработчик для обработки ошибки доступа.
В папке `application/hadlers` создадим файл где опишем наш обработчик

```php
// \application\hadlers\MyExceptionHandler.php
<?php
namespace application\handlers;

use ItForFree\SimpleMVC\Config;
use ItForFree\SimpleMVC\Interfaces\ExceptionHandlerInterface;

class MyExceptionHandler implements ExceptionHandlerInterface
{
    public function handleException(Exception $exception)
    {
        
    }
}
``` 

Стоит заметить что обработчик должен реализовывать интерфейс 
ExceptionHandlerInterface входящий в ядро фреймворка. Так же нужно 
зарегистрировать его в файле конфигурации, в секции `handlers`

```php
// \application\config\web.php
...
'handlers' => [
            'ItForFree\SimpleMVC\Exceptions\SmvcAccessException' => \application\handlers\MyExceptionHandler::class
        ]
```
В методе `handleException` мы должны описать поведение обработки.

## Настраиваем отображения ошибок

Для отображения ошибки можно воспользоваться уже имеющимся контроллером либо 
создать свой. Имеющийся контроллервыводит страницу ошибки с большим количеством 
информации по отладке, чтобы помочь быстро обнаружить проблему. Для того чтобы 
предотвратить возможность воспользоваться ею на production этапе, можно 
отключить её показ в файле `application/views/error.php`

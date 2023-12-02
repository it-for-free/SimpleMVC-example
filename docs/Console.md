
# Консольное приложение. SimpleMVC

SimpleMVC позволяет создать много приложений, для каждого из которых создаётся отдельная точка входа, и независимо их сконфигурировать.
Рассмотрим, как реализовано консольное приложение.

## Схема работы Консольного Приложения

У Консольного Приложения есть отдельная "**точка входа**" [console.php](https://github.com/it-for-free/SimpleMVC-example/blob/master/console.php).
Она работает она работает точно таким же образом, как и [Ядро](Routing.md#схема-работы-приложения) Приложения, но получает собственную конфигурацию.
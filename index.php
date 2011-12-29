<?php
require_once('config.php');
require_once('language/language.php');
require_once('controller/controller_manager.php');
$conf = new Configuration();
if ($conf->getInt('installed',0))
{
    $db = mysql_connect($conf->getConf('host',''),$conf->getConf('login',''),$conf->getConf('password',''));
    if ($db) {
        mysql_select_db($conf->getConf('database',''), $db);
        $lang = new Language($conf);
        $controller = new MainConroller($conf,$lang,$db);
        $http_code = $controller->exec();
        // TODO: Необходимо написать класс для статусов HTTP.
        $http_code = 404;
        //header("HTTP/1.0 404 Not Found");
        mysql_close($db);
    } else {
        // TODO: Произошла ошибка. Отправка сообщения администратору.
    }
} else {
    // TODO: Производим установку скриптов. Создание БД итп.
}
?>
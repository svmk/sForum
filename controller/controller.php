<?php
require_once('config.php');
require_once('language/language.php');
class Controller
{
    var $controllers = array('auth'=>array('index'=>'showLoginForm','logout'=>'logout','login'=>'login','controller'=>'Auth'));
    // array('controller' => array('task1name'=>'task1','task2name'=>'task2','task3name'=>'task3','controller'=>'controller_name'))
    var $lang = NULL;
    var $conf = NULL;
    var $db   = NULL;
    var $controller = 'Index';
    var $task = 'index';
    var $view_controller = 'Index';
    var $view = 'index';
    var $http_status = 200;
    var $title = '';
    var $stylesheets = array();
    var $task_char = 'v';
    var $controller_char = 'c';
    var $have_render = false;
    public function setHttpStatus($http_status,$info = '')
    {
        switch ($http_status)
        {
            case 200:
                header("HTTP/1.1 200 OK");
                break;
            case 301:
                header('HTTP/1.1 301 Moved Permanently');
                header('Location: '.$info);
                break;
            case 302:
                header('HTTP/1.1 303 Found');
                header('Location: '.$info);
                break;
            case 404:
                header('HTTP/1.1 404 Not Found');
                break;
        }
        // TODO: switch case 404:.. case 200: header('200 bla bla... etc')
    }
    function render($view_controller,$view)
    {
        $this->view_controller = $view_controller;
        $this->view = $view;
        $this->have_render = true;
    }
    function route($controller,$task)
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH).'?'.$this->controller_char.'='.$controller.'&'.
            $this->task_char.'='.$task;
    }
    function initRequest()
    {
        $task_char = $this->task_char;
        $controller_char = $this->controller_char;
        if (array_key_exists($controller_char,$_REQUEST))
        {
            if (array_key_exists($_REQUEST[$controller_char],$this->controllers))
            {
                $controller = $_REQUEST[$controller_char];
                $this->controller = $this->controllers[$controller]['controller'];
                if (array_key_exists($task_char,$_REQUEST))
                {
                    if (array_key_exists($_REQUEST[$task_char],$this->controllers[$controller]))
                    {
                        $this->task = $this->controllers[$controller][$_REQUEST[$task_char]];
                    } else {
                        if ($_REQUEST[$task_char])
                        {
                            $this->http_status = 404;
                            $this->render('system','404');
                        } else {
                            $this->task = $this->controllers[$controller]['index'];
                        }
                    }
                } else {
                    $this->task = $this->controllers[$controller]['index'];
                }
            } else {
                if ($_REQUEST[$controller_char])
                {
                    $this->http_status = 404;
                    $this->render('system','404');
                }
            }
        }
    }
    public function renderView($controller_result)
    {
        require_once('view/'.strtolower($this->view_controller).'/'.strtolower($this->view).'.php');
        $proc = 'view_'.$this->view_controller.'_'.$this->view;
        $proc($controller_result);
    }
    function __construct(Configuration $conf,Language $lang,$db)
    {
        $this->conf = $conf;
        $this->lang = $lang;
        $this->db   = $db;
    }
}
?>
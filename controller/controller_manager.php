<?php
require_once('controller/controller.php');
class MainConroller extends Controller
{
    public function exec()
    {
        session_start();
        $this->initRequest();
        $controller_name = $this->controller;
        $task = $this->task;
        require_once('controller/'.strtolower($controller_name).'.php');
        $controller_name = $controller_name.'Controller';
        $controller = new $controller_name($this->conf,$this->lang,$this->db);
        $controller_result = $controller->$task();
        if ($controller->have_render)
        {
            $this->http_status = $controller->http_status;
            $this->render('main','index');
            $view_result = new stdClass();
            $view_result->controller = $controller;
            $view_result->controller_result = $controller_result;
            $this->renderView($view_result);
        }
    }
}
?>
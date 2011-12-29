<?php
function view_auth_logout($result)
{
    $controller = $result->controller;
    $lang = $controller->lang;
    $csrf = htmlspecialchars($result->csrf);
    echo '<a href="'.$controller->route('auth','logout').'">'.$lang->getTrans('AUTH_LOGOUT').'</a>';
    }
?>
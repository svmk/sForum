<?php
function view_main_index($view_result)
{
    $controller = $view_result->controller;
    $result = $view_result->controller_result;
    $lang = $controller->lang;
    $view = $controller->view;
    $view_controller = $controller->view_controller;
    $title = htmlspecialchars($controller->title);
    $baselink = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH).'stylesheets/';
?><!DOCTYPE html>
<html>
<head><?php if ($title) { ?>
    <title><?php echo $title;?></title>
<?php } ?>
    <meta content='text/html; charset=utf-8' http-equiv='Content-Type' />
    <link href="<?php echo $baselink;?>style.css" media="screen" rel="stylesheet" type="text/css" /><?php
    foreach ($controller->stylesheets as $link)
    {
echo '        <link href="'.$baselink.$link.'" media="screen" rel="stylesheet" type="text/css" />';
    }
?></head>
<body>
<header id="main_header"></header>
<nav id="main_nav">
    <ul>
        <li><a href="<?php echo $controller->route('Auth','index');?>"><?php echo $lang->getTrans('MAIN_PG_MENU_AUTH');?></a></li>
    </ul>
</nav>
<section id="main_section"><?php $controller->renderView($result);?></section>
</body>
</html><?
}
?>
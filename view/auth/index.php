<?php
function view_auth_index($result)
{
    $controller = $result->controller;
    $lang = $controller->lang;
    $login = htmlspecialchars($result->login);
    $csrf = htmlspecialchars($result->csrf);
    $ret = htmlspecialchars($result->ret);
    $error = $result->error;
    ?>
    <?php if ($error) { ?>
    <div id="auth_error">Error</div>
    <?php } else { ?>
    <div id="auth_empty"></div>
    <?php } ?>
    <form action="<?php echo $controller->route('auth','login');?>" id="auth_form" method="POST">
        <p>
            <label for="auth_login"><?php echo $lang->getTrans('AUTH_LOGIN');?></label>
            <input id="auth_login" name="auth_login" type="text" value="<?php echo $login;?>"/>
        </p>
        <p>
            <label for="auth_password"><?php echo $lang->getTrans('AUTH_PASSWORD');?></label>
            <input id="auth_password" name="auth_password" type="password" value="" />
        </p>
            <input type="submit" id="auth_submit" value="<?php echo $lang->getTrans('AUTH_SEND');?>" />
            <input type="hidden" name="csrf" value="<?php echo $csrf;?>"/>
            <input type="hidden" name="ret" value="<?php echo $ret;?>"/>
    </form>

<?}
?>
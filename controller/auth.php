<?php
require_once('model/csrf.php');
require_once('model/auth.php');
class AuthController extends Controller
{
    public function showLoginForm($error = false)
    {
        $csrf = new CsrfModel();
        $result = new stdClass();
        $result->controller = $this;
        $result->csrf = $csrf->getCsrf();
        if (isset($_SESSION['user_id']) && ($_SESSION['user_id'] > 0))
        {
            $this->render('Auth','logout');
            return $result;
        } else {
            $this->render('Auth','index');
            $result->login = '';
            $result->ret = '';
            $result->error = $error;
            if (isset($_GET['ret']))
            {
                $result->ret = $_GET['ret'];
            }
            if ($error)
            {
                $result->login = $_POST['auth_login'];
            }
            $this->setHttpStatus(200);
            return $result;
        }
    }
    public function getRetPath()
    {
        $ret = '';
        if (isset($_GET['ret']))
        {
            $ret = str_replace(array("\r","\n",'%0A','%0D','%0a','%0d'),'',urldecode($_GET['ret']));
            // NO CSRF
            $ret = parse_url($ret,PHP_URL_PATH).'?'.parse_url($ret,PHP_URL_QUERY);
        }
        if (!$ret)
        {
            $ret = parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
        }
        return $ret;
    }
    public function login()
    {
        $login = '';
        $password = '';
        if (isset($_POST['auth_login']))
        {
            $login = $_POST['auth_login'];
        }
        if (isset($_POST['auth_password']))
        {
            $password = $_POST['auth_password'];
        }
        $auth = new AuthModel($this->db);
        if ($auth->authorizeLogin($login,$password))
        {
            $_SESSION['user_id'] = $auth->id;
            $_SESSION['group_id'] = $auth->group_id;
            $ret = $this->getRetPath();
            $this->setHttpStatus(302,$ret);
        } else {
            return $this->showLoginForm(true);
        }
    }
    public function logout()
    {
        session_unset();
        $this->setHttpStatus(302,$this->getRetPath());
    }
}
?>
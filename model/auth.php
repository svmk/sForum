<?php
class AuthModel{
    var $db = NULL;
    var $id = 0;
    var $group_id = 0;
    function authorizeLogin($login,$password)
    {
        $login_e = mysql_real_escape_string($login);
        $password_e = mysql_real_escape_string($password);
        $res = mysql_query("SELECT `id`,`group_id` FROM `users` WHERE `login` = '${login_e}' AND `password` = PASSWORD('${password_e}') LIMIT 1;",$this->db);
        $user = mysql_fetch_object($res);
        if ($user)
        {
            $this->id = $user->id;
            $this->group_id = $user->group_id;
            return true;
        } else {
            return false;
        }
    }
    function __construct($db)
    {
        $this->db = $db;
    }
}
?>
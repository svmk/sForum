<?php
    class CsrfModel {
        function getCsrf()
        {
            if (!isset($_SESSION['CSRF']))
            {
                $_SESSION['CSRF'] = array();
            }
            if (isset($_SESSION['CSRF']))
            {
                $rand_int = rand(1,100000000000000);
                $md5sum = md5($rand_int);
                $_SESSION['CSRF'][$md5sum] = time() + 24 * 60 * 60;
                return $md5sum;
            }
            return '';
        }
        function validateCsrf($csrf)
        {
            if (!isset($_SESSION['CSRF']))
            {
                $_SESSION['CSRF'] = array();
                return false;
            } else {
                if (isset($_SESSION['CSRF'][$csrf]))
                {
                    unset($_SESSION['CSRF'][$csrf]);
                    $time = time();
                    foreach ($_SESSION['CSRF'] as $csrf_id=>$last_time)
                    {
                        if ($last_time>$time)
                        {
                            unset($_SESSION['CSRF'][$csrf_id]);
                        }
                    }
                    return true;
                }
            }
            return false;
        }
    }
?>
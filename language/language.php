<?php
require_once('config.php');
class Language{
    /* var $languages = array(); */
    var $default_language = '';
    var $use_def_lang = 1;
    var $translation = array();
    function loadTranslation($language)
    {
        if (file_exists('language/languages/'.$language.'.ini'))
        {
            $this->translation[$language] = parse_ini_file('language/languages/'.$language.'.ini');
        } else {
            $language = 'en';
            if (file_exists('language/languages/'.$language.'.ini'))
            {
                $this->translation[$language] = parse_ini_file('language/languages/'.$language.'.ini');
            } else {
                // TODO: Сообщаем администратору.
                die('does\'t exits');
            }
        }
    }
    public function getTrans($key,$language = '')
    {
        if (!$language)
        {
            $language = $this->default_language;
        }
        if (!isset($this->translation[$language]))
        {
            $this->loadTranslation($language);
            if (!isset($this->translation[$language]))
            {
                $language = 'en';
                $this->loadTranslation($language);
            }
        }
        if (array_key_exists($key,$this->translation[$language]))
        {
            return htmlspecialchars($this->translation[$language][$key]);
        } else return 'NOT-IMPLEMENTED-'.$key.'-'.$language;
    }
    function __construct(Configuration $conf)
    {
        $this->default_language = $conf->getConf('default_language');
        $this->loadTranslation($this->default_language);
    }
}
?>
<?php
class Configuration {
    var $ini_array = array();
    public function getConf($key,$default_value = '')
    {
        if ($this->ini_array!==FALSE)
        {
            if (array_key_exists($key,$this->ini_array))
            {
                return $this->ini_array[$key];
            } else {
                return $default_value;
            }
        } else {
            return $default_value;
        }
    }
    public function getInt($key,$default_value='')
    {
        return intval($this->getConf($key,$default_value));
    }
    function __construct()
    {
        $this->ini_array = parse_ini_file('conf.ini');
    }
}
?>
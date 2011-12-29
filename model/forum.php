<?php
class ForumModel{
    var $db = NULL;
    function forums($limit_begin=0,$limit_end=0)
    {
        $query = "SELECT `id`,`title` FROM `forums`";
        if ($limit_begin || $limit_end)
        {
            $query.= ' LIMIT ';
        }
        if ($limit_begin)
        {
            $query.=$limit_begin;
        }
        if ($limit_end)
        {
            $query.=$limit_end;
        }
        $query = $query.';';
        $res = mysql_query($query,$this->db);
        $result = array();
        if ($res)
        {
            while ($row = mysql_fetch_object($res))
            {
                $result[] = $row;
            }
        }
        return $result;
    }
    function __construct($db)
    {
        $this->db = $db;
    }
}
?>
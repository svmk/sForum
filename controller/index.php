<?php
require_once('model/forum.php');
class IndexController extends Controller
{
    public function index()
    {
        $forum = new ForumModel($this->db);
        $forums = $forum->forums();
        $this->render('Index','index');
        return $forums;
    }
}
?>
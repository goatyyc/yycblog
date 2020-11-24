<?php
require_once 'Base.php';
class Token extends Base{
    public function __construct()
    {
        session_start();
        if(empty($_SESSION['id'])){
            $this->jsonReturn(0,'未登录');
        }
    }

    public function index(){

    }
}
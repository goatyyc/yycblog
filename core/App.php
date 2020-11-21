<?php
require_once 'FrameWork.php';
require_once 'Db.php';
$result = FrameWork::init();

//加载和实例化控制器
$controller = $result['controller'];
$action = $result['action'];

//加载控制器
//1、判断接口是否存在
$result = file_exists('./app/Controller/'.$controller.'.php');
if(!$result){
    die("控制器不存在");
}
require_once './app/Controller/'.$controller.'.php';
//实例化
$class = new $controller;
$class->$action();

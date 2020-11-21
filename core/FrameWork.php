<?php
class FrameWork{
    public static function init()
    {
        //解析路由
        $uri = $_SERVER['REQUEST_URI'];
        $script_name = $_SERVER['SCRIPT_NAME'];
        $request = str_replace($script_name,'',$uri);
        $request = ltrim($request,'/');

        $request_array = explode('?',$request);
        $controller_action_array = explode('/',$request_array[0]);

        //当没有控制器的时候,指向默认控制器
        if(count($controller_action_array)>=2){
            $controller = $controller_action_array[0];
            $action = $controller_action_array[1];
        }else{
            //读取配置文件
            require_once './config/config.php';

            $controller = $config['default_controller'];
            $action = $config['default_action'];

        }

        return array('controller'=>$controller,'action'=>$action);
        //echo "<pre>";
        //var_dump($controller_action);
    }

}


//dump打印
function dump($data){
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

//get获取并返回
function get($params = false){
    if(!$params){
        return $_GET ? $_GET : false;
    }
    return isset($_GET[$params]) ? $_GET[$params] : false;
}

//post获取并返回
function post($params = false){
    if(!$params){
        return $_POST ? $_POST : false;
    }
    return $_POST[$params] ? $_POST[$params] : false;
}

//获取json数据并返回
function get_json(){
    $data = json_decode(file_get_contents('php://input'),true);
    return $data;
}

//获取文件并返回
function get_file($params = false){
    if(!$params){
        return $_FILES ? $_FILES : false;
    }
    return $_FILES[$params] ? $_FILES[$params] : false;
}
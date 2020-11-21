<?php
defined('BASEPATH') or exit("access denied");
class Base{
    //封装返回json数据
    function jsonReturn($code = 1,$msg='',$data = null)
    {
        $Result['code'] = $code;
        $Result['msg'] = $msg ? $msg : '';
        if ($data !== null) $Result['data'] = $data;
        if (($Result = json_encode($Result, JSON_UNESCAPED_UNICODE)) === false) {
            switch (json_last_error()) {
                case JSON_ERROR_NONE:
                    exit('JSON_ERROR_NONE');
                case JSON_ERROR_DEPTH:
                    exit('JSON_ERROR_DEPTH');
                case JSON_ERROR_STATE_MISMATCH:
                    exit('JSON_ERROR_STATE_MISMATCH');
                case JSON_ERROR_CTRL_CHAR:
                    exit('JSON_ERROR_CTRL_CHAR');
                case JSON_ERROR_SYNTAX:
                    exit('JSON_ERROR_SYNTAX');
                case JSON_ERROR_UTF8:
                    exit('JSON_ERROR_UTF8');
                case JSON_ERROR_RECURSION:
                    exit('JSON_ERROR_RECURSION');
                case JSON_ERROR_INF_OR_NAN:
                    exit('JSON_ERROR_INF_OR_NAN');
                case JSON_ERROR_UNSUPPORTED_TYPE:
                    exit('JSON_ERROR_UNSUPPORTED_TYPE');
                case JSON_ERROR_INVALID_PROPERTY_NAME:
                    exit('JSON_ERROR_INVALID_PROPERTY_NAME');
                case JSON_ERROR_UTF16:
                    exit('JSON_ERROR_UTF16');
                default:
                    exit('JSON_ERROR_UNKNOWN');
            }
        }
        // 返回JSON数据格式到客户端 包含状态信息
        header('Content-Type:application/json; charset=utf-8');
        exit($Result);
    }

    public function upload_file($file){
        //文件校验
        //文件上传
        if(!empty($file)){
            $fileName = $file['file']['name'];
            $time = time();
            $path = 'public/upload/'.$time.'_'.$fileName;
            if(move_uploaded_file($file['file']['tmp_name'], $path)){
                return $path;
            }else{
                return false;
            }
        }
    }
}

//获取排列后的标签列表
function getTree($arr,$pid=0,$level=0){
    //根据每条数据的id值，根据每条数据的id值去寻找所有pid==自己id值的数据，直到找不到为止
    static $list = [];
    foreach($arr as $key => $value){
        if($value["pid"] == $pid){
            $value["level"] = $level;
            $list[] = $value;       //level字段是为了展示的时候，如果需要缩进，可以有个依据
            unset($arr[$key]);      //删除已经排好的数据为了减少遍历的次数
            getTree($arr,$value["id"],$level+1);
        }
    }

    return $list;
}
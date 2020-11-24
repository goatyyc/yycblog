<?php
require_once 'Base.php';
require_once './core/Db.php';
class User extends Base {
    public function login()
    {
        session_start();
        $pwd = post('pwd');

        //获取管理员密码
        $admin = Db::item('admin','');
        if($pwd == $admin['pwd']){
            $_SESSION['id'] = $admin['id'];
            $this->jsonReturn(1,'登录成功');
        }else{
            $this->jsonReturn(0,'密码错误');
        }
    }
}
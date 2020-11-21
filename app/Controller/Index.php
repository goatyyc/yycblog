<?php
defined('BASEPATH') or exit("access denied");
require_once 'Base.php';
require_once './core/SysDb.php';
class Index extends Base {
    public function page()
    {
        echo "这是首页";
    }

    public function data()
    {

    }

    public function db()
    {
//        $res = Db::db_connect();
//        $rows = Db::execute("SELECT * FROM admin");
//        dump($rows);

//        $where = [];
//        $where['id>2'] = null;
//        $where['admin'] = 'admin';
//        $res = Db::item("admin",$where);
//        $res = Db::lists("admin",$where,'id desc');
//        dump($res);


//        $where['id>0'] = null;
//        $res = Db::cate('admin',$where,'id','');
//        dump($res);
//        echo "<hr>";
//        dump($group_list);

        //记录总数
//        $where['id>0'] = null;
//        $num = Db::total('admin',$where);
//        dump($num);
        //分页
//        $res = Db::pagination('admin','',1,3);
//        dump($res);

        //添加数据
//        $data['admin'] = 'yoo';
//        $data['pwd'] = '1234';
//        $data['age'] = 20;
//        $res = Db::insert('admin',$data);

        //链式操作
//        $db = new SysDb();
//        $res = $db->table(  'admin')->where(array('id'=>1))->item();
//        $res = $db->table('admin')->item();
//        $db2 = new SysDb();
//        $res = $db2->table('admin')->item();

        //更新操作
//        $data['admin'] = 'yang';
//        $where['id=4'] = null;
//        $res = Db::update('admin',$data,$where);
//        dump($res);

        //删除操作
//        $where['id'] = 3;
//        $res = Db::delete('admin',$where);
//        dump($res);
    }
}
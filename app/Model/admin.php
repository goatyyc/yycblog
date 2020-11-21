<?php
require_once './core/Db.php';
class admin{
    private $table = __CLASS__;



    //登录
    public function login($admin_data)
    {
        $data['id'] = 1;
        $res = Db::item('admin',$data);
        //检验密码
        if($admin_data['pwd'] != $res['pwd']){
            return false;
        }
        //保存登录状态
        $_SESSION['id'] = $data['id'];
        return true;
    }

    //添加文章
    public function add_article($article_data,$path)
    {
        $data = ['title'=>$article_data['title'],'path'=>$path,'label'=>$article_data['label']];
        $insert_id = Db::insert('article',$data);
        if(!$insert_id){
            return false;
        }
        return $insert_id;
    }
    //修改文章
    //删除文章
    //查询文章
    public function query_article()
    {

    }

    //所有文章
    public function all_articles()
    {
        $lists = Db::lists('article','');
        return $lists;
    }

    //分页查询文章
    public function get_article($page)
    {
        $lists = Db::pagination('article','',$page,6);
        return $lists;
    }

    //添加标签
    public function add_label($data)
    {
        $res = Db::insert('label',$data);
        return $res;
    }

}
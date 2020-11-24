<?php
require_once './core/Db.php';
require_once 'Base.php';
require_once './app/Model/admin.php';
require_once 'Token.php';
class AdminAction extends Token {
    //添加文章
    public function add_article()
    {
        //接收文章数据
        $data = post();
        $file = get_file();
        //接收上传文件
        $path = $this->upload_file($file);

        if(!$path){
            $this->jsonReturn(0,'文件上传失败');
        }
        $admin = new admin();
        $insert_id = $admin->add_article($data,$path);    //bug：字段超过其长度
        if($insert_id){
            $this->jsonReturn(1,'发布成功',$insert_id);
        }else{
            $this->jsonReturn(0,'发布失败');
        }
    }

    //修改文章
    public function update_article()
    {

    }

    //删除文章
    public function delete_article()
    {
        $article_id = get('article_id');
        $res = Db::delete('article',['id'=>$article_id]);
        if($res){
            $this->jsonReturn(1,"删除成功");
        }else{
            $this->jsonReturn(0,"删除失败");
        }
    }

    //查询所有文章
    public function query_article()
    {
        //返回文章id号，路径，标题，创建/修改时间
        $admin = new admin();
        $res = $admin->all_articles();
        if($res){
            $this->jsonReturn(1,'article_list',$res);
        }
    }

    //分页查询文章
    public function show_article()
    {
        $page = get();

        $admin = new admin();
        $res = $admin->get_article($page['page']);
        if($res){
            $this->jsonReturn(1,'articles',$res);
        }
    }

    //查询分类标签
    public function get_cate()
    {
        $arr = Db::lists('label','');
        $list = getTree($arr);
        $this->jsonReturn(1,'分类标签',$list);
    }

    //添加标签
    public function add_cate()
    {
        $data = post();
        $data = ['label_name'=>$data['label_name'],'pid'=>$data['label_id']];
        $admin = new admin();
        $res = $admin->add_label($data);
        if($res){
            $this->jsonReturn(1,'添加成功');
        }else{
            $this->jsonReturn(0,'添加失败');
        }

    }

    //文章md文件路径
    public function article_path()
    {
        $id = get('id');
        $res = Db::item('article',["id"=>(int) $id]);
        if($res){
            $this->jsonReturn(1,'md文章',$res);
        }
    }


}
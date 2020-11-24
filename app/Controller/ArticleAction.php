<?php
require_once './core/Db.php';
require_once 'Base.php';
require_once './app/Model/article.php';
class ArticleAction extends Base {
    //查询所有文章
    public function query_article()
    {
        //返回文章id号，路径，标题，创建/修改时间
        $article = new article();
        $res = $article->all_articles();
        if($res){
            $this->jsonReturn(1,'article_list',$res);
        }
    }

    //根据id查找文章
    public function query_article_by_id()
    {
        $data = get_json();         //接收的是json，返回数组
//        echo json_encode($data);  //前端指定类型后，也应接收json
        $article = new article();
        $res = $article->get_article_by_id($data);
//        echo json_encode($res);
        $this->jsonReturn(1,'result',$res);
    }

    //分页查询文章
    public function show_article()
    {
        $page = get();

        $article = new article();
        $res = $article->get_article($page['page']);
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

    //查询子分类标签
    public function get_label_cate(){
        $id = get('id');
        $arr = Db::lists('label','');
        $list = getTree($arr,$id);
        $this->jsonReturn(1,'子分类标签',$list);
    }

    //查询一级标签
    public function level_label()
    {
        $pid = get('pid');
        $pid = addslashes($pid);
        $list = Db::execute("SELECT * FROM label WHERE pid=$pid");

        $this->jsonReturn(1,'一级标签',$list);
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
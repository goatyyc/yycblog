<?php
class article{
    //所有文章
    public function all_articles()
    {
        $lists = Db::lists('article','');
        return $lists;
    }

    //
    public function get_article_by_id($arr){
        //查询所有属于标签集的文章
//        var_dump($arr);
        //接收的是一个数组，数组是有文章标签所属id
        $rows = [];
        foreach ($arr as $key=>$value){
//            echo $value;
            $row = Db::lists('article',['label'=>$value]);
            if($row){
                $rows[] = $row;
            }
        }
//        var_dump($rows);die();
        return $rows;
    }

    //分页查询文章
    public function get_article($page)
    {
        $lists = Db::pagination('article','',$page,6);
        return $lists;
    }
}
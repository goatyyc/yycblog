<?php
/*
 * 数据库访问类
 * */
class Db{
    //连接数据库
    public static function db_connect(){
//        require_once '../config/db.php';
        $conn = mysqli_connect("localhost","root","410488","blog");
        if(!$conn){
            exit("connection failed:".mysqli_connect_error());
        }
        return $conn;
    }

    //获取一条记录
    public static function item($table, $where = array())
    {
        $conn = self::db_connect();
        $rows = false;
        $sql = "SELECT * FROM {$table} ";
        if($where){
            $sql .= ' where '.self::getWhere($where);
        }
//        var_dump($sql);
        if($result = mysqli_query($conn, $sql)){
            while ($row = mysqli_fetch_assoc($result)){
                $rows[] = $row;
            }
        }
        mysqli_close($conn);
        if(!$rows){
            return $rows;
        }
        return $rows[0];
    }

    //执行sql语句，返回结果
    public static function execute($sql){
        $conn = self::db_connect();
        $rows = false;
        if($result = $conn->query($sql)){
            while($row = mysqli_fetch_assoc($result)){
                $rows[] = $row;
            }
            mysqli_free_result($result);
        };
        mysqli_close($conn);
        if(!$rows){
            return $rows;
        }
        return $rows;
    }

    //查询列表
    public static function lists($table,$where,$order=''){
        $conn = self::db_connect();
        $rows = false;
        $sql = "SELECT * FROM {$table} ";
        if($where){
            $sql .= ' where '.self::getWhere($where);
        }
        if($order){
            $sql .= " ORDER BY {$order}";
        }

        if($result = mysqli_query($conn,$sql)){
            while($row = mysqli_fetch_assoc($result)){
                $rows[] = $row;
            }
            mysqli_free_result($result);
        }
        mysqli_close($conn);
        return $rows;
    }

    //处理where条件
    private static function getWhere($params){
        $_where = "";
        if(!$params){
            return $_where;
        }
        foreach ($params as $key=>$value){
            $value = gettype($value)=="string" ? "'".$value."'" : $value;
            if($value){
                $_where .= $key."=".$value.' AND ';
            }else{
                $_where .= $key.' AND ';
            }
        }
        $_where = rtrim($_where, ' AND');   //注意空格
        return $_where;
    }

    //自定义列表索引
    public static function cate($table,$where,$index,$order=''){
        $lists = self::lists($table,$where,$order);
        if(!$lists){
            return $lists;
        }

        $result = array();
        foreach ($lists as $key => $value){
            $result[$value[$index]] = $value;
        }
        return $result;
    }

    //查询总数
    public static function total($table,$where){
        $conn = self::db_connect();
        $sql = "SELECT COUNT(*) AS count FROM {$table}";
        if($where){
            $sql .= " where ".self::getWhere($where);
        }
        $count = 0;
        if($result = mysqli_query($conn,$sql)){
            $row = mysqli_fetch_assoc($result);
            $count = $row['count'];
        }
        mysqli_close($conn);
        return $count;
    }

    //分页方法
    public static function pagination($table,$where,$page,$num,$order=''){
        $conn = self::db_connect();
        $count = self::total($table,$where);      //记录总数
        $total_page = ceil($count/$num);    //计算总页数
        $page = max(1,$page);              //处理page
        $offset = ($page-1)*$num;                 //偏移量
        //拼接sql
        $sql = "SELECT * FROM {$table}";
        if($where){
            $sql .= self::getWhere($where);
        }
        if($order){
            $sql .= " ORDER BY {$order}";
        }

        $sql .= ' LIMIT '.$offset.','.$num;

        $rows = array();
        if($result = mysqli_query($conn,$sql)){
            while($row = mysqli_fetch_assoc($result)){
                $rows[] = $row;
            }
            mysqli_free_result($result);
        }
        mysqli_close($conn);

        return array('total' => $count, 'lists' => $rows);
    }

    //添加数据
    public static function insert($table,$data){
        $conn = self::db_connect();
        $fields = $values = [];
        foreach ($data as $key => $item) {
            //参数处理：预防sql注入
            $items = str_replace("'",'&apos',$item);    //处理单引号
            $items = str_replace('"','&quot',$item);    //处理双引号
            $fields[] = "`".$key."`";
            $values[] = "'".$item."'";
        }
        $sql = "INSERT INTO {$table} (".implode(',',$fields).") VALUES (".implode(',',$values).")";

        //执行sql
        $insert_id = 0;     //返回自增的id
        if(mysqli_query($conn,$sql)){
            $insert_id = mysqli_insert_id($conn);
        }
        mysqli_close($conn);
        return $insert_id;
    }

    //更新数据
    public static function update($table,$data,$where=array(),$order='')
    {
        $conn = self::db_connect();
        //处理data  => 构造sql
        $str = '';
        foreach ($data as $key => $item){
            $item = str_replace("'",'&apos',$item);
            $item = str_replace('"','&quot',$item);
            $item = gettype($item) == "string" ? "'".$item."'" : $item;     //放在sql处理之后(有漏洞?)

            $str .= "`".$key."`".'='.$item;
        }

        $sql = "UPDATE {$table} SET {$str}";
        if($where){
            $sql .= " where ".self::getWhere($where);
        }

        //执行sql
        $res = $conn->query($sql) ? true : false;
        return $res;

    }

    //删除操作
    public static function delete($table,$where)
    {
        $conn = self::db_connect();
        $sql = "DELETE FROM {$table}";
        if($where){
            $sql .= " where ".self::getWhere($where);
        }
        $res = mysqli_query($conn,$sql);
        mysqli_close($conn);
        return $res;
    }
}


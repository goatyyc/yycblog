<?php
//链式操作
class SysDb{
    private $table;
    private $where;
    public function table($table){
        $this->where = array();     //初始化
        $this->table = $table;
        return $this;
    }

    public function where($where){
        $this->where = $where;
        return $this;
    }

    public function item()
    {
        $item = Db::item($this->table,$this->where);
        return $item;
    }
}
<?php
class M_Product{
    public function showProduct($id){
        $sql = "SELECT countView FROM goods WHERE id=$id";
        $resCount = M_DB::getInstance() -> Select($sql);
        $object = ['countView' => $resCount[0]['countView'] + 1];
        $where = "id=$id";
        $changedRow = M_DB::getInstance() -> Update('goods', $object, $where);
        $sql = "SELECT * FROM goods WHERE id=$id";
        $res = M_DB::getInstance() -> Select($sql);         
        return $res[0];
    }
}
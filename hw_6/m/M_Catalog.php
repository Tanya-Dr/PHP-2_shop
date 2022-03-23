<?php
class M_Catalog{
    public $countGoods;

	public function __construct(){
        $sql = "SELECT COUNT(*) AS count FROM goods";
        $res = M_DB::getInstance() -> Select($sql); 
		$this->countGoods = $res[0]['count'];
	}

    function getGoods($lastId = 0){    
        $sql = "SELECT * FROM goods WHERE id > $lastId ORDER BY countView DESC, id ASC LIMIT 5";
        $res = M_DB::getInstance() -> Select($sql); 
        foreach($res as $key => $row){
            $items[] = $row;
        }   
        return $items;
    }
}
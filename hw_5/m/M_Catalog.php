<?php
include_once('m/connect.php');

class M_Catalog{
    function getGoods(){    
        $db = get_db();
        $sql = "SELECT * FROM goods ORDER BY id";
        $res = $db->prepare($sql);
        $res->execute();
        while ($row = $res->fetch(PDO::FETCH_OBJ)) {
            $items[] = $row;
        }    
        unset($dbh); 
        return $items;
    }
}
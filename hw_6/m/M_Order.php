<?php
class M_Order{
    public function getOrders($id){
        $sql ="SELECT DISTINCT orders.*, cart.idOrder, orderStatus.status, cart.quantity, goods.title, goods.price, goods.img, goods.id AS goodId FROM orders JOIN orderStatus ON orders.statusOrder = orderStatus.id JOIN cart ON cart.idOrder = orders.id LEFT JOIN goods ON cart.idGood = goods.id WHERE cart.idUser=$id AND cart.idOrder > 0 ORDER BY cart.date DESC";
        $res = M_DB::getInstance() -> Select($sql, true); 
        foreach($res as $key => $row){
            $orders[] = $row;
        }   
        return $orders;
    }
}
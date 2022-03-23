<?php
class M_Order{
    public function getCountOrders($id){
        $sql = "SELECT COUNT(*) AS count FROM orders WHERE orders.idUser=$id";
        $res = M_DB::getInstance() -> Select($sql);
        return $res[0]['count'];
    }

    public function getOrders($id,$lastDate){
        if($lastDate == 0){
            $sql ="SELECT DISTINCT orders.*, cart.idOrder, orderStatus.status, cart.quantity, goods.title, goods.price, goods.img, goods.id AS goodId FROM orders JOIN orderStatus ON orders.statusOrder = orderStatus.id JOIN cart ON cart.idOrder = orders.id LEFT JOIN goods ON cart.idGood = goods.id WHERE cart.idUser=$id AND cart.idOrder > 0 ORDER BY cart.date DESC LIMIT 2";
        }else{
            $sql ="SELECT DISTINCT orders.*, cart.idOrder, orderStatus.status, cart.quantity, goods.title, goods.price, goods.img, goods.id AS goodId FROM orders JOIN orderStatus ON orders.statusOrder = orderStatus.id JOIN cart ON cart.idOrder = orders.id LEFT JOIN goods ON cart.idGood = goods.id WHERE (cart.idUser=$id AND cart.idOrder > 0 AND dateOrder < '$lastDate') ORDER BY cart.date DESC LIMIT 2";
        }
        
        $res = M_DB::getInstance() -> Select($sql, true); 
        foreach($res as $key => $row){
            $orders[] = $row;
        }   
        return $orders;
    }

    public function getAllOrders(){
        $sql = "SELECT orders.*, orderStatus.status, users.email FROM orders JOIN orderStatus ON orders.statusOrder = orderStatus.id JOIN users ON orders.idUser = users.id ORDER BY orders.dateOrder DESC";
        $res = M_DB::getInstance() -> Select($sql); 
        foreach($res as $key => $row){
            $orders[] = $row;
        }   
        return $orders;
    }

    public function createOrder($idUser, $address, $tel, $delivery, $total){
        $date = date("Y-m-d H:i:s");
        $object = [
            'statusOrder' => 1,
            'dateOrder' => $date,
            'totalSum' => $total,
            'deliveryPrice' => $delivery,
            'address' => $address,
            'phoneNumber' => $tel,
            'idUser' => $idUser,
            'lastUpdate' => $date
        ];
        $resInsert = M_DB::getInstance() -> Insert('orders', $object);
        if(!$resInsert){
            return "Error with insert";
        }
        $object = ['idOrder' => $resInsert];
        $where = "idUser=$idUser AND idOrder=0";
        $resUpdate = M_DB::getInstance() -> Update('cart', $object, $where);
        if(!$resUpdate){
            return "Error with insert";
        }
        return 'ok';
    }

    public function changeOrderStatus($newStatus, $idOrder){
        $date = date("Y-m-d H:i:s");
        $object = [
            'statusOrder' => $newStatus,
            'lastUpdate' => $date
        ];
        $where = "id=$idOrder";
        $resUpdate = M_DB::getInstance() -> Update('orders', $object, $where);
        if(!$resUpdate){
            return 0;
        }
        return $date;
    }
}
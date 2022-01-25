<?php
class M_Cart{
    function getTotalSum($idUser){
        $sql = "SELECT ROUND(SUM(goods.price * cart.quantity),2) AS sum FROM cart JOIN goods ON cart.idGood = goods.id WHERE cart.idUser=$idUser AND cart.idOrder = 0";
        $res = M_DB::getInstance() -> Select($sql); 
        return $res[0]['sum'];
    }

    function getCart($idUser){ 
        $sql = "SELECT * FROM cart JOIN goods ON cart.idGood = goods.id WHERE cart.idUser=$idUser AND cart.idOrder = 0";          
        $res = M_DB::getInstance() -> Select($sql); 
        foreach($res as $key => $row){
            $items[] = $row;
        }   
        return $items;
    }

    public function addToCart($idUser, $idGood){
        $sql = "SELECT * FROM cart WHERE idGood=$idGood AND idUser = $idUser AND idOrder=0";
        $res = M_DB::getInstance() -> Select($sql);
        if(!$res){
            $date = date("Y-m-d H:i:s");                
            $object = [
                'idGood' => $idGood,
                'quantity' => 1,
                'idUser' => $idUser,
                'date' => $date,
                'idOrder' => 0
            ];
            $resInsert = M_DB::getInstance() -> Insert('cart', $object);
            if(!$resInsert){
                return "Error with insert";
            }
        }else{
            $object = ['quantity' => $res[0]['quantity'] + 1];
            $where = "idGood=$idGood AND idUser=$idUser AND idOrder=0";
            $resUpdate = M_DB::getInstance() -> Update('cart', $object, $where);
            if(!$resUpdate){
                return "Error with update";
            }
        } 
        return "Product added to cart";
    }

    public function deleteFromCart($idUser, $idGood){
        $where = "idGood=$idGood AND idUser=$idUser AND idOrder=0";
        $resDelete = M_DB::getInstance() -> Delete('cart', $where); 
        if($resDelete){
            return "ok";
        }
        return "Error with delete good from cart";
    }

    function clearCart($idUser){
        $where = "idUser=$idUser AND idOrder=0";
        $resDelete = M_DB::getInstance() -> Delete('cart', $where); 
        if($resDelete){
            return "ok";
        }
        return "Error with clear cart";
    }

    public function changeCart($idUser, $idGood, $countGood){
        if($countGood>0){
            $object = ['quantity' => $countGood];
            $where = "idGood=$idGood AND idUser=$idUser AND idOrder=0";
            $res = M_DB::getInstance() -> Update('cart', $object, $where);
        }else{
            $where = "idGood=$idGood AND idUser=$idUser AND idOrder=0";
            $res = M_DB::getInstance() -> Delete('cart', $where);
        }

        if($res){
            return "ok";
        }
        return "Error with change cart";
    }
}
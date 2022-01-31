<?php
class C_Admin extends C_User{
    public function action_index(){
        if($_SESSION['admin'] < 1){
            header('location: index.php?c=User&act=login');
			exit();
        }

        $this->title = 'ADMIN';
        $this->contentBlock = 'v_admin.tmpl';
        $this->content = ['admin' => $_SESSION['admin']];
    }

    public function action_adminOrders(){
        if($_SESSION['admin'] < 1){
            header('index.php?c=Order&act=ordersHistory');
			exit();
        }

        $this->title = 'ADMIN ORDERS';
        $order = new M_Order();
        
        if($this->isPost()){
            $status = $this->checkData($_POST['status']); 
            $idOrder = $this->checkData($_POST['idOrder']); 
            $res = $order->changeOrderStatus($status, $idOrder);
            $this->needToRender = false;
            echo $res;
        }else{
            $orders = $order->getAllOrders();
            $back = $_SERVER['HTTP_REFERER'];
            $src = [
                'orders' => $orders,
                'backLink' => $back
            ];
            $this->content = $src;
            $this->contentBlock = 'v_adminOrders.tmpl';
        }       
    }

    public function action_adminUsers(){
        if($_SESSION['admin'] < 1){
            header('index.php?c=User&act=profile');
			exit();
        }

        $this->title = 'ADMIN USERS';
        $user = new M_User();
        
        if($this->isPost()){
            $admin = $_POST['admin'] ? $this->checkData($_POST['admin']) : (int)0;
            $idUser = $this->checkData($_POST['id']); 
            $res = $user->changeAccess($admin, $idUser);
            $this->needToRender = false;
            echo $res;
        }else{
            $users = $user->getAllUsers();
            $back = $_SERVER['HTTP_REFERER'];
            $src = [
                'users' => $users,
                'backLink' => $back
            ];
            $this->content = $src;
            $this->contentBlock = 'v_adminUsers.tmpl';
        }       
    }

    public function action_adminGoods(){
        if($_SESSION['admin'] < 1){
            header('index.php');
			exit();
        }

        $this->title = 'ADMIN GOODS';
        $catalog = new M_Catalog();
        $lastId = 0;
        $firstRender = true;
        $countGoods = $catalog->countGoods;

        if($this->isPost()){
            $lastId = $this->checkData($_POST['lastId']);
            $this->ajax = true;
            $firstRender = false;
        }

        $items = $catalog->getGoodsToEdit($lastId);
        $src = [
            'pathToPhoto' => PATH_TO_SMALL_PHOTO,
            'items' => $items,
            'firstRender' => $firstRender,
            'countGoods' => $countGoods
        ];

        $this->content = $src;
        $this->contentBlock = 'v_adminGoods.tmpl';
    }

    public function action_editGoods(){
        if($_SESSION['admin'] < 1){
            header('index.php');
			exit();
        }

        $this->title = 'ADD GOODS';
        $back = $_SERVER['HTTP_REFERER'];
        $src = [
            'backLink' => $back,
            'action' => 'add'
        ];

        if($_GET['id']){
            $this->title = 'EDIT GOODS';
            $id = $this->checkData($_GET['id']);
            $back = $_SERVER['HTTP_REFERER'];
            $product = new M_Product();

            $item = $product->showProduct($id);
            $src = [
                'pathToPhoto' => PATH_TO_BIG_PHOTO,
                'item' => $item,
                'backLink' => $back,
                'action' => 'edit'
            ];
        }        

        if($this->isPost()){
            $title = $this->checkData($_POST['title']);
            $price = $this->checkData($_POST['price']);
            $shortInfo = $this->checkData($_POST['shortInfo']);
            $fullInfo = $this->checkData($_POST['fullInfo']);            
            $size = $_FILES['photo']['size'];
            $img = ($size != 0) ? $_FILES['photo']['name'] : "";
            $photoTmpName = ($size != 0) ? $_FILES['photo']['tmp_name'] : "";
            $info = [
                'title' => $title,
                'price' => (double)$price,
                'shortInfo' => $shortInfo,
                'fullInfo' => $fullInfo,
                'img' => $img,
            ];
            $id = $this->checkData($_POST['id']);   
            $product = new M_Product();     

            if($id){
                $res = $product->editProduct($id,$info,$size,$photoTmpName);
            }else{               
                $res = $product->addProduct($info,$size,$photoTmpName);
            }            
            $this->needToRender = false;
            echo $res;
        }

        $this->content = $src;        
        $this->contentBlock = 'v_editGoods.tmpl';
    }

    public function action_deleteGoods(){
        if($_SESSION['admin'] < 1){
            header('index.php');
			exit();
        }
        if($this->isPost()){
            $id = $this->checkData($_POST['id']);

            $product = new M_Product();
            $res = $product->deleteProduct($id);
            echo $res;
        }
        $this->needToRender = false;    
    }
}
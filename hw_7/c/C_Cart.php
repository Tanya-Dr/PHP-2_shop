<?php
class C_Cart extends C_Base{
    private $cart;

    public function __construct(){
        $this->cart = new M_Cart();
    }

    public function action_index(){    
        if(!$_SESSION['id']){
            header('location: index.php');
            exit();
        }    
        $this->title = 'Your cart';
        $firstRender = true;
        $items = $this->cart->getCart($_SESSION['id']);
        if($items){
            $totalSum = $this->cart->getTotalSum($_SESSION['id']);
        }else{
            $totalSum = 0;
        }
    
        $src = [
            'pathToPhoto' => PATH_TO_SMALL_PHOTO,
            'items' => $items,
            'totalSum' => $totalSum,
        ];
        $this->content = $src;
        $this->contentBlock = 'v_cart.tmpl';
    }

    public function action_addToCart(){        
        if(!$_SESSION['id']){
            echo "not authorized";
            exit();
        }
        $this->needToRender = false;
        if($this->isPost()){
            $idGood = $this->checkData($_POST['id']);  
            $idUser = $_SESSION['id'];
            $res = $this->cart->addToCart($idUser,$idGood);
            echo $res;
        }        
    }

    public function action_clearCart(){
        if(!$_SESSION['id']){
            header('location: index.php');
            exit();
        }
        $this->title = 'Your cart';
        $res = $this->cart->clearCart($_SESSION['id']);
        $this->ajax = true;
        $src = [
            'totalSum' => 0
        ];
        $this->content = $src;
        $this->contentBlock = 'v_cart.tmpl';
    }

    public function action_deleteFromCart(){
        if(!$_SESSION['id']){
            header('location: index.php');
            exit();
        }
        $this->title = 'Your cart';
        $idGood = $this->checkData($_POST['id']); 
        $idUser = $_SESSION['id'];
        $res = $this->cart->deleteFromCart($idUser, $idGood);
        $this->ajax = true;
        $this->action_index();        
    }

    public function action_changeCart(){
        if(!$_SESSION['id']){
            header('location: index.php');
            exit();
        }
        $this->title = 'Your cart';
        $idGood = $this->checkData($_POST['id']); 
        $countGood = $this->checkData($_POST['count']); 
        $idUser = $_SESSION['id'];
        $res = $this->cart->changeCart($idUser, $idGood, $countGood);        
        $this->ajax = true;
        $this->action_index();
    }
}
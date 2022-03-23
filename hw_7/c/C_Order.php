<?php
class C_Order extends C_Base{
    private $order;

    public function __construct(){
		$this->order = new M_Order();
	}

	public function action_index(){
		if(!$_SESSION['id']){
			header('location: index.php?c=User&act=login');
		}
		$this->title = 'Your order';
		$cart = new M_Cart();
		$items = $cart->getCart($_SESSION['id']);
		$totalSum = $cart->getTotalSum($_SESSION['id']);

		if(!$totalSum){
			header('location: index.php?c=Cart');
		}

		$src = [
			'pathToPhoto' => PATH_TO_SMALL_PHOTO,
			'items' => $items,
			'totalSum' => $totalSum,
		];
		$this->content = $src;
		$this->contentBlock = 'v_order.tmpl';
	}

	public function action_ordersHistory(){
		if(!$_SESSION['id']){
			header('location: index.php?c=User&act=login');
		}
		$this->title = 'Your orders';
		$orders = $this->order->getOrders($_SESSION['id']);
		$src = [
			'orders' => $orders,
			'pathToPhoto' => PATH_TO_SMALL_PHOTO
		];
		$this->content = $src;
		$this->contentBlock = 'v_historyOrders.tmpl';		
	}

	public function action_createOrder(){
		if(!$_SESSION['id']){
			header('location: index.php?c=User&act=login');
		}
		if($this->isPost()){
			$address = $this->checkData($_POST['address']);
			$tel = $this->checkData($_POST['tel']);
			$delivery = $this->checkData($_POST['delivery']);
			$total = $this->checkData($_POST['total']);
			$errText = $this->order->createOrder($_SESSION['id'],$address,$tel,$delivery,$total);
			if($errText == "ok"){
				$this->needToRender = false;
				echo "ok";
			}else{
				$this->ajax = true;
				$this->content = ['errText' => $errText];
				$this->contentBlock = 'v_error.tmpl';
			}				
		}
	}
}
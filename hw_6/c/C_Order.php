<?php
class C_Order extends C_Base{
    private $order;

    public function __construct(){
		$this->order = new M_Order();
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
}
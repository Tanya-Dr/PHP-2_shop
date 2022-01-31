<?php
class C_Product extends C_Base{
    private $product;

    public function __construct(){
        $this->product = new M_Product();
    }
    
    public function action_index(){
        $id = $this->checkData($_GET['id']);
        $back = $_SERVER['HTTP_REFERER'];

        $item = $this->product->showProduct($id,true);
        $src = [
            'pathToPhoto' => PATH_TO_BIG_PHOTO,
            'item' => $item,
            'backLink' => $back
        ];
        $this->content = $src;
        $this->contentBlock = 'v_product.tmpl';
    }
}
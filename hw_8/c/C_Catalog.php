<?php
class C_Catalog extends C_Base{
    private $catalog;

    public function __construct(){
        $this->catalog = new M_Catalog();
    }

    public function action_index(){
        $this->title = 'CATALOG';
        $lastId = 0;
        $firstRender = true;
        $countGoods = $this->catalog->countGoods;

        if($this->isPost()){
            $lastId = $this->checkData($_POST['lastId']);
            $lastCountView = $this->checkData($_POST['lastCountView']);
            $this->ajax = true;
            $firstRender = false;
        }
        
        $items = $this->catalog->getGoods($lastId,$lastCountView);
        $src = [
            'pathToPhoto' => PATH_TO_SMALL_PHOTO,
            'items' => $items,
            'firstRender' => $firstRender,
            'countGoods' => $countGoods
        ];
        $this->content = $src;
        $this->contentBlock = 'v_gallery.tmpl';
    }

}
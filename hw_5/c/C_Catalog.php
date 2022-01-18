<?php
//
//  Reading page controller  
//
include_once('m/M_Catalog.php');
include_once('m/constants.php');

class C_Catalog extends C_Base{
    public function action_index(){
        $this->title = 'CATALOG';
        
        $catalog = new M_Catalog();
        $items = $catalog->getGoods();
        $src = [
            'pathToPhoto' => PATH_TO_SMALL_PHOTO,
            'items' => $items
        ];
        $this->content = $src;
        $this->contentBlock = 'v_gallery.tmpl';
    }
}
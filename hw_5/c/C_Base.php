<?php
//
//  Basic site controller
//
abstract class C_Base extends C_Controller{
    protected $title;   //  page title
    protected $content; //  page content
    protected $keyWords;
    protected $contentBlock;    //  include block

    protected function before(){
        $this->title = 'Shop';
        $this->content = [];
        $this->keyWords = '';
        $this->contentBlock = 'v_gallery.tmpl';
    }

    //
    //  Generating a basic template
    //
    public function render(){
        $twig = $this->ReturnTwig();
        $src = [
            'title' => $this->title,
            'content' => $this->content,
            'kw' => $this->keyWords,
            'contentBlock' => $this->contentBlock
        ];
        $template = $twig->render('v_main.tmpl',$src);
        echo $template; 
    }
}
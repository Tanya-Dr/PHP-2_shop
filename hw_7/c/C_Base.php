<?php
//
//  Basic site controller
//
abstract class C_Base extends C_Controller{
    protected $title;   //  page title
    protected $content; //  page content
    protected $contentBlock;    //  include block
    protected $userInfo;    //  user info
    protected $admin;   //  admin info
    protected $ajax;    //  update just block of the page (not full page)
    protected $needToRender;    //  render or not block or page

    protected function before(){
        $this->title = 'Shop';
        $this->content = [];
        $this->contentBlock = 'v_gallery.tmpl';
        $this->userInfo = $_SESSION['id'] ? $_SESSION['id'] : '';
        $this->admin = $_SESSION['admin'] ? $_SESSION['admin'] : 0;
        $this->ajax = false;
        $this->needToRender = true;
    }

    //
    //  Generating a basic template
    //
    public function render(){
        $twig = $this->ReturnTwig();
        $src = [
            'title' => $this->title,
            'content' => $this->content,
            'contentBlock' => $this->contentBlock,
            'userInfo' => $this->userInfo,
            'admin' => $this->admin
        ];
        if(!$this->ajax){
            $tmpl = 'v_main.tmpl';
        }else{
            $tmpl = $src['contentBlock'];
            $src = $src['content'];
            $src['userInfo'] = $this->userInfo;
            $src['title'] = $this->title;
            $src['admin'] = $this->admin;
        }
        $template = $twig->render($tmpl,$src);
        echo $template; 
    }
}
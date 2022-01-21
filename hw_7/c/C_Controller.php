<?php
//
//  Base class controller
//

abstract class C_Controller{
    //  Generating an external template
    protected abstract function render();

    //  Function working up to the main method
    protected abstract function before();

    public function Request($action){
        $this->before();//  the method is called before generating data for the template
        $this->$action();// $this->action_index
        if($this->needToRender){
            $this->render(); 
        }       
    }

    //
    //  Is the request made with the GET method?
    //
    protected function IsGet(){
        return $_SERVER['REQUEST_METHOD'] == 'GET';
    }

    //
    //  Is the request made with the POST method?
    //
    protected function IsPost(){
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    //
    //  Check incoming data
    //
    protected function checkData($data){
        return $data ? htmlspecialchars(strip_tags($data)) : "";
    }

    //  Twig initialization
    protected function ReturnTwig(){
        $loader = new \Twig\Loader\FilesystemLoader('v/');
        $twig = new \Twig\Environment($loader);
        return $twig;
    }

    //  If you called a method that does not exist, exit
    public function __call($name, $params){
        die("Don't write bullshit in the url!!!");
    }
}
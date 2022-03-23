<?php
class C_User extends C_Base{	
	private $user;

	public function __construct(){
		$this->user = new M_User();
	}

	public function action_login(){
		if($_SESSION['id']){
			header('location: index.php?c=User&act=profile');
			exit();
		}
		$this->title = 'LOGIN';

		$errText = "";
		$email = "";
    	if($this->isPost()){
			$email = $this->checkData($_POST['email']);
			$pass = $this->checkData($_POST['pass']);
        	$errText = $this->user->login($email,$pass);		
			if($errText == "success"){
				header('location: index.php?c=User&act=profile');
				exit();
			}
		}
		$this->content = ['errText' => $errText,'email' => $email];
		$this->contentBlock = 'v_login.tmpl';
	}

	public function action_signup(){
		if($_SESSION['id']){
			header('location: index.php?c=User&act=profile');
			exit();
		}
		$this->title = 'SIGNUP';

		$errText = "";
		$email = "";
		$nickname = "";
		if($this->isPost()){
			$email = $this->checkData($_POST['email']);
			$nickname = $this->checkData($_POST['nickname']);
			$pass = $this->checkData($_POST['pass']);
			$passConfirm = $this->checkData($_POST['passConfirm']);

			if($pass != $passConfirm){
				$errText = 'Incorrect password';
			}else{
				$errText = $this->user->signup($email,$pass,$nickname);
			}            		
			if($errText == "success"){
				header('location: index.php?c=User&act=profile');
				exit();
			}
		}
		$this->content = ['errText' => $errText,'email' => $email, 'nickname' => $nickname];
		$this->contentBlock = 'v_signup.tmpl';
	}

	public function action_profile(){
		if(!$_SESSION['id']){
			header('location: index.php?c=User&act=login');
			exit();
		}
		$this->title = 'PROFILE';
		
		$data = $this->user->profile($_SESSION['id']);
		$this->content = $data;
		$this->contentBlock = 'v_profile.tmpl';
	}

	public function action_logout(){
		if($_SESSION['id']){
			$this->user->logout();
		}
		header('location: index.php?c=User&act=login');
	}	
}
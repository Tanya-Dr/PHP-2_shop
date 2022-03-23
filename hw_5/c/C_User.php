<?php
//
//  Reading page controller
//
include_once('m/M_User.php');

class C_User extends C_Base{	
	public function action_login(){
		if($_SESSION['id']){
			header('location: index.php?c=User&act=profile');
			exit();
		}
		$this->title = 'LOGIN';

        $user = new M_User();
		$errText = "";
		$email = "";
        if($this->isPost()){
            $email = $_POST['email'] ? htmlspecialchars(strip_tags($_POST['email'])) : "";
			$pass = $_POST['pass'] ? htmlspecialchars(strip_tags($_POST['pass'])) : "";
            $errText = $user->login($email,$pass);		
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

		$user = new M_User();
		$errText = "";
		$email = "";
		$nickname = "";
		if($this->isPost()){
            $email = $_POST['email'] ? htmlspecialchars(strip_tags($_POST['email'])) : "";
			$nickname = $_POST['nickname'] ? htmlspecialchars(strip_tags($_POST['nickname'])) : "";
			$pass = $_POST['pass'] ? htmlspecialchars(strip_tags($_POST['pass'])) : "";
			$passConfirm = $_POST['passConfirm'] ? htmlspecialchars(strip_tags($_POST['passConfirm'])) : "";
			if($pass != $passConfirm){
				$errText = 'Incorrect password';
			}else{
				$errText = $user->signup($email,$pass,$nickname);
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

		$user = new M_User();
		$data = $user->profile($_SESSION['id']);
		$this->content = $data;
		$this->contentBlock = 'v_profile.tmpl';
	}

	public function action_logout(){
		if($_SESSION['id']){
			$user = new M_User();
			$user->logout();
		}
		header('location: index.php?c=User&act=login');
	}
}
<?php
include_once('m/constants.php');
include_once('m/connect.php');

class M_User{
    function login($email,$pass){
        $db = get_db();

        $passToCheck = DB_SALT . md5($pass) . DB_SALT;

        $sql = "SELECT * FROM users WHERE email='$email' AND pass='$passToCheck'";        
        $res = $db->prepare($sql);
        $res->execute();
        if($res->rowCount()){
            $data = $res->fetch(PDO::FETCH_ASSOC);
            $_SESSION['id'] = $data['id']; 
            $_SESSION['admin'] = $data['admin'];    
            return "success";
        }else{
            $sql = "SELECT * FROM users WHERE email='$email'";
            $res = $db->prepare($sql);
            $res->execute();
            if($res->rowCount()){
                return "Incorrect password.";
            }else {
                return "Authorisation Error.";
            }        
        }
    }

    function signup($email,$pass,$nickname){
        $db = get_db();

        $sql= "SELECT id FROM users WHERE email='$email'";
        $res = $db->prepare($sql);
        $res->execute();
        if($res->rowCount()){    
            return "This email is already registered";
        }

        $passToCheck = DB_SALT . md5($pass) . DB_SALT;

        $sql = "INSERT INTO users (nickname, email, pass, admin) VALUES('$nickname','$email','$passToCheck',0)";
        $res = $db->prepare($sql);
        $res->execute();
        $sql = "SELECT * FROM users WHERE email='$email' AND pass='$passToCheck'";
        $res = $db->prepare($sql);
        $res->execute();
        if($data = $res->fetch(PDO::FETCH_ASSOC)){
            $_SESSION['id'] = $data['id'];
            $_SESSION['admin'] = $data['admin'];  
            return "success";
        }else {
            return "Registration error.";
        }
    }

    function profile($id){
        $db = get_db();

        $sql = "SELECT nickname,email FROM users WHERE id = '$id'";
        $res = $db->prepare($sql);
        $res->execute();
        $data = $res->fetch(PDO::FETCH_ASSOC);
        return ['nickname' => $data['nickname'],'email' => $data['email']];
    }

    function logout(){
        $_SESSION = [];
        session_destroy();
    }
}
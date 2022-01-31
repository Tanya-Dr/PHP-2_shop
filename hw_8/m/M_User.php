<?php
class M_User{
    public function setId($id, $admin){
        $_SESSION['id'] = $id; 
        $_SESSION['admin'] = $admin; 
    }

    public function login($email,$pass){   
        $sql = "SELECT * FROM users WHERE email='$email'";
        $res = M_DB::getInstance() -> Select($sql);   

        if($res){
            $passToCheck = M_DB::getInstance() -> Password($pass);
            if($res[0]['pass'] == $passToCheck){
                $this->setId($res[0]['id'],$res[0]['admin']);
                return "success";
            }else{
                return "Incorrect password.";
            }       
        }

        return "Authorisation Error.";        
    }

    public function signup($email,$password,$nickname){
        $sql= "SELECT id FROM users WHERE email='$email'";
        $res = M_DB::getInstance() -> Select($sql); 

        if($res){    
            return "This email is already registered";
        }

        $pass = M_DB::getInstance() -> Password($password);
        $object = [
            'nickname' => $nickname,
            'email' => $email,
            'pass'  => $pass,
            'admin' => 0
        ];
        $res = M_DB::getInstance() -> Insert('users',$object);
        
        if(is_numeric($res)){
            $this->setId($res,0);
            return "success";
        }else{
            return "Registration error.";
        }
    }

    public function profile($id){
        $sql = "SELECT nickname,email FROM users WHERE id = '$id'";
        $res = M_DB::getInstance() -> Select($sql); 
        return ['nickname' => $res[0]['nickname'],'email' => $res[0]['email']];
    }

    public function logout(){
        $_SESSION = [];
        session_destroy();
    }

    public function getAllUsers(){
        $sql = "SELECT * FROM users";
        $res = M_DB::getInstance() -> Select($sql);
        foreach($res as $key => $row){
            $users[] = $row;
        }   
        return $users;
    }

    public function changeAccess($admin, $idUser){
        $object = ['admin' => $admin];
        $where = "id=$idUser";
        $resUpdate = M_DB::getInstance() -> Update('users', $object, $where);
        if(!$resUpdate){
            return "Error with insert";
        }
        return 'Data updated successfully';
    }
}
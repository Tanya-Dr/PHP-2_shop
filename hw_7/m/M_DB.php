<?php
class M_DB{
    private static $instance;
    private $db;

    public static function getInstance(){
        if(self::$instance == null){
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct(){			
        setlocale(LC_ALL, 'ru_RU.UTF8');
        $connect_str = DB_DRIVER . ':dbname='.DB_NAME . ';host=' . DB_HOST;
        $this->db = new PDO($connect_str,DB_USER,DB_PASS);
        $this->db->exec('SET NAMES UTF8');
        $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    public function Select($query, $group = false){
        $q = $this->db->prepare($query);
        $q->execute();
            
        if($q->errorCode() != PDO::ERR_NONE){
            $info = $q->errorInfo();
            die($info[2]); 
        }
        
        if($group){
            return $q->fetchAll(PDO::FETCH_GROUP);
        }
        return $q->fetchAll();        
    }

    public function Insert($table, $object){			
        $columns = [];
        
        foreach($object as $key => $value){        
            $columns[] = $key;
            $markers[] = ":$key";
            
            if($value === null){
                $object[$key] = 'NULL';
            }
        }
        
        $columns_s = implode(',', $columns);
        $markers_s = implode(',', $markers);
        
        $query = "INSERT INTO $table ($columns_s) VALUES ($markers_s)";
        
        $q = $this->db->prepare($query);
        $q->execute($object);
        
        if($q->errorCode() != PDO::ERR_NONE){
            $info = $q->errorInfo();
            die($info[2]);
        }
        
        return $this->db->lastInsertId();
    }
    
    public function Update($table, $object, $where){        
        $sets = [];
         
        foreach($object as $key => $value){            
            $sets[] = "$key=:$key";
            
            if($value === NULL){
                $object[$key]='NULL';
            }
        }
         
        $sets_s = implode(',',$sets);
        $query = "UPDATE $table SET $sets_s WHERE $where";

        $q = $this->db->prepare($query);
        $q->execute($object);

        if($q->errorCode() != PDO::ERR_NONE){
            $info = $q->errorInfo();
            die($info[2]);
        }
        
        return $q->rowCount();
    }
    
    
    public function Delete($table, $where){        
        $query = "DELETE FROM $table WHERE $where";
        $q = $this->db->prepare($query);
        $q->execute();
        
        if($q->errorCode() != PDO::ERR_NONE){
            $info = $q->errorInfo();
            die($info[2]);
        }
        
        return $q->rowCount();
    }

    public function Password($pass){        
        return DB_SALT . md5($pass) . DB_SALT;
    }
}
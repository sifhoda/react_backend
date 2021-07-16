<?php

require_once __DIR__.'/../Classes/EmailValidation.php';
require_once __DIR__.'/../Classes/Connexion.php';

class EmailValidationServices {


    private $conn;
    private $table = 'email_verification';

    public function __construct(){
        $this->conn = new Connexion();
    }

    public function create(EmailValidation $o){
        $query = "INSERT INTO " . $this->table . " VALUES (?,?,?)";
        $req = $this->conn->getConnexion()->prepare($query);
        $req->execute($o->getEmailValidationArray()) or die('Error');
    }


    public function findByToken($token){
            $result = array();
            $query = "SELECT * FROM " . $this->table . " WHERE token=? LIMIT 1";
            $stmt = $this->conn->getConnexion()->prepare($query);
            $stmt->execute(array($token)); 
            while($e = $stmt->fetch(PDO::FETCH_OBJ)){
                $temp = [
                    "id" => $e->id,
                    "email" => $e->email,
                    "token" => $e->token
                ];
                array_push($result, $temp);
            }
            return $result;
    }

    public function delete($id){
        $query = "DELETE FROM " . $this->table . " WHERE id=?";
        $req = $this->conn->getConnexion()->prepare($query);
        $req->execute(array($id)) or die('error delete');  
    }
    
   
    

}
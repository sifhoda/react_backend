<?php 

require_once __DIR__.'/../Classes/User.php';
require_once __DIR__.'/../Classes/Connexion.php';


class UserServices {

    private $conn;


    public function __construct() {
        $this->conn = new Connexion();
    }



    public function findById($id){
        $result = array();
        $query = "SELECT * FROM citoyen WHERE id=?";
        $stmt = $this->conn->getConnexion()->prepare($query);
        $stmt->execute(array($id)); 
        while($e = $stmt->fetch(PDO::FETCH_OBJ)){
            $temp = [
                "id" => $e->id,
                "nom" => $e->nom,
                "prenom" => $e->prenom,
                "email" => $e->email,
                "password" => $e->password
            ];
            array_push($result, $temp);
        }
        if( sizeof($result) != 0 ){
            // array isn't empty
            return [
                'success' => 1,
                'status' => 200,
                'user' => $result
            ];
        }
    }


    public function findByEmail($email){
        $result = array();
        $query = "SELECT * FROM citoyen WHERE email=?";
        $stmt = $this->conn->getConnexion()->prepare($query);
        $stmt->execute(array($email)); 
        while($e = $stmt->fetch(PDO::FETCH_OBJ)){
            $temp = [
                "id" => $e->id,
                "nom" => $e->nom,
                "prenom" => $e->prenom,
                "email" => $e->email,
                "password" => $e->password,
                "etablissement" => $e->etablissement,
                "email_verifie" => $e->email_verifie,
                "compte_valide" => $e->compte_valide
            ];
            array_push($result, $temp);
        }
        if( sizeof($result) != 0 ){
            // array isn't empty
            return $result[0];
        }
    }   

    public function isEmailUnique($email){
        $query = "SELECT * FROM citoyen WHERE email=?";
        $req = $this->conn->getConnexion()->prepare($query);
        $req->execute(array($email));
        if($req->fetchColumn() == 0){
            return true;
        }
        return false;
    }


    public function create(Users $o){
        $query = "INSERT INTO citoyen VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
        $req = $this->conn->getConnexion()->prepare($query);
        $req->execute($o->getUserArray()) or die('Error');
    }


    public function update(Users $o){
        $query = "UPDATE citoyen SET nom=?, prenom=?, email=?, password=? , email_verified=? WHERE id=?";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($o-getNom(), $o->getPrenom(), $o->getEmail(), $o->getPassword()));
    }


    public function verifyUser($id){
        $query = "UPDATE citoyen SET email_verifie= TRUE  WHERE id=?";
        $req = $this->conn->getConnexion()->prepare($query);
        $req->execute(array($id));
    }


    


}
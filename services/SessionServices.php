<?php

require_once __DIR__ . '/../Classes/Session.php';
require_once __DIR__ . '/../Classes/Connexion.php';


class SessionServices {

    private $conn;
    private $table = 'session';


    public function __construct(){
        $this->conn = new Connexion();
    }

    public function create(Session $o){
        $query = "INSERT INTO ". $this->table . " VALUES (?,?,?)";
        $req = $this->conn->getConnexion()->prepare($query);
        $stmt =  $req->execute($o->getSessionArray());
        $LAST_ID = $this->conn->getConnexion()->lastInsertId();
        return $LAST_ID;
    }
}
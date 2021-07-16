<?php 

require_once( __DIR__ .'/../Classes/Connexion.php');


class ActualiteServices {

    private $connexion;

    function __construct(){
        $this->connexion = new Connexion();
    }


    public function findAll(){
        $result = array();
        $query = "Select * FROM actualite";
        $req = $this->connexion->getConnexion()->query($query);
        $req->execute();
        while ($e = $req->fetch(PDO::FETCH_OBJ)) {
            $test = [
                "id" => $e->id,
                "image" => $e->image,
                "titre" => $e->titre,
                "date" => $e->date,
                "contenu" => $e->contenu   
            ];
            array_push($result,$test);
        }
        return $result;

    }

    public function findById($id){
        $result = array();
        $query = "Select * FROM actualite WHERE id=?";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($id));
        while ($e = $req->fetch(PDO::FETCH_OBJ)) {
            $test = [
                "id" => $e->id,
                "image" => $e->image,
                "titre" => $e->titre,
                "date" => $e->date,
                "contenu" => $e->contenu   
            ];
            array_push($result,$test);
        }
        return $result;
    }


}
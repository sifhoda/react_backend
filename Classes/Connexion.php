<?php


require_once("app.php");

class Connexion {
    private $connexion;
    
    public function __construct(){
        $host = DB_HOST;
        $dbname = DB_DATABASE;
        $username = DB_USERNAME;
        $password = DB_PASSWORD;
        
        try {
            $dsn = "mysql:host=$host;dbname=$dbname";
            $this->connexion = new PDO($dsn, $username, $password);
            // this next line accept characters that are not pure ascii
            $this->connexion->query("SET NAMES UTF8");
            $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $ex) {
            die('Error: \n' . $ex->getMessage());
        }
    }
    
    // defining a function to get the attribute
    
    function getConnexion() {
        return $this->connexion;
    }


}

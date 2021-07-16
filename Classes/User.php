<?php 



class Users {
    

    private $id;
    private $nom;
    private $prenom;
    private $cne;
    private $date_naissance;
    private $adresse;
    private $tel;
    private $etablissement;
    private $email;
    private $password;
    private $email_verifie=false;
    private $compte_valide=false;

    function __construct($id, $nom, $prenom, $email, $password,$etablissement) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->password = $password;
        $this->etablissement = $etablissement;

        // Secondary declaration 

         
    }
    
    
    


    

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of nom
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Get the value of prenom
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Get the value of cne
     */
    public function getCne()
    {
        return $this->cne;
    }

    /**
     * Get the value of date_naissance
     */
    public function getDateNaissance()
    {
        return $this->date_naissance;
    }

    /**
     * Get the value of adresse
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Get the value of tel
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Get the value of etablissement
     */
    public function getEtablissement()
    {
        return $this->etablissement;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get the value of email_verifie
     */
    public function getEmailVerifie()
    {
        return $this->email_verifie;
    }

    /**
     * Get the value of compte_valide
     */
    public function getCompteValide()
    {
        return $this->compte_valide;
    }


    public function getUserArray(){
        return array(
            $this->getId() ?? NULL,
            $this->getNom() ?? NULL,
            $this->getPrenom() ?? NULL,
            $this->getCne() ?? NULL,
            $this->getDateNaissance() ?? NULL,
            $this->getAdresse() ?? NULL,
            $this->getEmail() ?? NULL,
            $this->getTel() ?? NULL,
            $this->getPassword() ?? NULL,
            $this->getEtablissement() ?? NULL,
            $this->getEmailVerifie(),
            $this->getCompteValide()

        );
    }
}
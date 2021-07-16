<?php



class Session {

    private $id;
    private $citoyen_id;
    private $token;



    public function __construct($id,$citoyen_id,$token){
        $this->id = $id;
        $this->citoyen_id = $citoyen_id;
        $this->token = $token;

    }

    

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of citoyen_id
     */
    public function getCitoyenId()
    {
        return $this->citoyen_id;
    }

    /**
     * Get the value of token
     */
    public function getToken()
    {
        return $this->token;
    }


    public function getSessionArray(){

        return array(
            Null,
            $this->getCitoyenId(),
            $this->getToken()
        );
    }
}
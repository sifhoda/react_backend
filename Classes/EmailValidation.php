<?php




class EmailValidation {

    private $id;
    private $email;
    private $token;
    private $created_at;


    public function __construct($id, $email,$token){
        $this->id = $id;
        $this->email = $email;
        $this->token = $token;
    }


    public function getEmailValidationArray(){
        return array(
            Null,
            $this->getEmail(),
            $this->getToken(),
        );
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the value of token
     */
    public function getToken()
    {
        return $this->token;
    }

    
}
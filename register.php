<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


require_once 'services/UserServices.php';
require_once 'environment.php';
require_once 'Helpers/EmailHelper.php';
require_once 'Helpers/EmailVerification.php';
require_once 'services/EmailValidationServices.php';

function msg($success,$status,$message,$extra = []){
    return array_merge([
        'success' => $success,
        'status' => $status,
        'message' => $message
    ],$extra);
}






// GET DATA FORM REQUEST




$returnData = [];

$errors = [];

// IF REQUEST METHOD IS NOT POST => THE REQUEST MUST BE OF TYPE POST
if($_SERVER["REQUEST_METHOD"] == "POST"):

    $data = json_decode(file_get_contents("php://input"));


    $us = new UserServices();

    /*  VALIDATING USER INPUT */ 


    
    if(!isset($data->nom) || strlen($data->nom) > 60 || !preg_match('/^[a-zA-z- ]+$/', $data->nom) ){
        $errors[] = ["nom" => "Veuillez saisir un nom valide"];
    }
    if(!isset($data->prenom) || strlen($data->prenom) > 60 || !preg_match('/^[a-zA-z- ]+$/', $data->prenom) ){
        $errors[] = ["prenom" => "Veuillez saisir un prenom valide"];
    }
    if(!isset($data->email) || strlen($data->email) > 256 || !filter_var($data->email, FILTER_VALIDATE_EMAIL)){
        $errors[] = ["email" => "Veuillez saisir un email valide"];
    }
    else if(!checkdnsrr(substr($data->email, strpos($data->email, '@') + 1), 'MX')){
        $errors[] = ["email" => "Le domaine saisi n'a pas de serveur de messagerie valide"];
    }else if(!$us->isEmailUnique($data->email)){
        $errors[] = ["email" => "Cette adresse e-mail est déjà utilisée"];   
    }
    if(!isset($data->password) || !preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\~?!@#\$%\^&\*])(?=.{8,})/', $data->password)){
        $errors[] = ["password" => "Votre mot de passe doit contenir d'au moins 8 caractere:\n-Utilisez un mélange de lettres (majuscules et minuscules), de chiffres et de symboles"];
    }
    else if(!isset($data->c_password) || $data->password !== $data->c_password){
        $errors[] = ["c_password" => "Le mot de passe entré n'est pas identique"];
    }
    if(!isset($data->etablissement) || strlen($data->etablissement) > 40 || !preg_match('/^[a-zA-z- ]+$/', $data->etablissement)){
        $errors[] = ['etablissement' => "Veuillez choisir une etablissement valide"];
    }


    /* End of validating the user input */ 


    /* Checking for errors */ 

    if(count($errors) > 0){

        $returnData = msg(0,402,'You have an error', [
            'errors' => array_merge([], ...$errors)
        ]); 

    }else {
        
        $password_salt = $_ENV['SALT'] . $data->password;
        $hashed_password = password_hash($password_salt, PASSWORD_DEFAULT);

        $user = new Users(NULL, $data->nom, $data->prenom, $data->email, $hashed_password,$data->etablissement);


        
        $us->create($user);

        // Sending the Data to the email_verification table 

        $evs = new EmailValidationServices();

        $token = urlencode(base64_encode(random_bytes(20)));

        $ev = new EmailValidation(1, $data->email, $token);

        $evs->create($ev);

        // Creating the body of the email 

        $url = $_ENV['CLIENT_URL'] . 'confirm/' . $token;


        (new EmailHelper())->sendMail($data->email,'Ibrahim Chahboune', 'Verification' , getEmailVerificationMessages($data->nom, $data->prenom, $url) );
        
       
        // send an verification email part here

        $returnData = msg(1,201,'You have successfully registered.'); 



    }


    echo json_encode($returnData);
    
endif;




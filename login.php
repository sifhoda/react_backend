<?php


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


require_once 'services/UserServices.php';
require_once 'environment.php';
require_once 'services/SessionServices.php';



function msg($success,$status,$extra = []){
    return array_merge([
        'success' => $success,
        'status' => $status,
    ],$extra);
}





if($_SERVER["REQUEST_METHOD"] == "POST"):

    $data = json_decode(file_get_contents("php://input"));

    $us = new UserServices();

    $returnData = [];
    $errors = [];

    if(!isset($data->email) || strlen($data->email) > 256 || !filter_var($data->email, FILTER_VALIDATE_EMAIL)){
        $errors[] = ["email" => "Veuillez saisir un email valide"];
    }
    else if(!checkdnsrr(substr($data->email, strpos($data->email, '@') + 1), 'MX')){
        $errors[] = ["email" => "Le domaine saisi n'a pas de serveur de messagerie valide"];
    }else if($us->isEmailUnique($data->email)){
        $errors[] = ["account" => "pas de compte avec l'adresse email fourni"];   
    }
    if(!isset($data->password)){
        $errors[] = ["password" => "Veillez siasir votre mot de passe"];
    }

    if(count($errors) > 0){

        $returnData = msg(0,402, [
            'errors' => array_merge([], ...$errors)
        ]); 

    }
    else {


        $email = $data->email;

        $password_salt = $_ENV['SALT'] . $data->password;



        // Get the user with the following email

        $userData = $us->findByEmail($email);

        $userData = (object) $userData;

        $userData_password = $userData->password;

        if(password_verify($password_salt, $userData_password)){

            // the password is ok

            // create a session

            $token = hash('sha256', time() . $_ENV['SALT']);

            $s = new Session(1, $userData->id , $token);

            $ss = new SessionServices();

            $session_id = $ss->create($s);

            // Returning Session information 

            $returnData = msg(1,201, [
                'sessionData' => [
                    'token' => $token,
                    'id_citoyen' => $userData->id,
                    'nom_citoyen' => $userData->nom,
                    'prenom_citoyen' => $userData->prenom,
                    'etablissement' => $userData->etablissement
                ]
            ]); 
        }else {

            // If the password is incorrect
            
            $returnData = msg(0,402, [
                'errors' => [
                    'account' => 'le mot de passe est incorrect'
                ]
            ]); 
        }
        

    }

    echo json_encode($returnData);

endif;



<?php



header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");



require_once 'services/UserServices.php';
require_once 'services/EmailValidationServices.php';



if($_SERVER["REQUEST_METHOD"] == "POST"):

    $data = json_decode(file_get_contents("php://input"));


    $us = new UserServices();

    $evs = new EmailValidationServices();

    $returnData = [];


    if(!isset($data->token)){
        $returnData = [
            'success' => false
        ];
    } else {

        $token = $data->token;

        $result = $evs->findByToken($token);


        if(count($result) == 0){
            $returnData = [
                'success' => false
            ];

        }else  {

            $id = intval(((object) $result[0])->id);

            $user =  $us->findByEmail(((object) $result[0])->email);

            $user = (object) $user;

            $us->verifyUser(intval($user->id));

            $evs->delete($id);

            
            $returnData = [
                'success' => true
            ];

        }

    }



    echo json_encode($returnData);

    



endif;
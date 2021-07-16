<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Content-type: application/json; charset=utf-8");
header("Access-Control-Allow-Headers: X-Requested-With");
header("Access-Control-Allow-Headers: *");

require_once 'environment.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){

    // getting the raw data
    $json = file_get_contents('php://input');
    // decoding it to a php object
    $data = json_decode($json);

    

    if($data->token){
        // the token exists
        
        $ip = $_SERVER['REMOTE_ADDR'];
        // post request to server
        $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($_ENV['RECAPTCHA_SECRET_KEY']) .  '&response=' . urlencode($data->token);
        $response = file_get_contents($url);
        $responseKeys = json_decode($response,true);
        // should return JSON with success as true
        
        $returnData = [
            'success' => true,
            'isValid' => $responseKeys['success']
        ];
        

    }else {
        $returnData = [
            'success' => false,
        ];
    }

    echo json_encode($returnData);


}







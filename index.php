<?php

header ("Access-Control-Allow-Origin: *");
header ("Access-Control-Expose-Headers: Content-Length, X-JSON");
header ("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
header ("Access-Control-Allow-Headers: *");







// $user = new EmailValidation(1,'ibrahimchahboune@gmail.com','feefg3g1235g35g345ghh');


require_once 'services/SessionServices.php';

$s = new Session(1,1,'feefg3g1235g35g345ghh');

$ss = new SessionServices();

$user = $ss->create($s);

$token = hash('sha256',time() + $user);

echo json_encode($user);

echo json_encode($token);


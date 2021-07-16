<?php



function getEmailVerificationMessages($nom, $prenom, $url){

    $message  = "<html><body>";
   
    $message .= "<div style='text-align:center ; color: black;'>";

    $message .=            "<h2 style='font-weight: bold;'>Bonjour $nom $prenom </h2>";
    $message .=            "<p>Vous avez créé votre compte avec succès</p>";
    $message .=            "<p>Veuillez cliquer sur le lien ci-dessous pour vérifier votre adresse e-mail et terminer l'inscription</p>";
    $message .=            "<br><br>";
    $message .=            "<a style=' text-decoration:none;padding: 15px; border: 1px solid transparent; background: #f08952; color: white; ' href='$url' >Vérifiez votre e-mail</a>";
    $message .=            "<p>ou copiez simplement ce lien dans votre navigateur</p>";
    $message .=            "<p>$url</p>";
    
    $message .= "</div>";

    $message .= "</body></html>";


    return $message;


}


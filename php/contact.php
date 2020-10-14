<?php
    $array = array("prenom" => "", "nom" => "", "email" => "", "phone" => "", "message" => "", "prenomError" => "", "nomError" => "", "emailError" => "", "phoneError" => "", "messageError" => "", "isSuccess" => false);

    $emailTo = "patr74@outlook.fr";

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $array["prenom"] = verifyInput($_POST["prenom"]);
        $array["nom"] = verifyInput($_POST["nom"]);
        $array["email"] = verifyInput($_POST["email"]);
        $array["phone"] = verifyInput($_POST["phone"]);
        $array["message"] = verifyInput($_POST["message"]);
        $array["isSuccess"] = true;
        $emailText = "";

        if(empty($array["prenom"])) {
            $array["prenomError"] = "Je veux connaître ton prénom";
            $array["isSuccess"] = false;
        } else {
            $emailText .= "Prénom : {$array["prenom"]}\n";
        }

        if(empty($array["nom"])) {
            $array["nomError"] = "Eh oui, je veux tout savoir, même ton nom";
            $array["isSuccess"] = false;
        } else {
            $emailText .= "Nom : {$array["nom"]}\n";
        }

        if(!isEmail($array["email"])) {
            $array["emailError"] = "T'essaies de me rouler ? C'est pas un email ça";
            $array["isSuccess"] = false;
        } else {
            $emailText .= "Email : {$array["email"]}\n";
        }

        if(!isPhone($array["phone"])) {
            $array["phoneError"] = "Que des chiffres et des espaces, s'il-te-plaît...";
            $array["isSuccess"] = false;
        } else {
            $emailText .= "Téléphone : {$array["phone"]}\n";
        }

        if(empty($array["message"])) {
            $array["messageError"] = "Qu'est-ce que tu veux me dire ?";
            $array["isSuccess"] = false;
        } else {
            $emailText .= "Message : {$array["message"]}\n";
        }

        if($array["isSuccess"]) {
            $thanks = "Votre message a bien été envoyé. Merci de m'avoir contacté !";
            $headers = "From: {$array["prenom"]} {$array["nom"]} <{$array["email"]}>\r\nReply-To: {$array["email"]}";
            mail($emailTo, "Un message du site CV !", $emailText, $headers);
        }
        
        echo json_encode($array);
    }

    function isPhone($var){
        return preg_match("/^[0-9 ]*$/", $var);
    }

    function isEmail($var){
        return filter_var($var, FILTER_VALIDATE_EMAIL);
    }

    function verifyInput($var){
        $var = trim($var);
        $var = stripslashes($var);
        $var = htmlspecialchars($var);
        return $var;
    }
?>
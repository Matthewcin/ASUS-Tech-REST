<?php

function checkAuth($req, $res) {
    $apiSecret = "asusadmin:root"; // YXN1c2FkbWluOnJvb3Q=
    $headers = getallheaders(); 

    // 1. Revisar si mandaron el header Authorization
    if(!isset($headers['Authorization'])){
        return $res->json("Falta el Header 'Authorization'", 401);
    }

    $authHeader = $headers['Authorization'];

    // 2. Debe comenzar con "Basic "
    if(strpos($authHeader, 'Basic ') !== 0){
        return $res->json("Formato de Authorization Incorrecto! (Debe ser Basic)", 401);
    }

    // 3. Tomamos solo la parte codificada en Base64
    $encodedCredentials = str_replace('Basic ', '', $authHeader);

    // 4. Decodificamos
    $decodedCredentials = base64_decode($encodedCredentials);

    // 5. Comparamos con tus credenciales reales
    if($decodedCredentials !== $apiSecret){
        return $res->json("Credenciales Incorrectas!", 403);
    }

    // Si todo va bien → Permitimos continuar
    return true;
}

function verificarCredencialesAPI($req,$res){
    $auth = checkAuth($req,$res);
    if($auth !==true){
        return false;
    }
    return true;
}
?>
<?php
require_once 'app/models/auth.model.php';

function verificarCredencialesAPI($req, $res) {
    if (empty($req->authorization)) {
        $res->json("Falta el Header 'Authorization'", 401);
        return false;
    }

    $authHeader = $req->authorization;

    // Valido la estructura Basic
    if (strpos($authHeader, 'Basic ') !== 0) {
        $res->json("Formato de Authorization Incorrecto! (Debe ser Basic)", 401);
        return false;
    }

    // 3. Decodificar
    $encodedCredentials = substr($authHeader, 6); // Quitar "Basic "
    $decodedCredentials = base64_decode($encodedCredentials);
    $userPassArray = explode(':', $decodedCredentials);

    // Validar que sea user:pass
    if(count($userPassArray) != 2) {
        $res->json("Formato usuario:contraseña inválido", 401);
        return false;
    }

    $username = $userPassArray[0];
    $password = $userPassArray[1];

    // Verifico en la DB
    $authModel = new authModel();
    if (!$authModel->getLogin($username, $password)) {
        $res->json("Credenciales Incorrectas o Usuario inexistente", 403);
        return false;
    }

    // Si pasó todo, devuelvo true
    return true;
}

// PROFE, ACA AHORA LO QUE ARREGLE ES QUE VERIFICO EN LA DB LAS CREDENCIALES ANTES NO LO HABIA HECHO
?>

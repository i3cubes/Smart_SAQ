<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

//
require_once('../vendor/autoload.php');

include_once '../class/constants.php';

if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
    if (!preg_match('/Bearer\s(\S+)/', $_SERVER['HTTP_AUTHORIZATION'], $matches)) {
        header('HTTP/1.0 400 Bad Request');
        echo 'Token not found in request';
        exit;
    }
    $jwt = $matches[1];
    if (!$jwt) {
        // No token was able to be extracted from the authorization header
        header('HTTP/1.0 400 Bad Request');
        exit;
    }

    $secretKey = constants::$secretKey;

    if ($jwt != 'undefined') {
        try {
            $token = JWT::decode($jwt, new Key($secretKey, 'HS512'));
        } catch (\Firebase\JWT\ExpiredException $e) {
            echo json_encode(array('msg' => 'Session expired!!!', 'result' => 1));
            session_destroy();
            exit();
        }
    }


    $now = new DateTimeImmutable();
    $serverName = constants::$serverName;

    if ($token->iss !== $serverName ||
            $token->nbf > $now->getTimestamp() ||
            $token->exp < $now->getTimestamp()) {
        session_destroy();
        echo json_encode(array('msg' => 'Session expired!!!', 'result' => 1));
    } else {
        echo json_encode(array('msg' => 'Session alive!!!', 'result' => 0));
    }
} else {
    session_destroy();
    echo json_encode(array('msg' => 'Session expired!!!', 'result' => 1));
}
?>
<?php

//error_reporting(E_ALL);
//ini_set("display_errors", 1);
session_start();

//declare(strict_types=1);
//
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

//
require_once('../vendor/autoload.php');

include_once '../class/cls_user.php';
include_once '../class/constants.php';

//var_dump($_SERVER['HTTP_AUTHORIZATION']);
$option = $_POST['option'];
if ($option != 'LOGIN') {
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
            header('HTTP/1.1 401 Unauthorized');
            exit;
        }
    } else {
        echo json_encode(array('msg' => 'Session expired!!!', 'result' => 1));
        session_destroy();
    }
}


$u_obj = new user($_POST['id']);

$u_obj->name = $_POST['username'];
$u_obj->password = $_POST['password'];
$u_obj->saq_us_role_id = $_POST['role'];

switch ($option) {
    case 'LOGIN':
        $result = $u_obj->loginUser();
        if ($result === true) {
            $u_obj = new user($_SESSION['UID']);
            $u_obj->getDetails();

            $secretKey = constants::$secretKey;
            $issuedAt = new DateTimeImmutable();
            $expire = $issuedAt->modify('+30 minutes')->getTimestamp();
            $serverName = constants::$serverName;
            $username = $u_obj->name;

            $data = [
                'iat' => $issuedAt->getTimestamp(), // Issued at: time when the token was generated
                'iss' => $serverName, // Issuer
                'nbf' => $issuedAt->getTimestamp(), // Not before
                'exp' => $expire, // Expire
                'userName' => $username, // User name
            ];

            $JWT_TOKEN = JWT::encode($data, $secretKey, 'HS512');

            echo json_encode(array('msg' => 1, 'token' => $JWT_TOKEN));
        } else if ($result == 100) {
            echo json_encode(array('msg' => 100));
        } else {
            echo json_encode(array('msg' => 0));
        }
        break;
    case 'ADDUSER':
        $result = $u_obj->add();
        if ($result === true) {
            echo json_encode(array('msg' => 1));
        } else if ($result == 100) {
            echo json_encode(array('msg' => 2));
        } else {
            echo json_encode(array('msg' => 0));
        }
        break;
    case 'EDITUSER':
        $result = $u_obj->edit();
        if ($result === true) {
            echo json_encode(array('msg' => 1));
        } else if ($result == 100) {
            echo json_encode(array('msg' => 2));
        } else {
            echo json_encode(array('msg' => 0));
        }
        break;
    case 'PASSWORDRESET':
        $result = $u_obj->edit();
        if ($result) {
            echo json_encode(array('msg' => 1));
        } else {
            echo json_encode(array('msg' => 0));
        }
        break;
    case 'CHANGESTATUS':
        $uid = $_POST['id'];
        $status = $_POST['status'];

        if ($status == 'D') {
            $u_obj->status = constants::$DELETED;
            $u_obj->wrong_attempt = '5';
        } else if ($status == 'E') {
            $u_obj->status = constants::$active;
            $u_obj->wrong_attempt = '0';
        }
        $result = $u_obj->edit();
        if ($result) {
            echo json_encode(array('msg' => 1));
        } else {
            echo json_encode(array('msg' => 0));
        }
        break;
    default :
        header('HTTP/1.0 405 Method Not Allowed');
        break;
}
?>
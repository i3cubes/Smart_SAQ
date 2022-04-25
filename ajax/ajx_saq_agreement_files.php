<?php

use Firebase\JWT\JWT;

//
require_once('../vendor/autoload.php');
include_once '../class/cls_agreement_model.php';

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
$token = JWT::decode($jwt, $secretKey, ['HS512']);
$now = new DateTimeImmutable();
$serverName = constants::$serverName;

if ($token->iss !== $serverName ||
        $token->nbf > $now->getTimestamp() ||
        $token->exp < $now->getTimestamp()) {
    header('HTTP/1.1 401 Unauthorized');
    exit;
}

$agreement_model_obj = new agreement_model($_REQUEST['id']);

switch ($_REQUEST['option']) {
    case 'ADD':
        // upload file if uploded
        if (!empty($_FILES)) {
            $test = explode(".", $_FILES['file']['name']);
            $extension = end($test);
            $newName = time() . rand(100, 999) . "." . $extension;
            $location = "files/sample_agreements/" . $newName;
            $save_to = "../files/sample_agreements/" . $newName;
            $file_name = $_FILES['file']['name'];
            if (move_uploaded_file($_FILES['file']['tmp_name'], $save_to)) {
                $result = $agreement_model_obj->addFile($_FILES['file']['type'], $file_name, $location);
                if ($result) {
                    echo json_encode(array('msg' => 1));
                } else {
                    echo json_encode(array('msg' => 0));
                }
            }
        } else {
            echo json_encode(array('msg' => 0));
        }
        break;
    case 'VIEW':
        $view_agreement_file = $agreement_model_obj->getFiles();
        echo json_encode($view_agreement_file);
        break;
    case 'DELETE':
        $delete_file = $agreement_model_obj->deleteFile($_REQUEST['id']);
        if ($delete_file) {
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
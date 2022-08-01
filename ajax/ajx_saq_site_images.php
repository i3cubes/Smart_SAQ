<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require_once('../vendor/autoload.php');

include_once '../class/cls_site_model.php';

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
$now = new DateTimeImmutable();
$serverName = constants::$serverName;

if ($token->iss !== $serverName ||
        $token->nbf > $now->getTimestamp() ||
        $token->exp < $now->getTimestamp()) {
    header('HTTP/1.1 401 Unauthorized');
    exit;
}
$site_model_obj = new site_model($_REQUEST['id']);

switch ($_REQUEST['option']) {
    case 'ADD':
        // upload file if uploded
        if (!empty($_FILES)) {
            $test = explode(".", $_FILES['file']['name']);
            $extension = end($test);
            if ($extension == 'jpeg' || $extension == 'jpg' || $extension == 'png' || $extension == 'gif') {
                $newName = time() . rand(100, 999) . "." . $extension;
                $location = "files/site_images/" . $newName;
                $save_to = "../files/site_images/" . $newName;
                $file_name = $_FILES['file']['name'];
                if (move_uploaded_file($_FILES['file']['tmp_name'], $save_to)) {
                    $result = $site_model_obj->addImage($_FILES['file']['type'], $file_name, $location);
                    if ($result) {
                        echo json_encode(array('msg' => 1));
                    } else {
                        echo json_encode(array('msg' => 0));
                    }
                }
            } else {
                echo json_encode(array('msg' => -1));
            }
        } else {
            echo json_encode(array('msg' => 0));
        }
        break;
    case 'VIEW':
        $view_saq_site_image = $site_model_obj->getImages();
        echo json_encode($view_saq_site_image);
        break;
    case 'DELETE':
        $id = $_REQUEST['id'];
        $delete_file = $site_model_obj->deleteImage($id);
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
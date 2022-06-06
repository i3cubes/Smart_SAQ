<?php

use Firebase\JWT\JWT;

//
require_once('../vendor/autoload.php');

include_once '../class/cls_agreement_model.php';
//include_once '../class/cls_tree_node.php';
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
            $token = JWT::decode($jwt, $secretKey, ['HS512']);
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

//$tree_node_obj = new tree_node();
$saq_agreement_model_obj = new agreement_model();

$saq_agreement_model_obj->name = $_REQUEST['name'];
$saq_agreement_model_obj->parent_id = $_REQUEST['parent_agreement_id'];

switch ($_REQUEST['option']) {
    case 'ADD':
        $result = $saq_agreement_model_obj->save();
        if ($result) {
            echo json_encode(array('msg' => 1));
        } else {
            echo json_encode(array('msg' => 0));
        }
        break;
    case 'EDIT':
        $saq_agreement_model_obj->id = $_REQUEST['id'];
        $result = $saq_agreement_model_obj->edit();
        if ($result) {
            echo json_encode(array('msg' => 1));
        } else {
            echo json_encode(array('msg' => 0));
        }
        break;
    case 'VIEW':
        break;
    case 'DELETE':
        $saq_agreement_model_obj->id = $_REQUEST['id'];
        $result = $saq_agreement_model_obj->delete();
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
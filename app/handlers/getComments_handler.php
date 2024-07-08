<?php

require_once '../config/config.php';
require_once '../core/model.php';
require_once '../core/db.php';
require_once '../models/User_Model.php';
require_once '../models/Comment_Model.php';

$rawData = file_get_contents('php://input');
$data = json_decode($rawData, true);
$imageId = isset($data['id']) ? $data['id'] : null;

if (!$imageId) {
    $response = [
        'status' => 'error',
        'message' => 'Не передан ID изображения',
    ];
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

$comments = Comment_model::getComments($imageId);

if ($comments) {
    for ($i = 0; $i < count($comments); $i++) {
        $comments[$i]['username'] = User_Model::getUserById($comments[$i]['user_id'])['name'];
    }
    $user = User_Model::check();
    $response = [
        'status' => 'success',
        'comments' => $comments,
        'currentUserId' => ($user ? $user['id'] : null),
    ];
} else {
    $response = [
        'status' => 'error',
        'message' => 'Нет комментариев к этому изображению',
    ];
}

header('Content-Type: application/json');
echo json_encode($response);

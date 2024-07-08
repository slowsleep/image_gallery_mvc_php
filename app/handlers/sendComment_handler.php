<?php

require_once '../config/config.php';
require_once '../core/model.php';
require_once '../core/db.php';
require_once '../models/User_Model.php';
require_once '../models/Comment_Model.php';

$_POST['comment'] = trim($_POST['comment']);

$user = User_Model::check();
if ($user) {

    $newComment = Comment_Model::add($_POST['image_id']);

    if ($newComment) {
        $newComment['username'] = User_Model::getUserById($newComment['user_id'])['name'];
        $result = [
            'status' => 'success',
            'comment' => $newComment
        ];
    } else {
        $result = [
            'status' => 'error',
            'message' => 'Произошла ошибка при добавлении комментария'
        ];
    }
} else {
    $result = [
        'status' => 'error',
        'message' => 'Вы не авторизованы'
    ];
}

header('Content-Type: application/json');
echo json_encode($result);

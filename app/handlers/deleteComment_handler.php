<?php

require_once '../config/config.php';
require_once '../core/model.php';
require_once '../core/db.php';
require_once '../models/User_Model.php';
require_once '../models/Comment_Model.php';

$rawData = file_get_contents('php://input');
$data = json_decode($rawData, true);

$commentId = isset($data['id']) ? $data['id'] : null;

if (!$commentId) {
    $response = [
        'status' => 'error',
        'message' => 'Не передан ID комментария',
    ];
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

$user = User_Model::check();
if ($user) {
    if (Comment_model::delete($commentId)) {
        $response = [
            'status' => 'success',
            'message' => 'Комментарий успешно удален',
        ];
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Произошла ошибка при удалении комментария',
        ];
    }
} else {
    $response = [
        'status' => 'error',
        'message' => 'Вы не авторизованы',
    ];
}

header('Content-Type: application/json');
echo json_encode($response);

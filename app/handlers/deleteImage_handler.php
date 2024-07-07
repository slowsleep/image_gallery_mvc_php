<?php

require_once '../config/config.php';
require_once '../core/model.php';
require_once '../core/db.php';
require_once '../models/User_Model.php';
require_once '../models/Image_Model.php';

$rawData = file_get_contents('php://input');
$data = json_decode($rawData, true);

$imageId = isset($data['id']) ? $data['id'] : null;

$user = User_Model::check();

if ($user) {
    $image = Image_Model::getImageById($imageId);
    if ($image && $image['user_id'] == $user['id']) {
        if (Image_Model::deleteImage($imageId)) {
            $response = [
                'status' => 'success',
                'message' => 'Изображение успешно удалено',
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Произошла ошибка при удалении изображения',
            ];
        }
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Недостаточно прав для удаления изображения',
        ];
    }
} else {
    $response = [
        'status' => 'error',
        'message' => 'Недостаточно прав для удаления изображения',
    ];
}

header('Content-Type: application/json');
echo json_encode($response);

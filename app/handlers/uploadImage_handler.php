<?php

require_once '../config/config.php';
require_once '../core/model.php';
require_once '../core/db.php';
require_once '../models/user_model.php';
require_once '../models/image_model.php';

error_log(print_r($_FILES['image'], true));
$images = $_FILES['image'] ?? [];
$result = [];
$errors = [];

if (!empty($images)) {

    for ($i = 0; $i < count($_FILES['image']['name']); $i++) {
        $fileName = $_FILES['image']['name'][$i];

        if ($_FILES['image']['size'][$i] > UPLOAD_MAX_SIZE) {
            $errors[]["image"] = 'Недопустимый размер файла ' . $fileName;
            break;
        }
        if (!in_array($_FILES['image']['type'][$i], ALLOWED_TYPES)) {
            $errors[]["image"] = 'Недопустимый формат файла ' . $fileName;
            break;
        }

        $filePath = UPLOAD_DIR . '/' . basename($fileName);

        if (!move_uploaded_file($_FILES['image']['tmp_name'][$i], $filePath)) {
            $errors[]["image"] = 'Ошибка загрузки файла ' . $fileName;
            break;
        }
    }
} else {
    $errors[]["image"] = 'Картинка не выбрана';
}

if (empty($errors)) {
    $uploaded_images = Image_Model::uploadImage($fileName);

    if (!$uploaded_images) {
        $errors[]["image"] = 'Не удалось загрузить изображение ' . $fileName;
    } else {
        $result = [
            "data" => $fileName,
            "status" => "success"
        ];
    }

}

if (!empty($errors)) {
    $result = [
        "data" => $errors,
        "status" => "error"
    ];
}

echo json_encode($result);

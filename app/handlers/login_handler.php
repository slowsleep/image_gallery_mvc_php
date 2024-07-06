<?php

require_once '../config/config.php';
require_once '../core/model.php';
require_once '../models/user_model.php';
require_once '../core/db.php';

$data = array($_POST['name'], $_POST['password']);
$errors = [];
$result = [];

if (empty($_POST['name']) || empty($_POST['password'])) {
    $errors[]["form"] = 'Все поля должны быть заполнены';
} else {
    $user = User_Model::login($_POST['name'], $_POST['password']);
    if ($user) {
        setcookie('id', $user['id'], time() + (60 * 60 * 24 * 30), '/', '', false, true);
        setcookie('hash', $user['hash'], time() + (60 * 60 * 24 * 30), '/', '', false, true);
        $result = [
            "message" => 'Вход выполнен',
            "status" => "success"
        ];
    } else {
        $errors[]["form"] = 'Неправильное имя или пароль';
    }
}

if (!empty($errors)) {
    $result = [
        "data" => $errors,
        "status" => "error"
    ];
}

echo json_encode($result);

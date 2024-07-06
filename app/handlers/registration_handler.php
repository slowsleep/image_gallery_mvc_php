<?php

require_once '../config/config.php';
require_once '../core/model.php';
require_once '../models/user_model.php';
require_once '../core/db.php';

$data = array($_POST['name'], $_POST['password'], $_POST['repeat-password']);
$errors = [];
$result = [];

if (empty($_POST['name']) || empty($_POST['password']) || empty($_POST['repeat-password'])) {
    $errors[]["form"] = 'Все поля должны быть заполнены';
} elseif ($_POST['password'] != $_POST['repeat-password']) {
    $errors[]["repeat-password"] = 'Пароли не совпадают';
} elseif ($_POST['password'] == $_POST['repeat-password'] && strlen($_POST['password']) < 5) {
    $errors[]["password"] = 'Пароль слишком короткий. Длина пароля должна быть не менее 5 символов';
}

if (!empty($_POST['name'])) {
    $db = new DB();
    $db = $db->connect();

    $stmt = $db->prepare("SELECT * FROM users WHERE name = :name");
    $stmt->execute([
        'name' => $_POST['name'],
    ]);

    if ($stmt->rowCount() > 0) {
        $errors[]["name"] = 'Пользователь с таким именем уже существует';
    }
}

if (!empty($errors)) {
    $result = [
        "data" => $errors,
        "status" => "error"
    ];
} else {
    $register_user = User_Model::register($_POST['name'], $_POST['password']);

    if ($register_user) {
        $result = [
            "message" => 'Регистрация прошла успешно',
            "status" => "success"
        ];
    } else {
        $result = [
            "data" => ["message" => 'Регистрация не удалась'],
            "status" => "error"
        ];
    }
}

echo json_encode($result);

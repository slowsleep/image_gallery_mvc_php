<?php

class User_Model extends Model
{
    public static function getUserById($id) {
        $query = "SELECT * FROM users WHERE id = :id";
        $db = new DB();
        $db = $db->connect();
        $stmt = $db->prepare($query);
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch();

        if ($stmt && $user) {
            return $user;
        }

        return false;
    }

    public static function register($name, $password)
    {
        $query = "INSERT INTO users (name, password, created_at) VALUES (:name, :password, :created_at)";
        $passhash = password_hash($password, PASSWORD_DEFAULT);
        $db = new DB();
        $db = $db->connect();
        $stmt = $db->prepare($query);
        $stmt->execute([
            'name' => $name,
            'password' => $passhash,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        if (!$stmt) {
            return false;
        }

        return true;
    }

    public static function login($name, $password)
    {
        $query = "SELECT * FROM users WHERE name = :name";
        $db = new DB();
        $db = $db->connect();
        $stmt = $db->prepare($query);
        $stmt->execute([
            'name' => $name,
        ]);

        if (!$stmt) {
            return false;
        }

        $user = $stmt->fetch();

        if (!$user) {
            return false;
        }

        if (password_verify($password, $user['password'])) {
            $user_hash = $user['hash'] ?? '';

            if (empty($user_hash)) {
                $user_hash = hash('sha256', $user['id'] . SECRET_KEY);
                $query = "UPDATE users SET hash = :hash WHERE id = :id";
                $stmt = $db->prepare($query);
                $stmt->execute([
                    'hash' => $user_hash,
                    'id' => $user['id'],
                ]);
                $user['hash'] = $user_hash;
            }
            return $user;
        }
        return false;
    }

    public static function logout()
    {
        setcookie('id', '', time() - 60 * 60 * 24 * 30, '/');
        setcookie('hash', '', time() - 60 * 60 * 24 * 30, '/', '', false, true);
        header('Location: /');
    }

    public static function check()
    {
        if (isset($_COOKIE['id']) && isset($_COOKIE['hash'])) {
            $query = "SELECT * FROM users WHERE id = :id AND hash = :hash";
            $db = new DB();
            $db = $db->connect();
            $stmt = $db->prepare($query);
            $stmt->execute([
                'id' => $_COOKIE['id'],
                'hash' => $_COOKIE['hash'],
            ]);
            $user = $stmt->fetch();
            if ($user) {
                return $user;
            }
        }
        return false;
    }
}

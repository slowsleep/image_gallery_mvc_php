<?php

class Comment_model extends Model
{
    public static function add($image_id) {
        $user = User_Model::check();

        if (!$user) {
            return false;
        }

        $query = "INSERT INTO comments (image_id, user_id, content, created_at) VALUES (:image_id, :user_id, :comment, :created_at)";
        $db = new DB();
        $db = $db->connect();
        $stmt = $db->prepare($query);
        $stmt->execute([
            'image_id' => $image_id,
            'user_id' => $user['id'],
            'comment' => $_POST['comment'],
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $query = "SELECT * FROM comments WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->execute(['id' => $db->lastInsertId()]);
        $comment = $stmt->fetch();

        if ($stmt && $comment) {
            return $comment;
        }

        return false;
    }

    public static function getComments($image_id) {
        $query = "SELECT * FROM comments WHERE image_id = :image_id";
        $db = new DB();
        $db = $db->connect();
        $stmt = $db->prepare($query);
        $stmt->execute(['image_id' => $image_id]);
        $comments = $stmt->fetchAll();

        if ($stmt) {
            return $comments;
        }

        return false;
    }

    public static function delete($comment_id) {
        $query = "DELETE FROM comments WHERE id = :id";
        $db = new DB();
        $db = $db->connect();
        $stmt = $db->prepare($query);
        $stmt->execute(['id' => $comment_id]);

        if ($stmt) {
            return true;
        }

        return false;
    }

}

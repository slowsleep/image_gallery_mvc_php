<?php

class Image_Model extends Model
{
    public static function uploadImage($image)
    {
        $check = User_Model::check();
        if ($check) {
            $query = "INSERT INTO images (file, user_id ,created_at) VALUES (:file, :user_id ,:created_at)";
            $db = new DB();
            $db = $db->connect();
            $stmt = $db->prepare($query);
            $stmt->execute([
                'file' => $image,
                'user_id' => $check['id'],
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            if ($stmt) {
                return true;
            }
        }
        return false;
    }

    public static function getImages()
    {
        $query = "SELECT * FROM images";
        $db = new DB();
        $db = $db->connect();
        $stmt = $db->prepare($query);
        $stmt->execute();
        $images = $stmt->fetchAll();
        return $images;
    }
}

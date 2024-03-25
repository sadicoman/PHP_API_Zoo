<?php
abstract class Model
{
    protected function getBdd()
    {
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=dbanimaux;charset=utf8', 'root', '');
        } catch (Exception $e) {
            throw new Exception('Erreur : ' . $e->getMessage());
        }

        return $pdo;
    }

    public static function sendJSON($info)
    {
        header('Content-Type: application/json');
        echo json_encode($info);
    }
}

<?php

require_once __DIR__ . '/../Config/cors.php';
require_once __DIR__ . '/../Class/BasicUser.php';

class CreateAccountController
{
    public static function handle()
    {
        header("Content-Type: application/json");

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(["code" => 405, "message" => "Méthode non autorisée"]);
            exit();
        }

        $input = file_get_contents('php://input');
        $data = json_decode($input, true);

        if (!$data || !isset($data['name'], $data['email'], $data['password'])) {
            echo json_encode(["code" => 400, "message" => "Données invalides"]);
            exit();
        }

        $name = trim($data['name']);
        $email = trim($data['email']);
        $password = trim($data['password']);

        $basicUser = new BasicUser($name, $email, $password);
        $response = $basicUser->createAccount($name, $email, $password);

        echo $response;
    }
}

<?php

if(session_status() == PHP_SESSION_NONE) {
    session_start();
}


class GetUserInfoController 
{

    public static function handle()
    {
        header("Content-type: application/json");

        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            echo json_encode(["code" => 405, "message" => "Méthode non autorisée"]);
            exit();
        }

        if (!isset($_SESSION['user'])) {
            echo json_encode(["code" => 400, "message" => "Vous n'êtes pas connecté"]);
            exit();
        }

        $name = $_SESSION['user']['name'];
        $email = $_SESSION['user']['email'];


        $user = new BasicUser($email);
        $response = $user->getUserInfo($email);

        echo $response;
    }
}
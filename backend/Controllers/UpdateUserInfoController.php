<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


class UpdateUserInfoController
{
    public static function handle()
    {
        header("Content-type: application/json");
        require_once __DIR__ . '/../Class/BasicUser.php';

        if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
            echo json_encode(["code" => 405, "message" => "Méthode non autorisée"]);
            exit();
        }

        if (!isset($_SESSION['user'])) {
            echo json_encode(["code" => 400, "message" => "Vous n'êtes pas connecté"]);
            exit();
        }

        $input = file_get_contents('php://input');
        $data = json_decode($input, true);

        if(!$data || !isset($data['newName'], $data['newEmail'])) {
            echo json_encode(["code" => 400, "message" => "Données invalides"]);
            exit();
        }


        $newName = trim($data['newName']);
        $newEmail = trim($data['newEmail']);
        $id = $_SESSION['user']['id'];
        $actualEmail = $_SESSION['user']['email'];


        
        $user = new BasicUser($actualEmail);
        $response = $user->updateInfo($id, $newName, $newEmail);

        
        if($response['status'] === true) {
            $_SESSION['user']['name'] = $newName;
            $_SESSION['user']['email'] = $newEmail;
        }

        echo json_encode($response);




    }
}
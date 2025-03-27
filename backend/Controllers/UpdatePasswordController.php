<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

class UpdatePasswordController
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

        if(!$data || !isset($data['newPassword'])) {
            echo json_encode(["code" => 400, "message" => "Données invalides"]);
            exit();
        }

        $newPassword = trim($data['newPassword']);
        $email = $_SESSION['user']['email'];

        $user = new BasicUser($email);
        $response = $user->updatePassword($email, $newPassword);

        echo json_encode($response);
    }

}
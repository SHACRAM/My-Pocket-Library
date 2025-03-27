<?php
Session_start();
require_once __DIR__ . '/../Config/cors.php';
require_once __DIR__ . '/../Class/BasicUser.php';

class UserLoginController 
{

    public static function handle()
{
    header("Content-type: application/json");

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(["code" => 405, "message" => "Méthode non autorisée"]);
        exit();
    }

    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if (!$data || !isset($data['email'], $data['password'])) {
        echo json_encode(['code' => 400, 'message' => 'Informations incorrectes']);
        exit();
    }

    $email = trim($data['email']);
    $password = trim($data['password']);

    $connectUser = new BasicUser($email, $password);
    $response = json_decode($connectUser->login($email, $password), true);

    // Gère la session en cas de succès
    if ($response['status'] === true) {
        $_SESSION['user'] = $response['userData'];
    } else {
        unset($_SESSION['user']);
    }


    // Retourne la réponse finale en JSON
    echo json_encode($response);
}

}


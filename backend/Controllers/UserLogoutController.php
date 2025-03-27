<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../Config/cors.php';
require_once __DIR__ . '/../Class/BasicUser.php';


class UserLogoutController
{
    public static function handle()
    {
        header("Content-type: application/json");

        

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(["code" => 405, "message" => "Méthode non autorisée"]);
            exit();
        }
        
        if (!isset($_SESSION['user'])) {
            echo json_encode(["code" => 400, "message" => "Vous n'êtes pas connecté"]);
            exit();
        }

        setcookie(session_name(), '', time() - 3600, '/');
        session_unset();  // Libère toutes les variables de session
        session_destroy();  // Détruit la session

        echo json_encode([
            'status' => true,
            'code' => 200,
            'message' => 'Déconnexion réussie'
        ]);
    }
}
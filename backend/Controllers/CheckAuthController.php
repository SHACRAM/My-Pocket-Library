<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../Config/cors.php';
require_once __DIR__ . '/../Class/BasicUser.php';

class CheckAuthController
{
    public static function handle()
    {
        
        header("Content-type: application/json");
        
        // Vérifie si la session utilisateur existe
        if (isset($_SESSION['user'])) {
            echo json_encode([
                "authenticated" => true,
                "user" => $_SESSION['user']

            ]);
        } else {
            echo json_encode([
                "authenticated" => false,
                "message" => "Utilisateur non connecté"
            ]);
        }
    }

}



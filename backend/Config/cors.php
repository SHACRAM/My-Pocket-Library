<?php
header("Access-Control-Allow-Origin: http://localhost:5173");  // Permet seulement l'origine de ton front-end
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");  // Méthodes autorisées
header("Access-Control-Allow-Headers: Content-Type, Authorization");  // En-têtes autorisés
header("Access-Control-Allow-Credentials: true");  // Permet d'envoyer les cookies

// Réponse pour les requêtes OPTIONS préalables (CORS)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(204);
    exit();
}

?>

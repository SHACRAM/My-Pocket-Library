<?php
require_once __DIR__ . '/Config/cors.php';

$requestUri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$requestUri = trim($requestUri, '/');

$requestMethod = $_SERVER['REQUEST_METHOD'];


// Charger les fichiers de routes
require_once __DIR__ . '/Routes/userRoutes.php';
require_once __DIR__ . '/Routes/bookRoutes.php';

// Fusionner les routes disponibles
$routes = array_merge_recursive($userRoutes, $bookRoutes);


// Vérifier si la route demandée existe
if (isset($routes[$requestMethod][$requestUri])) {
    call_user_func($routes[$requestMethod][$requestUri]);
} else {
    http_response_code(404);
    echo json_encode(["error" => "Route not found"]);
}

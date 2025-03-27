<?php

require_once __DIR__ . '/../Controllers/CreateAccountController.php';
require_once __DIR__ . '/../Controllers/UserLoginController.php';
require_once __DIR__ . '/../Controllers/UserLogoutController.php';
require_once __DIR__ . '/../Controllers/CheckAuthController.php';
require_once __DIR__ . '/../Controllers/GetUserInfoController.php';
require_once __DIR__ . '/../Controllers/UpdateUserInfoController.php';
require_once __DIR__ . '/../Controllers/UpdatePasswordController.php';

$userRoutes = [
    "POST" => [
        "createAccount" => [CreateAccountController::class, 'handle'],
        "login" => [UserLoginController::class, 'handle'],
        "logout" => [UserLogoutController::class, 'handle'],
        "checkAuth" => [CheckAuthController::class, 'handle'],
        
    ],
    "GET"=> [
        "userInformations" => [GetUserInfoController::class, 'handle']
    ],

    "PUT" => [
        "updateInfo" => [UpdateUserInfoController::class, 'handle'],
        "updatePassword" => [UpdatePasswordController::class, 'handle']
    ]





];

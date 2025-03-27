<?php


require_once __DIR__ . "/../Controllers/AddToCollectionController.php";
require_once __DIR__ . "/../Controllers/CountAllBooksController.php";
require_once __DIR__ . "/../Controllers/GetAllBooksController.php";
require_once __DIR__ . "/../Controllers/DeleteBookController.php";

$bookRoutes = [
    "POST" =>[
        "addToCollection"=> [AddToCollectionController::class, 'handle'],
        "deleteBook"=> [DeleteBookController::class, 'handle']
    ],
    "GET"=>[
        "countAllBooks"=> [CountAllBooksController::class, 'handle'],
        "getAllBooks"=> [GetAllBooksController::class, 'handle']
    ]
    ];


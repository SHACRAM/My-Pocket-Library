<?php

if(session_status() == PHP_SESSION_NONE) {
    session_start();
}


class CountAllBooksController
{
    public static function handle()
    {
        require_once __DIR__ . '/../Class/Book.php';
        $user_id = $_SESSION['user']['id'];
        $book = new Book();
        $response = $book->getCountAllBooks($user_id);
        echo json_encode($response);
    }
}
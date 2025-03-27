<?php
if(session_status() == PHP_SESSION_NONE) {
    session_start();
}

class GetAllBooksController
{
    public static function handle()
    {

        require_once __DIR__ . '/../Class/Book.php';

        if (!isset($_SESSION['user']))
        {
            return [
                'status' => false,
                'code' => 400,
                'message' => 'Vous devez être connecté pour ajouter un livre'
            ];
        }

        $user_id = $_SESSION['user']['id'];
        $book = new Book();
        $response = $book->getAllBooks($user_id);

        echo json_encode($response); 

    }
 


}




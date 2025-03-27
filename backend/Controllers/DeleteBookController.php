<?php
if(session_status() == PHP_SESSION_NONE) {
    session_start();
}

class DeleteBookController
{

    public static function handle()
    {
        require_once __DIR__ . '/../Class/Book.php';

        $payload = file_get_contents("php://input");
        $data = json_decode($payload, true);
    
    if (!isset($_SESSION['user']))
    {
        return [
            'status' => false,
            'code' => 400,
            'message' => 'Vous devez être connecté pour ajouter un livre'
        ];
    }

    $user_id = $_SESSION['user']['id'];
    $book_id = $data['id'];

    $book = new Book();
    $response = $book->deleteBook($book_id, $user_id);

    echo json_encode($response);
    }
}
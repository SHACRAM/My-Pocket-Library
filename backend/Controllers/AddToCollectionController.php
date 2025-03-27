<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../Class/Book.php';

class AddToCollectionController
{

    public static function handle()
    {

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

        if (!isset($data ['payload']['name'], $data ['payload']['author'], $data ['payload']['image'], $data ['payload']['isbn']))
        {
            return [
                'status' => false,
                'code' => 400,
                'message' => 'Données manquantes'
            ];
        }

        $name = trim($data ['payload']['name']);
        $author = trim($data ['payload']['author']);
        $image = trim($data ['payload']['image']);
        $isbn = trim($data ['payload']['isbn']);
        $user_id = $_SESSION['user']['id'];

        $book = new Book($name, $author, $image, $isbn);
        $response = $book->addToCollection($name, $author, $image, $isbn, $user_id);

        echo json_encode($response);
    }


}
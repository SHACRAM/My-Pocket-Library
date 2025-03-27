<?php

require_once 'DatabaseConnect.php';

class Book
{
    private PDO $dbConnect;


    public function __construct(protected ?string $name = null, protected ?string $author = null, protected ?string $image = null,protected ?string $isbn =null)
    {
        $db = new DatabaseConnect();
        $this->dbConnect = $db->getConnection();
    }

    public function addToCollection ($name, $author, $image, $isbn, $user_id)
    {
        if(!isset($_SESSION['user'])){
            return [
                'status' => false,
                'code' => 400,
                'message' => 'Vous devez être connecté pour ajouter un livre'
            ];
        }

        if(!isset($name, $author, $image, $isbn)){
            return [
                'status' => false,
                'code' => 400,
                'message' => 'Données manquantes'
            ];
        }
        $verifySql = 'SELECT * FROM books WHERE isbn = :isbn AND user_id = :user_id';
        $stmtVerify = $this->dbConnect-> prepare($verifySql);
        $stmtVerify->execute([':isbn' => $isbn, ':user_id' => $user_id]);
        $book = $stmtVerify->fetch(PDO::FETCH_ASSOC);

        if($book){
            return [
                'status' => false,
                'code'=> 400,
                'message' => 'Ce livre est déjà dans votre collection'
            ];
        }


        $sql = "INSERT INTO books (name, author, image, isbn, user_id) VALUES (:name, :author, :image, :isbn, :user_id)";
        $stmt = $this -> dbConnect -> prepare($sql);
        $response = $stmt -> execute([
            ':name' => $name,
            ':author' => $author,
            ':image' => $image,
            ':isbn' => $isbn,
            ':user_id' => $user_id
        ]);
        

        if($response){
            return [
                'status' => true,
                'code' => 201,
                'message' => 'Livre ajouté avec succès'
            ];
        } else {
            return [
                'status' => false,
                'code' => 500,
                'message' => 'Erreur lors de l\'ajout du livre'
            ];
        }
    }


    public function getCountAllBooks($user_id)
    {
        if(!isset($_SESSION['user'])){
            return [
                'status' => false,
                'code' => 400,
                'message' => 'Vous devez être connecté pour voir votre collection'
            ];
        }


        try{
            $sql = 'SELECT COUNT(*) FROM books WHERE user_id = :user_id';
            $stmt = $this-> dbConnect-> prepare($sql);
            $stmt->execute([':user_id' => $user_id]);
            $totalCount = $stmt->fetchColumn();
            return [
                'status' => true,
                'code' => 200,
                'total' => $totalCount
            ];


        }catch (PDOException $e){
            return [
                'status' => false,
                'code' => 500,
                'message' => 'Erreur lors de la récupération des livres'
            ];
        }
    }


    public function getAllBooks($user_id)
    {
    try{

        $sql = 'SELECT * FROM books WHERE user_id = :user_id';
        $stmt = $this-> dbConnect-> prepare($sql);
        $stmt -> execute ([':user_id' => $user_id]);
        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return [
            'status' => true,
            'code' => 200,
            'books' => $books
        ];

    }catch (PDOException $e){
        return [
            'status' => false,
            'code' => 500,
            'message' => 'Erreur lors de la récupération des livres'
        ];

    }
}

    public function deleteBook($book_id, $user_id)
    {
        try{
            $sql = 'DELETE FROM books WHERE id = :book_id AND user_id = :user_id';
            $stmt = $this->dbConnect->prepare($sql);
            $response = $stmt->execute([':book_id' => $book_id, ':user_id' => $user_id]);

            if($response){
                return [
                    'status' => true,
                    'code' => 200,
                    'message' => 'Livre supprimé avec succès'
                ];
            } else {
                return [
                    'status' => false,
                    'code' => 500,
                    'message' => 'Erreur lors de la suppression du livre'
                ];
            }

        }catch (PDOException $e){
            return [
                'status' => false,
                'code' => 500,
                'message' => 'Erreur lors de la suppression du livre'
            ];
        }
        
    }




}
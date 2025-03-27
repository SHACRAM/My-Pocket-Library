<?php

require_once __DIR__ . '/AbstractUser.php';
require_once __DIR__ . '/DatabaseConnect.php';


class BasicUser extends AbstractUser
{
    private $role = 'user';
    private PDO $dbConnect;


    public function __construct(private string $email, private ?string $password = null, private ?string $name = null)
    {
        $db = new DatabaseConnect();
        $this->dbConnect = $db->getConnection();
    }


    public function createAccount($name, $email, $password)
    {
        if (!$name || !$email || !$password) {
            return json_encode([
                "status" => "error",
                "code" => 400,
                "message" => "Merci de remplir tous les champs"
            ]);
        }
        try{
            $sqlVerifyEmail = 'SELECT email FROM users WHERE email = :email';
            $stmtVerifyEmail = $this->dbConnect->prepare($sqlVerifyEmail);
            $stmtVerifyEmail->execute([':email' => $email]);

            if($stmtVerifyEmail->rowCount() > 0){
                return 'Cet email est déjà utilisé';
            }

            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            $sql = 'INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)';
            $stmt = $this->dbConnect->prepare($sql);
            $stmt->execute(
                [
                    ':name' => $name,
                    ':email' => $email,
                    ':password' => $hashedPassword,
                    ':role' => $this->role
                ]
                );
            if($stmt){
                return json_encode([
                    'status' => true,
                    'code' => 201,
                    'message' => 'Compte créé avec succès'

                ]);
            }
        }
        catch(PDOException $e){
            return $e->getMessage();
        }
    }

    public function login($email, $password)
    {
        if(!$email || !$password){
            return json_encode([
                'status' => false,
                'code' => 400,
                'message' => 'Merci de remplir tous les champs'
            ]);
        }
        try{
            $sqlVerifyEmail = "SELECT * FROM users WHERE email = :email";
            $stmtVerifyEmail = $this->dbConnect->prepare($sqlVerifyEmail);
            $stmtVerifyEmail->execute([':email' => $email]);

            if($stmtVerifyEmail->rowCount() === 0){
                return json_encode([
                    'status' => False,
                    'code' => 404,
                    'message' => 'Cet email n\'existe pas'
                ]);
            }

            $user = $stmtVerifyEmail->fetch(PDO::FETCH_ASSOC);
            $checkPassword = password_verify($password, $user['password']);

            if($checkPassword){
                return json_encode([
                    'status' => true,
                    'code' => 200,
                    'message' => 'Connexion réussie',
                    'userData' => [
                        'id' => $user['id'],
                        'name' => $user['name'],
                        'email' => $user['email'],
                        'role' => $user['role']
                    ]
                    ]);
            }
        } catch(PDOException $e){
            return $e->getMessage();
        }
    }

    public function getUserInfo($email)
    {
        if(!$email){
            return json_encode([
                'status' => false,
                'code' => 404,
                'message' => 'Utilisateur non trouvé'
            ]);
        }

        try{

            $sql = 'SELECT * FROM users WHERE email = :email';
            $stmt = $this->dbConnect->prepare($sql);
            $stmt->execute([':email' => $email]);

            $response = $stmt->fetch(PDO::FETCH_ASSOC);


            if($response){
                return json_encode([
                    'status' => true,
                    'code' => 200,
                    'userData' => [
                        'name' => $response['name'],
                        'email' => $response['email']
                    ]
                    ]);
            }

        } catch(PDOException $e){
            return $e->getMessage();
        }

    }

    public function updateInfo($id, $newName, $newEmail)
    {
        if( !isset($newName, $newEmail)){
            return json_encode([
                'status' => false,
                'code' => 400,
                'message' => 'Merci de remplir tous les champs'
            ]);
        }

        try{

            $sql = 'UPDATE users SET name = :newName, email = :newEmail, updated_at = NOW() WHERE id = :id';
            $stmt = $this->dbConnect->prepare($sql);
            $stmt->execute(
                [
                    ':newName' => $newName,
                    ':newEmail' => $newEmail,
                    ':id' => $id
                ]
                );
            $response = $stmt->rowCount();

            if($response > 0){
                return [
                    'status' => true,
                    'code' => 200,
                    'message' => 'Informations mises à jour'
                ];
            } else {
                return [
                    'status' => false,
                    'code' => 400,
                    'message' => 'Aucune modification effectuée'
                ];
            }

        } catch(PDOException $e){
            return $e->getMessage();
        }
    }


    public function updatePassword($email, $newPassword)
    {
        if(!isset($email, $newPassword)){
            return [
                'status' => false,
                'code' => 400,
                'message' => 'Merci de remplir tous les champs'
            ];
        }

        try{
            $sql='UPDATE users SET password = :newPassword WHERE email = :email';
        $stmt = $this->dbConnect->prepare($sql);
        $stmt->execute(
            [
                ':newPassword' => password_hash($newPassword, PASSWORD_BCRYPT),
                ':email' => $email
            ]
            );
        $response = $stmt->rowCount();

        if($response > 0)
        {
            return [
                'status' => true,
                'code' => 200,
                'message' => 'Mot de passe mis à jour'
            ];
        } else {
            return [
                'status' => false,
                'code' => 400,
                'message' => 'Aucune modification effectuée'
            ];
        }

        } catch(PDOException $e){
            return $e->getMessage();
        }
    }
                        
}
<?php

class DatabaseConnect
{
    private $host = 'localhost';
    private $dbname = 'MyBooks';
    private $username = 'root';
    private $password = 'root';
    private $port = 8888;
    private static ?PDO $connection = null;

    public function getConnection(): ?PDO
    {
        if (self::$connection === null) {
            try {
                self::$connection = new PDO(
                    "mysql:host={$this->host};port={$this->port};dbname={$this->dbname};charset=utf8",
                    $this->username,
                    $this->password,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC 
                    ]
                );
            } catch (PDOException $e) {
                echo "Erreur de connexion : " . $e->getMessage();
                echo "<br>";
                echo "Code de l'erreur : " . $e->getCode();
                die(); 
            }
        }

        return self::$connection;
    }
}


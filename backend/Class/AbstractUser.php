<?php

require_once 'DatabaseConnect.php';

abstract class AbstractUser 
{
    // public function __construct(protected string $name, protected string $email, protected string $password)
    // {}
    abstract public function login($email, $password);
    abstract public function createAccount($name, $email, $password);
    // abstract public function deleteAccount();
    abstract public function updateInfo($id, $newName, $newEmail);
    abstract public function getUserInfo($email);
    abstract public function updatePassword($email, $newPassword);
}
<?php
require_once 'config/config.php';

class Database{
    private $pdo;

    public function connect(){
        try{
            $this->pdo = new PDO(
                'mysql:host='.DB_HOST.';dbname='.DB_NAME,
                DB_USER,
                DB_PASS
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch(PDOException $e){
            die('Connection failed: ' . $e->getMessage());
        }
        return $this->pdo;
    }
}
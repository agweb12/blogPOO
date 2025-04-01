<?php

include_once 'Model/Database.php';

class Article{
    private $pdo;

    public function __construct($pdo){
        $this->pdo = $pdo;
    }
    //$this faire référence à la classe en cours
    // Récupérer les 6 derniers articles
    public function getLastSixArticles(){
        $sql = "SELECT * FROM articles ORDER BY id DESC LIMIT 6";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $articles = $stmt->fetchAll();
        return $articles;
    }

    // Récupérer un article par son ID
    public function getArticleById($id){
        $sql = "SELECT * FROM articles WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $article = $stmt->fetch();
        return $article;
    }

    // Récupérer tous les articles
    public function getAllArticles(){
        $sql = "SELECT * FROM articles ORDER BY id DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $articles = $stmt->fetchAll();
        return $articles;
    }

    // Créer un nouvel article
    public function createArticle($titre, $contenu, $photo){
        $sql = "INSERT INTO articles (titre, contenu, photo) VALUES (:titre, :contenu, :photo)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':titre', $titre);
        $stmt->bindParam(':contenu', $contenu);
        $stmt->bindParam(':photo', $photo);
        $stmt->execute();
        return $this->pdo->lastInsertId(); // Retourne l'ID de l'article créé
    }

    // Mettre à jour un article
    public function updateArticle($id, $titre, $contenu, $photo){
        $sql = "UPDATE articles SET titre = :titre, contenu = :contenu, photo = :photo WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':titre', $titre);
        $stmt->bindParam(':contenu', $contenu);
        $stmt->bindParam(':photo', $photo);
        $stmt->execute();
        // Optionnel : retourner le nombre de lignes affectées
        // return $stmt->rowCount(); // Retourne le nombre de lignes affectées
    }

    // Supprimer un article
    public function deleteArticle($id){
        $sql = "DELETE FROM articles WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}
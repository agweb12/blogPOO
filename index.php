<?php

include_once 'config/config.php';
include_once 'Model/Database.php';
include_once 'Model/Article.php';

$database = new Database(); // Instanciation de la classe Database
$pdo = $database->connect(); // Connexion à la base de données en appelant la méthode connect() de la classe Database

$articleModel = new Article($pdo); // Instanciation de la classe Article // Création d'un objet Article en passant la connexion PDO

$action = isset($_GET['action']) ? $_GET['action'] : 'home'; // Récupération de l'action à partir de l'URL, sinon 'home' par défaut
$id = isset($_GET['id']) ? $_GET['id'] : null; // Récupération de l'ID de l'article à partir de l'URL, sinon null


// Vérification de l'action et inclusion du fichier correspondant
// Si l'action est 'list', on inclut le fichier list.php
switch($action){
    case 'home':
        $articles = $articleModel->getLastSixArticles(); // Récupération des 6 derniers articles
        include('templates/home.php');
        break;
    case 'list';
        $articles = $articleModel->getAllArticles(); // Récupération de tous les articles
        include('templates/home.php');
        break;
    case 'show':
        $article = $articleModel->getArticleById($id); // Récupération d'un article par son ID
        include('templates/articleDetail.php');
        break;
    case 'create':
        if ($id) {
            $articles = $articleModel->getArticleById($id); // Récupération de l'article à modifier
        } else {
            $articles = null; // Aucun article à modifier
        }
        // Vérification si le formulaire a été soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titre = $_POST['titre'];
            $contenu = $_POST['contenu'];
            $photo = $_FILES['photo']['name'];

            // Déplacement de l'image téléchargée vers le dossier public/assets/images
            move_uploaded_file($_FILES['photo']['tmp_name'], 'public/assets/images/' . $photo);

            // Création ou mise à jour de l'article
            if ($id) {
                // Mise à jour de l'article
                $articleModel->updateArticle($id, $titre, $contenu, $photo);
            } else {
                // Création d'un nouvel article
                $articleModel->createArticle($titre, $contenu, $photo);
            }
            header('Location: index.php'); // Redirection vers la page d'accueil après la création ou la mise à jour
        }
        include('templates/createArticle.php');
        break;
    case "delete":
        if($id){
            // Suppression de l'article
            $articleModel->deleteArticle($id);
            // redirection vers la page d'accueil
            header('Location: index.php');
        } else{
            // Gestion de l'erreur si l'ID n'est pas fourni
            echo "Erreur : ID de l'article non fourni.";
        }
    default:
        include('templates/404.php'); // Inclusion de la page 404 si l'action n'est pas reconnue
        break;
}
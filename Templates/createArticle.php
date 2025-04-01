<?php

include_once 'header.php';

?>

<h1 class="my-4 text-center">Créer un nouvel article ou Modifier un article</h1>
<div class="container">
    <form action="index.php?action=create<?= isset($articles['id']) ? '&id=' . $articles['id'] : '' ?>" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
        <!-- Vous pouvez aussi ajouter un champ caché pour l'ID -->
        <?php if (isset($articles['id'])): ?>
        <input type="hidden" name="article_id" value="<?= $articles['id'] ?>">
        <?php endif; ?>
        <div class="mb-3">
            <label for="titre" class="form-label">Titre</label>
            <input type="text" id="titre" name="titre" class="form-control" value="<?= isset($articles['id']) ? $articles['titre'] : ""  ?>" required>
            <div class="invalid-feedback">Le titre est requis.</div>
        </div>

        <div class="mb-3">
            <label for="contenu" class="form-label">Contenu</label>
            <textarea id="contenu" name="contenu" class="form-control" rows="5"><?= isset($articles['id']) ? $articles['contenu'] : ""  ?></textarea>
            <div class="invalid-feedback">Le contenu est requis.</div>
        </div>

        <div class="mb-3">
            <label for="photo" class="form-label">Ajouter une image</label>
            <input type="file" id="photo" name="photo" class="form-control">
        </div>
        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">Créer l'article ou Modifier l'article</button>
            <a href="index.php" class="btn btn-secondary">Retour à l'accueil</a>
        </div>
    </form>


</div>


<?php
include_once 'footer.php';
?>
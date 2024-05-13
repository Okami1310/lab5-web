<?php
    require_once '../inc/function.php';
    $pageTitle = "Кулінарні пригоди";
    $currentPage = 'index';
    $publications = getPublications();
?>

<?php require '../inc/head.php';?>

<?php require '../inc/header.php';?>

<main>
    <h2>Останні публікації</h2>
    <?php foreach ($publications as $publication): ?>
        <?php require '../inc/article.php';?>
    <?php endforeach; ?>
</main>

<?php require '../inc/footer.php';?>
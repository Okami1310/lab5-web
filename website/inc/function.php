<?php
function getPublications(): array {
    $pdo = getDbConnection();
    $statement = $pdo->query('SELECT articles.*, COUNT(comments.id) AS comments_count, AVG(comments.rate) AS avg_rate FROM articles LEFT JOIN comments ON articles.id = comments.article_id GROUP BY articles.id', PDO::FETCH_ASSOC);
    $articles = $statement->fetchAll();
    foreach ($articles as &$article){
        $article['id'] =(int) $article['id'];
        $article['comments_count'] =(int) $article['comments_count'];
        $article['avg_rate'] = (float) $article['avg_rate'];
    }
    unset($article);
    return $articles;
}


function getArticle(int $articleId): ?array {
    $pdo = getDbConnection();
    $statement = $pdo->prepare('SELECT articles.*, COUNT(comments.id) AS comments_count, AVG(comments.rate) AS avg_rate FROM articles LEFT JOIN comments ON articles.id = comments.article_id WHERE articles.id = ? GROUP BY articles.id');
    $statement->execute([$articleId]);
    $article = $statement->fetch(PDO::FETCH_ASSOC);

    if ($article === false) {
        return null;
    }

    $article['id'] = (int) $article['id'];
    $article['comments_count'] = (int) $article['comments_count'];
    $article['avg_rate'] = (float) $article['avg_rate'];

    return $article;
}


function getDbConnection(): PDO {
    static $pdo;
    if($pdo!== null){
        return $pdo;
    }
    $username = 'okami';
    $password = '0977179863';
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=blogg;charset=utf8', $username, $password);
    } catch(PDOException $e) {
        echo $e->getMessage();
        http_response_code(500);
        exit();
    }
    return $pdo;
}

function getCommentsForArticle(int $articleId): array {
    $pdo = getDbConnection();
    $statement = $pdo->prepare('SELECT * FROM comments WHERE article_id = ?');
    $statement->execute([$articleId]);
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}
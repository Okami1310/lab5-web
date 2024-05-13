<?php
require_once '../inc/function.php';


$articleId = $_GET['id'] ?? null;
if (null === $articleId) {
    http_response_code(400);
    exit();
}

$articleId = (int)$articleId;
$publication = getArticle($articleId);
if (null === $publication) {
    http_response_code(404);
    exit();
}

$errors = [];
$action = $_POST['action'] ?? null;
if ($action === 'add-comment') {
    $name = (string)($_POST['name'] ?? null);
    if('' === $name){
        $errors['name'] = 'Поле імені не може бути порожнім';
    } elseif (mb_strlen($name) > 50) {
        $errors['name'] = 'Ім\'я не може бути довше 50 символів';
    }

    $text = (string)($_POST['text'] ?? null);
    if('' === $text){
        $errors['text'] = 'Поле коментаря не може бути порожнім';
    } elseif (mb_strlen($text) > 200) {
        $errors['text'] = 'Коментар не може бути довшим за 200 символів';
    }

    $rate = (string)($_POST['rate'] ?? null);
    if('' === $rate){
        $errors['rate'] = 'Помилка';
    } elseif ($rate < 1 || $rate > 5) {
        $errors['rate'] = 'Помилка';
    }

    if(0 === count($errors)){
        $pdo = getDbConnection();
        $insertStatement = $pdo->prepare('INSERT INTO comments (article_id, author, rate, content, created) VALUES (?, ?, ?, ?, NOW())');
        $success = $insertStatement->execute([$articleId, $name, $rate, $text]);
        if ($success) {
            $url = 'post.php?id=' . $articleId;
            header("Location: {$url}");
            exit();
        } else {
            echo 'Помилка при збереженні коментаря у базу даних';
            http_response_code(500);
            exit();
        }
    }
}


$comments = getCommentsForArticle($articleId);

$pageTitle = "Кулінарні пригоди";
require '../inc/head.php';
?>

<?php
$currentPage = 'index';
require '../inc/header.php';
?>

<main>
    <?php require '../inc/article.php';?>


    <form action="" method="post" class="site-article">
        <input type="hidden" name="action" value="add-comment">


        <div>
            <div>
                <label>
                    Ваше ім'я <br>
                    <input type="text" name="name" value="<?= htmlspecialchars($_POST['name'] ?? null); ?>">
                </label>
                <?php if (array_key_exists('name', $errors)){ ?>
                    <div class="error"> <?= $errors['name'] ?> </div>
                <?php } ?>
            </div>

            <div>
                <label> Оцінити <br>
                    <select name="rate">
                        <option value="">Please select</option>
                        <?php for ($i=1; $i<=5; $i++){ ?>
                            <option value="<?= $i; ?> <?= $i === (int)($_POST['rate'] ?? null) ? 'selected' : '' ?>">Оцінка <?=$i;?></option>
                        <?php } ?>
                    </select>
                </label>

                <?php if (array_key_exists('rate', $errors)){ ?>
                    <div class="error"> <?= $errors['rate'] ?> </div>
                <?php } ?>
            </div>

            <div>
                <label>Ваш коментар <br>
                    <textarea name="text"><?= htmlspecialchars($_POST['text'] ?? null); ?></textarea>
                </label>
                <?php if (array_key_exists('text', $errors)){ ?>
                    <div class="error"> <?= $errors['text'] ?> </div>
                <?php } ?>
            </div>
        </div>
        <input type="submit" name="Submit" value="Коментувати">
    </form>

    <?php if (!empty($comments)): ?>
        <section>
            <h2 class="site-article">Раніше додані коментарі:</h2>
            <ul>
                <?php foreach ($comments as $comment): ?>
                    <li>
                        <strong><?= htmlspecialchars($comment['author']) ?>:</strong><br>
                        Рейтинг: <?= htmlspecialchars($comment['rate']) ?><br>
                        <?= nl2br(htmlspecialchars($comment['content'])) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
    <?php endif; ?>
</main>

<?php require '../inc/footer.php'; ?>






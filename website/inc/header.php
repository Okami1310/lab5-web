<?php
/**
 * @var array $currentPage
 */
?>
<header>
    <?php
    if ($currentPage === 'index') {
        echo '<h1><a href="index.php"><img src="logo.jpg" alt="Логотип" width="150" height="95"></a></h1>';
    } else {
        echo '<div class="some-selector"><a href="index.php"><img src="logo.jpg" alt="Логотип" width="150" height="95"></a></div>';
    }
    ?>

    <nav class="site-navigation">
        <a <?php if ($currentPage === 'index') echo 'class="active"'; ?> href="index.php">Головна</a>
        <a <?php if ($currentPage === 'info') echo 'class="active"'; ?> href="info.php">Про сайт</a>
    </nav>
</header>
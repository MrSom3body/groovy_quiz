<?php declare(strict_types=1);

session_start();

$_SESSION['SCORE'] = 0;

foreach ($_SESSION['HISTORY'] as $entry) {
    if ($entry['SELECTED_ANSWER'] === $entry['CORRECT_ANSWER']) {
        $_SESSION['SCORE']++;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MrSom3body's Quiz</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<style>
    <?php
    for ($i = 1; $i <= count($_SESSION['HISTORY']); $i++) {
        $entry = $_SESSION['HISTORY'][$i - 1];
        $color = '';

        if ($entry['CORRECT_ANSWER'] === $entry['SELECTED_ANSWER']) {
            $color = 'var(--green)';
        } else {
            $color = 'var(--red)';
        }

        echo "
            article div:nth-child($i) {
                background-color: $color;
                box-shadow: $color;
            }
            
            article div:hover:nth-child($i) {
                box-shadow: 0 0 20px $color;
            }
            ";
    }
    ?>
</style>
<body>
<header>
    <h1><a href="index.php">MrSom3body's Quiz</a></h1>
    <h2>Congratulations for completing the quiz
        about:
        <em><?php echo $_SESSION['CATEGORY']['CATEGORY_NAME'] . '/' . $_SESSION['SUBCATEGORY']['SUBCATEGORY_NAME'] ?></em>
    </h2>
    <h3>You have <?php echo $_SESSION['SCORE'] . ' of ' . count($_SESSION['HISTORY']) ?> points.</h3>
</header>
<article>
    <?php
    foreach ($_SESSION['HISTORY'] as $entry) {
        echo '<div>';
        echo '<h2> Question: ';
        echo $entry['QUESTION'];
        echo '</h2>';
        echo '<br>';
        echo '<h3>Your answer "';
        echo $entry['SELECTED_ANSWER'];
        if ($entry['SELECTED_ANSWER'] === $entry['CORRECT_ANSWER']) {
            echo '" was correct.</h3>';
        } else {
            echo '" was incorrect.</h3>';
        }
        echo '</div>';
    }
    ?>
</article>
</body>
</html>

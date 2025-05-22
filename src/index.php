<?php declare(strict_types=1);

require_once './lib/xml_loader.php';
require_once './lib/styling.php';
session_start();

$xml = loadQuizXML();

$categories = [];
foreach ($xml->category as $cat) {
    $categories[] = [
        'id' => (string) $cat['id'],
        'name' => (string) $cat['name']
    ];
}
$total_categories = count($categories);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MrSom3body's Quiz</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
    <?php
    outputColorCSS(count($categories), 'section a');
    outputResponsiveFlexCSS(count($categories));
    ?>
    </style>
</head>
<body>
<header>
    <h1><a href="index.php">MrSom3body's Quiz</a></h1>
    <h2>Select a category from below</h2>
</header>
<section>
    <?php foreach ($categories as $category): ?>
        <a href="category.php?category_id=<?= htmlspecialchars($category['id']) ?>">
            <?= htmlspecialchars($category['name']) ?>
        </a>
    <?php endforeach; ?>
</section>
</body>
</html>

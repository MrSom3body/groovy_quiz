<?php declare(strict_types=1);

require_once './lib/xml_loader.php';
require_once './lib/styling.php';
session_start();

$xml = loadQuizXML();

if (!isset($_GET['category_id'])) {
    header('Location: 404.html');
    exit();
}

$category = findCategory($xml, $_GET['category_id']);
if (!$category) {
    header('Location: 404.html');
    exit();
}

$_SESSION['CATEGORY'] = [
    'CATEGORY_ID' => (string) $category['id'],
    'CATEGORY_NAME' => (string) $category['name']
];

$subcategories = [];
foreach ($category->subcategory as $cat) {
    $subcategories[] = [
        'id' => (string) $cat['id'],
        'name' => (string) $cat['name']
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MrSom3body's Quiz</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
    <?php
    outputColorCSS(count($subcategories), 'section a');
    outputResponsiveFlexCSS(count($subcategories));
    ?>
    </style>
</head>
<body>
<header>
    <h1><a href="index.php">MrSom3body's Quiz</a></h1>
    <h2>Select a subcategory from below</h2>
    <h3>Category: <?= htmlspecialchars($_SESSION['CATEGORY']['CATEGORY_NAME']) ?></h3>
</header>
<section>
    <?php foreach ($subcategories as $sub): ?>
        <a href="quiz.php?subcategory_id=<?= htmlspecialchars((string) $sub['id']) ?>">
            <?= htmlspecialchars($sub['name']) ?>
        </a>
    <?php endforeach; ?>
</section>
</body>
</html>

<?php declare(strict_types=1);

require_once './lib/xml_loader.php';
require_once './lib/styling.php';
session_start();

$xml = loadQuizXML();

if (!isset($_GET['subcategory_id'])) {
    header('Location: 404.html');
    exit;
}

$subcategory = findSubcategory($xml, $_GET['subcategory_id']);
if (!$subcategory) {
    header('Location: 404.html');
    exit;
}

// Check if this is a revisit for the same subcategory, and reset quiz if completed or new start
if (
    isset($_SESSION['SUBCATEGORY']['SUBCATEGORY_ID']) &&
    $_SESSION['SUBCATEGORY']['SUBCATEGORY_ID'] === (string) $subcategory['id']
) {
    // Same subcategory - check if quiz finished or not initialized
    if (
        !isset($_SESSION['CURRENT_QUESTION']) ||
        $_SESSION['CURRENT_QUESTION'] >= count($_SESSION['QUESTIONS'])
    ) {
        // Reset quiz session variables for fresh start
        $_SESSION['CURRENT_QUESTION'] = 0;
        $_SESSION['SCORE'] = 0;
        $_SESSION['HISTORY'] = [];
    }
} else {
    // Different subcategory or first time, reset completely
    $_SESSION['CURRENT_QUESTION'] = 0;
    $_SESSION['SCORE'] = 0;
    $_SESSION['HISTORY'] = [];
}

// Store current subcategory info in session (overwrite)
$_SESSION['SUBCATEGORY'] = [
    'SUBCATEGORY_ID' => (string) $subcategory['id'],
    'SUBCATEGORY_NAME' => (string) $subcategory['name']
];

// Load questions for this subcategory
$_SESSION['QUESTIONS'] = getQuestions($subcategory);

// Defensive check: reset CURRENT_QUESTION if out of range
if (!isset($_SESSION['CURRENT_QUESTION']) || $_SESSION['CURRENT_QUESTION'] >= count($_SESSION['QUESTIONS'])) {
    $_SESSION['CURRENT_QUESTION'] = 0;
}

$current_question = $_SESSION['QUESTIONS'][$_SESSION['CURRENT_QUESTION']];

// Find correct answer for the current question to store in session
foreach ($current_question['answers'] as $a) {
    if ($a['correct']) {
        $_SESSION['CORRECT_ANSWER'] = $a['text'];
        break;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MrSom3body's Quiz</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
    <?php outputColorCSS(count($current_question['answers']), 'form input'); ?>
    </style>
</head>
<body>
<header>
    <h1><a href="index.php">MrSom3body's Quiz</a></h1>
    <h2><?= htmlspecialchars($current_question['text']) ?></h2>
    <h3>
        Category: <?= htmlspecialchars($_SESSION['CATEGORY']['CATEGORY_NAME'] . '/' . $_SESSION['SUBCATEGORY']['SUBCATEGORY_NAME']) ?>
    </h3>
</header>
<form action="save_answers.php" method="post">
    <?php foreach ($current_question['answers'] as $answer): ?>
        <input type="submit" name="answer" value="<?= htmlspecialchars($answer['text']) ?>">
    <?php endforeach; ?>
</form>
</body>
</html>

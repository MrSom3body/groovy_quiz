<?php declare(strict_types=1);

session_start();

if (!isset($_POST['answer'])) {
    header('Location: 404.html');
    exit();
}

$selected_answer = $_POST['answer'];
$correct_answer = $_SESSION['CORRECT_ANSWER'] ?? '';
$current_index = $_SESSION['CURRENT_QUESTION'] ?? 0;
$questions = $_SESSION['QUESTIONS'] ?? [];

if (!isset($questions[$current_index])) {
    header('Location: result.php');
    exit();
}

$_SESSION['HISTORY'][] = [
    'QUESTION' => $questions[$current_index]['text'],
    'SELECTED_ANSWER' => $selected_answer,
    'CORRECT_ANSWER' => $correct_answer
];

$_SESSION['CURRENT_QUESTION']++;

if ($_SESSION['CURRENT_QUESTION'] < count($questions)) {
    $next = $_SESSION['SUBCATEGORY']['SUBCATEGORY_ID'];
    header("Location: quiz.php?subcategory_id=$next");
    exit();
} else {
    header('Location: result.php');
    exit();
}
?>

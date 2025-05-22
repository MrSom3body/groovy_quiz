<?php declare(strict_types=1);

// XML loader and validator (can be reused)
function loadQuizXML(): SimpleXMLElement
{
    $dom = new DOMDocument();
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = false;
    $dom->load(__DIR__ . '/../quiz.xml');
    if (!$dom->validate()) {
        http_response_code(500);
        exit('❌ XML is not valid according to DTD!');
    }
    return simplexml_import_dom($dom);
}

// Find category by ID
function findCategory(SimpleXMLElement $xml, string $id): ?SimpleXMLElement
{
    foreach ($xml->category as $cat) {
        if ((string) $cat['id'] === $id) {
            return $cat;
        }
    }
    return null;
}

// Find subcategory by ID
function findSubcategory(SimpleXMLElement $xml, string $id): ?SimpleXMLElement
{
    foreach ($xml->category as $cat) {
        foreach ($cat->subcategory as $sub) {
            if ((string) $sub['id'] === $id) {
                return $sub;
            }
        }
    }
    return null;
}

// Get questions for a subcategory
function getQuestions(SimpleXMLElement $sub): array
{
    $questions = [];
    foreach ($sub->question as $q) {
        $answers = [];
        foreach ($q->answer as $a) {
            $answers[] = [
                'text' => (string) $a,
                'correct' => ((string) $a['correct']) === 'true'
            ];
        }
        $questions[] = [
            'id' => (string) $q['id'],
            'text' => (string) $q['text'],
            'type' => (string) $q['type'],
            'answers' => $answers
        ];
    }
    return $questions;
}
?>

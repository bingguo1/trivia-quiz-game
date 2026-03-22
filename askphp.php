<?php

include 'connect.php';

// Accepted columns and tables (whitelist to prevent injection)
const ALLOWED_TABLE = 'tbquiz';
const ALLOWED_COLUMNS = ['number', 'question', 'answer', 'detail', 'category'];

$columnSets = $_POST['columnSets'] ?? [];
$mode       = $_POST['mode']       ?? '';   // 'byNumber' | 'byCategories' | 'all'

// Validate requested columns against whitelist
foreach ($columnSets as $col) {
    if (!in_array($col, ALLOWED_COLUMNS, true)) {
        echo json_encode(["error", "Invalid column: $col"]);
        exit;
    }
}
$selectCols = implode(',', $columnSets);

try {
    if ($mode === 'byNumber') {
        // Fetch a single question by its number
        $number = intval($_POST['number'] ?? 0);
        $stmt = $conn->prepare("SELECT $selectCols FROM tbquiz WHERE number=?");
        $stmt->execute([$number]);

    } elseif ($mode === 'byCategories') {
        // Fetch question numbers for selected category IDs (integers only)
        $ids = array_map('intval', (array)($_POST['categoryIds'] ?? []));
        if (empty($ids)) {
            echo json_encode(["fail", "No categories provided"]);
            exit;
        }
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $conn->prepare("SELECT $selectCols FROM tbquiz WHERE category IN ($placeholders)");
        $stmt->execute($ids);

    } elseif ($mode === 'all') {
        // Fetch all question numbers
        $stmt = $conn->prepare("SELECT $selectCols FROM tbquiz");
        $stmt->execute();

    } else {
        echo json_encode(["error", "Invalid mode"]);
        exit;
    }

    $a = ["succeed"];
    while ($row = $stmt->fetch()) {
        foreach ($columnSets as $column) {
            array_push($a, nl2br(stripcslashes($row[$column])));
        }
    }
    echo json_encode($a);

} catch (PDOException $e) {
    echo json_encode(["error", $e->getMessage()]);
}

$conn = null;

?>


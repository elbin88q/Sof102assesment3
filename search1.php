<?php
$jsonData = file_get_contents('book.json');
$products = json_decode($jsonData, true);

$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

$searchResults = [];
foreach ($products as $category => $items) {
    foreach ($items as $product) {
        if (stripos($product['id'], $keyword) !== false || stripos($product['Book name'], $keyword) !== false) {
            $searchResults[] = $product;
        }
    }
}

echo json_encode($searchResults);
?>

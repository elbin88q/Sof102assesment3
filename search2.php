\<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jsonData = json_decode(file_get_contents('perfume.json'), true);

    $keyword = strtolower($_POST['keyword']);
    $minPrice = floatval($_POST['minPrice']);
    $maxPrice = floatval($_POST['maxPrice']);

    $filteredPerfumes = array_filter($jsonData['perfumes'], function ($perfume) use ($keyword, $minPrice, $maxPrice) {
        $productId = strtolower($perfume['id']);
        $productName = strtolower($perfume['Product_name']);
        $price = floatval($perfume['Price']);

        return ((strpos($productId, $keyword) !== false || strpos($productName, $keyword) !== false) || empty($keyword)) &&
               ($price >= $minPrice || empty($minPrice)) &&
               ($price <= $maxPrice || empty($maxPrice));
    });


    if (!empty($filteredPerfumes)) {
        echo '<table border="1">
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Brand</th>
                    <th>Ingredients</th>
                    <th>Item Weight</th>
                </tr>';

        foreach ($filteredPerfumes as $perfume) {
            echo '<tr>
                    <td>'.$perfume['id'].'</td>
                    <td>'.$perfume['Product_name'].'</td>
                    <td>'.$perfume['Price'].'</td>
                    <td>'.$perfume['Brand'].'</td>
                    <td>'.$perfume['Ingredients'].'</td>
                    <td>'.$perfume['Item_weight'].'</td>
                </tr>';
        }

        echo '</table>';
    } else {
        echo 'No matching perfumes found.';
    }
}
?>

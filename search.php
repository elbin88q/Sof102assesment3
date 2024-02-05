<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jsonData = json_decode(file_get_contents('electronic1.json'), true);

    $keyword = strtolower($_POST['keyword']);
    $minPrice = floatval($_POST['minPrice']);
    $maxPrice = floatval($_POST['maxPrice']);

    $filteredProducts = array_filter($jsonData['electronics']['product'], function ($product) use ($keyword, $minPrice, $maxPrice) {
        $productId = strtolower($product['id']);
        $productName = strtolower($product['Product_name']);
        $price = floatval($product['Price']);

        return ((strpos($productId, $keyword) !== false || strpos($productName, $keyword) !== false) || empty($keyword)) &&
               ($price >= $minPrice || empty($minPrice)) &&
               ($price <= $maxPrice || empty($maxPrice));
    });

   

    if (!empty($filteredProducts)) {
        echo '<table border="1">
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Wireless Carrier</th>
                    <th>Brand</th>
                    <th>Color</th>
                    <th>Memory Storage Capacity</th>
                    <th>Screen Size</th>
                    <th>Operating System</th>
                </tr>';

        foreach ($filteredProducts as $product) {
            echo '<tr>
                    <td>'.$product['id'].'</td>
                    <td>'.$product['Product_name'].'</td>
                    <td>'.$product['Price'].'</td>
                    <td>'.$product['Wireless_carrier'].'</td>
                    <td>'.$product['Brand'].'</td>
                    <td>'.$product['Colour'].'</td>
                    <td>'.$product['Memory_storage_capacity'].'</td>
                    <td>'.$product['Screen_size'].'</td>
                    <td>'.$product['Operating_system'].'</td>
                </tr>';
        }

        echo '</table>';
    } else {
        echo 'No matching products found.';
    }
}
?>

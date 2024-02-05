<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jsonData = json_decode(file_get_contents('electronic2.json'), true);

    $keyword = strtolower($_POST['keyword']);
    $minPrice = floatval($_POST['minPrice']);
    $maxPrice = floatval($_POST['maxPrice']);

    $filteredElectronics2 = array_filter($jsonData['electronics'], function ($electronic) use ($keyword, $minPrice, $maxPrice) {
        $productId = strtolower($electronic['id']);
        $productName = strtolower($electronic['Product_name']);
        $price = floatval($electronic['Price']);

        return ((strpos($productId, $keyword) !== false || strpos($productName, $keyword) !== false) || empty($keyword)) &&
               ($price >= $minPrice || empty($minPrice)) &&
               ($price <= $maxPrice || empty($maxPrice));
    });

    

    if (!empty($filteredElectronics2)) {
        echo '<table border="1">
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Brand</th>
                    <th>OS</th>
                    <th>CPU</th>
                    <th>Screen Size</th>
                    <th>Memory Size</th>
                    <th>Hard Disk Size</th>
                </tr>';

        foreach ($filteredElectronics2 as $electronic) {
            echo '<tr>
                    <td>'.$electronic['id'].'</td>
                    <td>'.$electronic['Product_name'].'</td>
                    <td>'.$electronic['Price'].'</td>
                    <td>'.$electronic['Brand'].'</td>
                    <td>'.$electronic['OS'].'</td>
                    <td>'.$electronic['CPU'].'</td>
                    <td>'.$electronic['Screen_size'].'</td>
                    <td>'.$electronic['Computer_memory_size'].'</td>
                    <td>'.$electronic['Hard_disk_size'].'</td>
                </tr>';
        }

        echo '</table>';
    } else {
        echo 'No matching electronics found.';
    }
}
?>

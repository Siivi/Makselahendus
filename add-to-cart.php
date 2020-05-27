<?php
session_start();

$products = require_once 'products.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

//kontroll kas toode on olemas!
if (!in_array($id, array_keys($products))) {
    //error toode missing
    //siit edasi ei lähe
}

$product = $products[$id];

if (!isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id] = [
        'name' => $product['name'],
        'id' => $product['id'],
        'price' => $product['price'],
        'unit' => 1
    ];
} else {
    $_SESSION['cart'][$id]['unit'] += 1;
}


header('Location: shop.php');
<?php
$host = "localhost";
$user = "root";
$psw = "";
$dbname = "products";

$dsn = "mysql:host=$host; dbname=$dbname";
$options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

function escape($html)
{
    return htmlspecialchars($html, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
}
try {
    $conn = new PDO($dsn, $user, $psw, $options);
    $sql = "SELECT * FROM products.products";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $result = $stmt->fetchAll();
} catch (PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}

?>
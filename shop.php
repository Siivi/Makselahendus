<?php
    session_start();

    require "header.php";
    $data = file_get_contents("products.php");
    foreach(array($data) as $row) {
        print_r($row);
    }
?>
<h2>Tooted:</h2>

<div class="container float-left">
    <div class="row mb-2">
        <div class="col">Nr</div>
        <div class="col">Nimi</div>
        <div class="col">Hind</div>
        <div class="col">Osta</div>
    </div>
    <?php foreach (array($data) as $item) : ?>
        <div class="row">
            <div class="col"><?php echo $item['id']; ?></div>
            <div class="col"><?php echo $item['name']; ?></div>
            <div class="col"><?php echo $item['price']; ?> € </div>
            <div class="col"><a href="/add-to-cart.php?id=<?php echo $item["id"]; ?>" class="btn btn-primary">Osta</a></div>
        </div>
    <?php endforeach; ?>
</div>
       
</body>
</html>
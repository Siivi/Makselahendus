<?php

session_start();
require "header.php";

/*if (!isset($_SESSION['cart'][1])) {
    $_SESSION['cart'][1] = [
        'name' => 'Name1',
        'id' => '1',
        'price' => 10.99,
        'unit' => 1
    ];
}

$_SESSION['cart'][1]['unit'] += 1;

if (!isset($_SESSION['cart'][2])) {
    $_SESSION['cart'][2] = [
        'name' => 'Name2',
        'id' => '2',
        'price' => 5.99,
        'unit' => 1
    ];
}

$_SESSION['cart'][2]['unit'] += 2;
*/
?>

<table>
    <?php foreach($data as $item);?>
      <div class="row">
        <div class="col"><?php echo $item["id"]; ?></div>
          <div class="col"><?php echo $item["name"]; ?></div>
          <div class="col"><?php echo $item["price"]; ?> € </div>
          <div class="col"><a href="/add-to-cart.php?id=<?php echo $item["id"]; ?>" class="btn btn-primary">Osta</a></div>
        </div>
    
  </div>
        <tr>
            <td><?php echo $item['name']; ?></td>
            <td><?php echo $item['price']; ?></td>
            <td><input name="" value="<?php echo $item['unit']; ?>"></td>
            <td><button>delete btn</button></td>
        </tr>

        <?php  $total += $item['price'] * $item['unit']?>

    
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td><?php echo $total; ?></td>
    </tr>
</table>

<a href="pay.php">Pay</a>

<pre>
<?php

$_SESSION['card']['total'] = $total;


print_r($_SESSION);
require "footer.php";
?>
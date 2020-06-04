<?php 

session_start();

require "./header.php"; 

?>
<div class="container float-left" >
      <div class="cart">
        <h4>Ostukorv:</h4>
        <?php
          if(!empty($_SESSION['cart_item'])){
              
            $total_quantity = 0;
            $total_price = 0;
        ?>
        <div class="row mb-1"> 
          <div class="col">Nimetus</div>
          <div class="col">Kood</div>
          <div class="col">Kogus</div>
          <div class="col">Ühiku hind</div>
          <div class="col">Kokku hind</div>
          <div class="col">Eemalda</div>
        </div>	
      <?php	

      foreach ($_SESSION["cart_item"] as $item){
        $item_price = $item["amount"]*$item["price"];
      ?>
      <div class="row mt-2">
        <div class="col"><?php echo $item["order_item_title"]; ?></div>
        <div class="col"><?php echo $item["order_item_code"]; ?></div>
        <div class="col"><?php echo $item["amount"]; ?></div>
        <div class="col"><?php echo number_format($item["order_item_price"], 2); ?> € </div>
        <div class="col"><?php echo number_format($item["order_item_price"] * $item["amount"], 2); ?> € </div>
        <div class="col"><a href="/remove.php?code=<?php echo $item["order_item_code"]; ?>" class="btn btn-danger">Eemalda</a></div>
      </div>

      <?php
      $total_quantity += $item["amount"];
      $total_price += ($item["order_item_price"]*$item["amount"]);
      }
      ?>
      <div class="row">Kokku: <?php echo $total_quantity; ?> toodet</div>
      <div class="row"><strong>Hind kokku: <?php echo number_format($total_price, 2); ?> € </strong></div>
      <br>
      
    </div>
  </div>		
<?php
$_SESSION['total_price']= $total_price;
} else {
?>
<div class="no-records">Sinu ostukorv on veel tühi</div>
<?php 
}
if(!empty($_SESSION['cart_item'])){


?>
<div class="container float-left" >
<h4>Tellimuse vormistamine:</h4>

<div class="order_id">Tellimuse kood: <?php echo $_SESSION["order_id"];?></div>

<form method='POST' action="payment_redirect.php">
<?php require "./registration.php"; ?>   
</form>
<?php 
}
?>
<?php
/*
require_once 'config.php'; 
include_once 'shopCart.php'; 
$cart = new shopCart; 
 
if($cart->total_products() <= 0){ 
    header("Location: index.php"); 
} 
 
$postData = !empty($_SESSION['postData'])?$_SESSION['postData']:array(); 
unset($_SESSION['postData']); 
 
$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:''; 
if(!empty($sessData['status']['msg'])){ 
    $statusMsg = $sessData['status']['msg']; 
    $statusMsgType = $sessData['status']['type']; 
    unset($_SESSION['sessData']['status']); 
} 

include 'header.php';
?>

<div class="container">
    <h1>CHECKOUT</h1>
    <div class="col-12">
        <div class="checkout">
            <div class="row">
                <?php if(!empty($statusMsg) && ($statusMsgType == 'success')){ ?>
                <div class="col-md-12">
                    <div class="alert alert-success"><?php echo $statusMsg; ?></div>
                </div>
                <?php }elseif(!empty($statusMsg) && ($statusMsgType == 'error')){ ?>
                <div class="col-md-12">
                    <div class="alert alert-danger"><?php echo $statusMsg; ?></div>
                </div>
                <?php } ?>
				
                <div class="col-md-4 order-md-2 mb-4">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Your Cart</span>
                        <span class="badge badge-secondary badge-pill"><?php echo $cart->total_products(); ?></span>
                    </h4>
                    <ul class="list-group mb-3">
                        <?php 
                        if($cart->total_products() > 0){ 
                            //get cart items from session 
                            $cartProducts = $cart->contents(); 
                            foreach($cartProducts as $product){ 
                        ?>
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <div>
                                <h6 class="my-0"><?php echo $product["title"]; ?></h6>
                                <small class="text-muted"><?php echo '$'.$product["price"]; ?>(<?php echo $item["qty"]; ?>)</small>
                            </div>
                            <span class="text-muted"><?php echo '$'.$product["subtotal"]; ?></span>
                        </li>
                        <?php } } ?>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Total (USD)</span>
                            <strong><?php echo '$'.$cart->total_products(); ?></strong>
                        </li>
                    </ul>
                    <a href="index.php" class="btn btn-block btn-info">Add Items</a>
                </div>
                <div class="col-md-8 order-md-1">
                    <h4 class="mb-3">Contact Details</h4>
                    <form method="post" action="cart-to-cart.php">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="first_name">First Name</label>
                                <input type="text" class="form-control" name="first_name" value="<?php echo !empty($postData['first_name'])?$postData['first_name']:''; ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="last_name">Last Name</label>
                                <input type="text" class="form-control" name="last_name" value="<?php echo !empty($postData['last_name'])?$postData['last_name']:''; ?>" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" value="<?php echo !empty($postData['email'])?$postData['email']:''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" name="phone" value="<?php echo !empty($postData['phone'])?$postData['phone']:''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="last_name">Address</label>
                            <input type="text" class="form-control" name="address" value="<?php echo !empty($postData['address'])?$postData['address']:''; ?>" required>
                        </div>
                        <input type="hidden" name="action" value="placeOrder"/>
                        <input class="btn btn-success btn-lg btn-block" type="submit" name="checkoutSubmit" value="Place Order">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php

    include './header.php';
    require './config.php';

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

  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header border-bottom-0">
        <h5 class="modal-title" id="exampleModalLabel">
          Sinu Ostukorv
        </h5>
        <?php
          if(!empty($_SESSION["cart_item"])){
              
            $total_quantity = 0;
            $total_price = 0;
        ?>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-image">
          <thead>
            <tr>
              <th scope="col">Toode</th>
              <th scope="col">Hind</th>
              <th scope="col">Kogus</th>
              <th scope="col">Kokku</th>
              <th scope="col">Tegevus</th>
            </tr>
          </thead>
          <?php	

          foreach ($_SESSION["cart_item"] as $item){
          $item_price = $item["amount"]*$item["price"];
          ?>
          <tbody>
            <tr>
              <td><?php echo $item["order_item_title"]; ?></td>
              <td><?php echo number_format($item["order_item_price"], 2); ?> € </td>
              <td><?php echo $item["amount"]; ?></td>
              <td><?php echo number_format($item["order_item_price"] * $item["amount"], 2); ?> € </td>
              <td>
              <a href="/removehp?code=<?php echo $item["order_item_code"]; ?>" class="btn btn-danger">Eemalda</a>
                  <i class="fa fa-times"></i>
                </a>
              </td>
            </tr>
          </tbody>
        </table> 
        <?php
        $total_quantity += $item["amount"];
        $total_price += ($item["order_item_price"]*$item["amount"]);
        }
        ?>
        <div class="d-flex justify-content-end">
          <h5>Kokku: <span class="price text-success"><?php echo number_format($total_price, 2); ?> € </span></h5>
        </div>
      </div>
      <?php
      } else {
      ?>
      <div class="no-records">Sinu ostukorv on veel tühi</div>
      <?php 
      }
      ?>
      <div class="modal-footer border-top-0 d-flex justify-content-between">
      <div class="row"><a href="/order.php" class="btn btn-success">Maksma</a></div>
      </div>
   
  </div>
<?php include "./footer.php"; ?>
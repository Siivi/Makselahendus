<?php

session_start();
require "header.php";
?>

<div class="">
    <?php echo $_SESSION['order_id'];?> Tellimus ebaõnnestus!
</div>
<a href="order.php" class="btn btn-primary mt-4">Uuesti tellima</a>
<?php
 session_destroy();
 require "footer.php";
?>
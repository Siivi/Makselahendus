<?php

session_start();
require "header.php";
?>

<div class="">
    <?php echo $_SESSION['order_id'];?> Tellimus vastu võetud!
</div>
<a href="index.php" class="btn btn-primary mt-4">Uuesti tellima</a>
<?php
 session_destroy();
 require "footer.php";
?>
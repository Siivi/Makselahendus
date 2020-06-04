<?php 

session_start();

if (!isset($_SESSION["order_id"])){
    $_SESSION["order_id"]= generateRandomString();
}
if (isset($_GET["code"])){
    try {
        require "./config.php";      
        $conn = new PDO($dsn, $user, $psw, $options);
        $sql = "SELECT * FROM products.products WHERE code=:code";
             
        $stmt = $conn->prepare($sql);
        $stmt->execute(["code"=>$_GET["code"]]);
                
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (empty($_SESSION["cart_item"]) or empty(filter_by_code($_GET["code"]))){
            $order_item = array("order_id"=>$_SESSION["order_id"], "order_item_code"=>$_GET["code"], "order_item_price"=>$result["price"], "order_item_name"=>$result["name"], "amount"=>1);
            $_SESSION["cart_item"][]=$order_item;        
        } else {
            foreach ($_SESSION["cart_item"] as $key => $value) {
                if ($value["order_item_code"]==$_GET["code"]) {
                    $_SESSION["cart_item"][$key]["amount"] += 1;
                }
            }
        }
        
        header("Location: {$_SERVER["HTTP_REFERER"]}");
        } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
      }
}else{
    echo "Code not set";
}
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function filter_by_code($filter_code) {
    return array_merge(...array_filter($_SESSION["cart_item"], function($var) use ($filter_code){
        return ($var["order_item_code"] == $filter_code);
        }));            
}

?>





/*
// Initialize shopping cart class 
require_once 'shopCart.php'; 
$cart = new shopCart; 
 
// Include the database config file 
require_once 'config.php'; 
 
// Default redirect page 
$defaultPage = 'index.php'; 
 
// Process request based on the specified action 
if(isset($_REQUEST['action']) && !empty($_REQUEST['action'])){ 
    if($_REQUEST['action'] == 'addToCart' && !empty($_REQUEST['id'])){ 
        $productID = $_REQUEST['id']; 
         
        // Get product details 
        $query = $conn->query("SELECT * FROM products WHERE id = ".$productID); 
        $row = $query->fetch_assoc(); 
        $productData = array( 
            'id' => $row['id'], 
            'title' => $row['title'], 
            'price' => $row['price'], 
            'unit' => 1 
        ); 
         
        // Insert item to cart 
        $insertProduct = $cart->insert_product($productData); 
         
        // Redirect to cart page 
        $defaultPage = $insertProduct?'shop.php':'index.php'; 
    }elseif($_REQUEST['action'] == 'updateCartProduct' && !empty($_REQUEST['id'])){ 
        // Update item data in cart 
        $productData = array( 
            'rowid' => $_REQUEST['id'], 
            'unit' => $_REQUEST['unit'] 
        ); 
        $updateProduct = $cart->update($productData); 
         
        // Return status 
        echo $updateProduct?'ok':'err';die; 
    }elseif($_REQUEST['action'] == 'removeCartProduct' && !empty($_REQUEST['id'])){ 
        // Remove item from cart 
        $deleteProduct = $cart->remove($_REQUEST['id']); 
         
        // Redirect to cart page 
        $defaultPage = 'shop.php'; 
    }elseif($_REQUEST['action'] == 'placeOrder' && $cart->total_products() > 0){ 
        $defaultPage = 'oder.php'; 
         
        // Store post data 
        $_SESSION['postData'] = $_POST; 
     /*
        $first_name = strip_tags($_POST['first_name']); 
        $last_name = strip_tags($_POST['last_name']); 
        $email = strip_tags($_POST['email']); 
        $phone = strip_tags($_POST['phone']); 
        $address = strip_tags($_POST['address']); 
         
        $errorMsg = ''; 
        if(empty($first_name)){ 
            $errorMsg .= 'Please enter your first name.<br/>'; 
        } 
        if(empty($last_name)){ 
            $errorMsg .= 'Please enter your last name.<br/>'; 
        } 
        if(empty($email)){ 
            $errorMsg .= 'Please enter your email address.<br/>'; 
        } 
        if(empty($phone)){ 
            $errorMsg .= 'Please enter your phone number.<br/>'; 
        } 
        if(empty($address)){ 
            $errorMsg .= 'Please enter your address.<br/>'; 
        } 
         
        if(empty($errorMsg)){ 
            // Insert customer data in the database 
            $insertCust = $db->query("INSERT INTO customers (first_name, last_name, email, phone, address) VALUES ('".$first_name."', '".$last_name."', '".$email."', '".$phone."', '".$address."')"); 
             
            if($insertCust){ 
                $custID = $db->insert_id; 
                 
                // Insert order info in the database 
                $insertOrder = $db->query("INSERT INTO orders (customer_id, grand_total, created, status) VALUES ($custID, '".$cart->total()."', NOW(), 'Pending')"); 
             
                if($insertOrder){ 
                    $orderID = $db->insert_id; 
                     
                    // Retrieve cart items 
                    $cartItems = $cart->contents(); 
                     
                    // Prepare SQL to insert order items 
                    $sql = ''; 
                    foreach($cartItems as $item){ 
                        $sql .= "INSERT INTO order_items (order_id, product_id, quantity) VALUES ('".$orderID."', '".$item['id']."', '".$item['qty']."');"; 
                    } 
                     
                    // Insert order items in the database 
                    $insertOrderItems = $db->multi_query($sql); 
                     
                    if($insertOrderItems){ 
                        // Remove all items from cart 
                        $cart->destroy(); 
                         
                        // Redirect to the status page 
                        $redirectLoc = 'orderSuccess.php?id='.$orderID; 
                    }else{ 
                        $sessData['status']['type'] = 'error'; 
                        $sessData['status']['msg'] = 'Some problem occurred, please try again.'; 
                    } 
                }else{ 
                    $sessData['status']['type'] = 'error'; 
                    $sessData['status']['msg'] = 'Some problem occurred, please try again.'; 
                } 
            }else{ 
                $sessData['status']['type'] = 'error'; 
                $sessData['status']['msg'] = 'Some problem occurred, please try again.'; 
            } 
        }else{ 
            $sessData['status']['type'] = 'error'; 
            $sessData['status']['msg'] = 'Please fill all the mandatory fields.<br>'.$errorMsg;  
        } 
        $_SESSION['sessData'] = $sessData; 
    } 
} 
 */
// Redirect to the specific page 
/*header("Location: $defaultPage"); 
exit();*/
/*
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


header('Location: shop.php');*/
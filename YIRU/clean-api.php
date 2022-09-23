<?php     
if(!isset($_SESSION)){
    session_start();
}
unset($_SESSION['cart'],$_SESSION['rCart'],$_SESSION['tPrice'],$_SESSION['renCart'],$_SESSION['camCart']);
$cr = 'cart-list.php';

if(! isset($_SESSION['cart'])){
    $_SESSION['cart'] = [];
    $_SESSION['rCart'] = [];
    $_SESSION['renCart'] =[];
    $_SESSION['camCart'] =[];
    $_SESSION['tPrice'] =[];
    header("Location: {$cr}");
}
?>
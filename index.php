<?php require "includes/header.php"; ?>

<?php 
if(!isset($_SESSION['username'])){
    header("location: login.php");
}

echo "Hello ".$_SESSION['username'];

?>

<?php require "includes/footer.php"; ?>

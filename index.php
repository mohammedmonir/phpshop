<?php



session_start();
if(isset ($_SESSION["user"])){
header("Location:dashbord.php");

}
?>
<?php $pagetitle = "login";?>

<?php include "header.php";?>

<?php include "connection.php";?>

<?php include "login.php";?>

<?php
include "footer.php";
?>
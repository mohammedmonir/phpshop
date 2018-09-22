<?php
if(isset($_SESSION["user"])){
    ?>
    <div class=" upper" style="background:#dedede" >
    <div class="container">
        <span  ><?php  echo "اهلا وسهلا بك ".$_SESSION["user"];?></span>
        <img src="ff.jpg" alt="profile" class="img-profile"/>
    </div>
</div>
<?php
}else{
?>
<div class=" upper" style="background:#dedede" >
    <div class="container">
        <span  > <a href="login.php">Login/signUp</a></span>
    </div>
</div>
<?php }?>
<?php





if($_SERVER["REQUEST_METHOD"]=="POST"){

    $username = $_POST['user'];
    $password = $_POST['pass'];

    $stmt=$db->prepare("SELECT userid,name,password FROM users WHERE name=? AND password=? AND groupid=0 ");//الادمن هو الذين يحتوي groupid على 0
                                                                                                            //الاعضاء راح ينضافو الهم 1 بشكل تلقائي...الا الادمن بعدل عليه من قواعد البيانات وبحط بدال الواحد صفر        
    $stmt->execute(array($username,$password));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();
   

     if($count > 0){
       $_SESSION["user"]=$username;
       $_SESSION["id"]=$row["userid"];
       
       header("Location:dashbord.php");
        exit();
     }
     else{
      echo "<div class=' container alert alert-danger' >عذرا انت لست من الادمن</div>";

     }

     

}
    
 ?>

    









<form class="login" action="<?php echo $_SERVER["PHP_SELF"]?>" method="POST">
<h1 style="text-align:center">login Admin</h1>
    <input class="m" type="text" name="user" placeholder="username" autocomplete="no"/> 
    <input class="m" type="password" name="pass" placeholder="password" autocomplete="no"/>
    <input class="m" type="submit" value="Enter">

</form>


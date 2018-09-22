
<nav class="navbar navbar-default">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button> 
      <a class="navbar-brand active" href="index.php">PROFILE mohammed abbas</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right" >
     
      <li ><a style="color:red" href="../index.php">الذهاب لصفحة الادمن</a></li>
     <?php if(isset($_SESSION["user"])){?>
      <li ><a style="color:red" href="end.php">الخروج</a></li>
     <?php } ?>




            <?php 
            $cats=getcat();
            foreach($cats as $cat){//لطباعة الافسام 
               echo "<li><a href ='categores.php?pageid=".$cat['id']."&pagename=".$cat["name"]."'>". $cat['name']."</a></li>";

            }
            
            ?>
      </ul>
     
      <ul class="nav navbar-nav navbar-right">
       
        <li class="dropdown">
         
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>




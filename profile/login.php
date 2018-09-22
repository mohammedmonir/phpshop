<?php
ob_start(); 
session_start();
$pagetitle="login";
if(isset ($_SESSION["user"])){
header("Location:index.php");
}

include "header.php";
include "../connection.php";
include "../function.php";
include "upper.php";
include "navbar.php";

if($_SERVER["REQUEST_METHOD"]=="POST"){

    if(isset($_POST["login"])){//عشااان اتحقق اذا الطلب جاي من قورم اللوجن ولا من فورم الساين اب..طبعا عن طريق تسمية زر السبمت
    
        $name = $_POST['name'];
        $pass = $_POST['password'];
    
        $stmt=$db->prepare("SELECT userid,name,password FROM users WHERE name=? AND password=?");//الادمن هو الذين يحتوي groupid على 0
                                                                                                                //الاعضاء راح ينضافو الهم 1 بشكل تلقائي...الا الادمن بعدل عليه من قواعد البيانات وبحط بدال الواحد صفر        
        $stmt->execute(array($name,$pass));
        $getuserid = $stmt->fetch();
       
        $count = $stmt->rowCount();
       
    
         if($count > 0){
           $_SESSION["user"]=$name;
           $_SESSION["UserId"]= $getuserid["userid"];// خزنت في السيشن ايدي الشخص..طبعا انا جلبتو عن طريق فيتش ..طبعا انا خرنت في السيشن ايدي الشخص عشان الايدي بلزمني في اضافة الاعلانات في البروفايل الشخصي
           
           
           header("Location:index.php");
            exit();
         }
         else{
          echo "<div class=' container alert alert-danger' >عذرا انت  غير مسجل</div>";
    
         }}else{//يعني الطلب جاي من الفورم الثانية..لانو زر السبمت اسمو ساين اب
             
            $formerror=array();
            $name=$_POST["name"];
            $email=$_POST["email"];
            $pass1=$_POST["password"];
            $pass2=$_POST["password2"];
// لعمل فلتر والتحقق من الاخطاء
            if(isset($_POST["name"])){
                $filtername=filter_var($_POST["name"],FILTER_SANITIZE_STRING);// اول شئ بعمل تنقية لحقل الاسم ثم بفحصو اذا اقل من 4 او لا
                if(strlen($filtername) < 4){
                    $formerror[]="the name is less than 4";
                 }
            }
            if(isset($_POST["password"]) && isset($_POST["password2"])){

                if(empty($_POST["password"])){

                $formerror[]="the password is empty";
                }
                if(empty($_POST["password2"])){
                    
                                    $formerror[]="the password2 is empty";
                                    }
                $pass1=$_POST["password"];
                $pass2=$_POST["password2"];
                if($pass1 !== $pass2){
                    $formerror[]="the passowed one is diffirent to password two <br>";


                }

            if(isset($_POST["email"])){
                $filteremail=filter_var($_POST["email"],FILTER_SANITIZE_EMAIL); 
                if(filter_var($filteremail,FILTER_VALIDATE_EMAIL) !=true ){
                    $formerror[]="the email is not valied";

                }
            }
            }
            if(empty($formerror)){
                
            
                $check = checkitem("name","users",$name); //فنكشن لفحص الاسم هل هو موجود ام لا...يجب ان يكون الاسم غير مكرر في قاعدة البيانات حتى يعمل هذا الفنكشن
                if($check==1){

                        echo "Sorry :this name is exist";

                }
                else{
                

                $stmt=$db->prepare("INSERT INTO users(name,password,email,state,date)
                 VALUES(:zuser,:zpassword,:zemail,1,now())");// سوف يضاف الشخص تلقائيا غير مفعل لانو الحالة تساوي 1
                $stmt->execute(array(
                        'zuser'         =>$name,
                        'zpassword'     =>$pass1,
                        'zemail'        =>$email
                        


                ));
       $successmsg="the login was successed";
               

        
                }
        }




         }
    }


   
?> 

<h1 class="text-center log1">
    <span class="selected " data-class="login1">Login </span>|
    <span data-class="signup">SignUp</span>
</h1>

<form class="container login1" action="<?php echo $_SERVER["PHP_SELF"]?>" method="POST" >
    <input type="text" name="name" class="form-control" placeholder="name" />
    <input type="password" name="password" class="form-control" placeholder="passoword"/>
    <input type="submit" name="login" value="login" class="form-control btn btn-primary" />

</form>






<form class="container signup " style="display:none" action="<?php echo $_SERVER["PHP_SELF"]?>" method="POST">
    <input type="text" name="name" class="form-control " placeholder="name" />
    <input type="email" name="email" class="form-control" placeholder="email"/>
    <input type="password" name="password" class="form-control" placeholder="passoword"/>
    <input type="password" name="password2" class="form-control" placeholder="passoword again"/>
    <input type="submit"  name="signup" value="sing up" class="form-control btn btn-success"/>

</form>
<?php //لطباعة الاخطاء
if(!empty($formerror)){
    echo "<div class='text-center' style='position: absolute; top: 435px; left: 505px; background: #f5b9b9; padding: 30px; width: 348px;'>";
    foreach($formerror as $error){
        echo $error.'<br>';
        echo "</div>";
        
    }}
   
if(isset($successmsg)){// الرسالة سوف تكون موجودة اذا تحقق استعلام الاضافة
        echo "<div class='text-center' style='position: absolute; top: 435px; left: 505px; background: green; padding: 30px; width: 348px;'>";
       echo $successmsg;
       echo "</div>";

    }

?>










<?php
include "footer.php";
ob_end_flush();
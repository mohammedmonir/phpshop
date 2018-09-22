<?php 







function getitemsprofile($value){//لعرض اخر الاعلانات في صفحة البروقايل
    
    global $db;
    $getstmt=$db->prepare("SELECT * FROM items WHERE member_id=? ORDER BY name_id DESC");
    $getstmt->execute(array($value));
    $row = $getstmt->fetchAll();
    return $row;
    
    
    }






function gettitle(){//فنكشن خاصة بالعنوان

    global $pagetitle;

    if(isset($pagetitle)){
echo $pagetitle;


    }
}



function checkuserstatus($user){//لفحص حالة المستخدم
    
    global $db;
    $getstmt=$db->prepare("SELECT name,state FROM users WHERE name=? AND state=1");
    $getstmt->execute(array($user));
    $row = $getstmt->rowCount();
    return $row;
    
    
    }





function getcat(){//لعرض كل بيانات جدول الاقسام
    
    global $db;
    $getstmt=$db->prepare("SELECT * FROM categories WHERE parent=0 ORDER BY id ASC");
    $getstmt->execute();
    $row = $getstmt->fetchAll();
    return $row;
    
    
    }

    function getitems($catid){//لعرض الانواع المرتبطة بالقسم
        
        global $db;
        $getstmt=$db->prepare("SELECT * FROM items WHERE cat_id=?");
        $getstmt->execute(array($catid));
        $row = $getstmt->fetchAll();
        return $row;
        
        
        }
    


 function redrict($msg,$seconds){//فنكشن للتحويل للصفحة الرئيسية
 
echo "<div class='alert alert-danger'>$msg</div>";
echo "<div class='alert alert-success'>we will be rediecter to home page. $seconds</div>";

header("refresh:$seconds;url=index.php");
exit();


}

function checkitem($selected,$table,$value){//فنكشن لفحص اسم المستخدم هل هو موجود ام لا
global $db;
$statement=$db->prepare("SELECT $selected FROM $table WHERE $selected =?");
$statement->execute(array($value));
$count = $statement->rowCount();
return $count;




}


function countitem($selected,$table){// لحساب عدد الاعضاء بالجدول
    global $db;
$stmt2=$db->prepare("SELECT COUNT($selected) FROM $table");
$stmt2->execute();
return $stmt2->fetchColumn();



}


function getlatest($selected,$table,$order,$limit=5){//لعرض اخر 5 اسماء في جدول قواعد البيانات

global $db;
$getstmt=$db->prepare("SELECT $selected FROM $table ORDER BY $order DESC LIMIT $limit");
$getstmt->execute();
$row = $getstmt->fetchAll();
return $row;


}


    $(document).ready(function() {




            
                // عندما اكتب اسم الشخص تظهر في الصورة بشكل مباشر في صفحة اضافة اعلان
      $(".live-name1").keyup(function(){
                    
                       $(".live-img div h1").text($(this).val());
                    
                });

            $(".live-disc").keyup(function(){
                
                   $(".live-img div p").text($(this).val());
                
            });

            $(".live-price").keyup(function(){
                
                   $(".live-img div span").text('$'+$(this).val());
                
            });










        $("h1 span").click(function(){//للتبديل بين فورم التسجيل وفورم تسجيل الدخول 

            $(this).addClass("selected").siblings().removeClass("selected");// لتحويل اللون
            $("form").hide();
            $('.'+ $(this).data('class')).fadeIn(400);
        });

    
       


        $(".toggle-info").click(function(){// لاخفاء اخر 5 اسماء واخر 5 اصناف من صفحة الداشبورد..وايضا لاظهار علامة +وعلامة -ء )(مشروح بالدفتر)

            $(this).toggleClass('selected').parent().next().fadeToggle(300);

            if($(this).hasClass('selected')){

                $(this).html('<i class="fa fa-minus fa-lg"></i>');
            }
            else{

                $(this).html('<i class="fa fa-plus fa-lg"></i>'); 
            }

        });
  




$("input").each(function(){//لوضع علامة نجمة في الحقول التي تحتوي على اتربيوت اسمو required
if($(this).attr("required")=="required"){


$(this).after("<span class='select'>*</span>");}
});



$(".confirm").click(function(){//لتاكيد على الحذف

return confirm("are you sure to delete");


});

$(".cat h1").click(function(){//عند الضغط على عنوان القسم يختفي التفاصيل
$(this).next().fadeToggle(500);

});


$(".ordering span").click(function(){//عند الضغط على رؤية الكل او رؤية العنوان فقط في صفحة الاقسام

    if($(this).data('view')=="full"){  //   عشان اعرف اي زر ضغطت عن طريق الداتا فيو الموجودة في الزرين span

        $(".cat .full-view").fadeIn(); 
        $("div .cat").css("padding","20px");
       }
       
       else{
        $(".cat .full-view").fadeOut(); 
        $("div .cat").css("padding","0");
       }
});
   



 });
    


    

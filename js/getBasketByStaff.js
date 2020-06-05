function getBasketByStaff(elem){
   $.ajax({
     url:"script/_getBasketByStaff.php",
     type:"POST",
     success:function(res){
       elem.html("");
       elem.append("<option>....اختر....</option>");
       $.each(res.data,function(){
         elem.append("<option value='"+this.id+"'>سلة رقم "+this.id+'-'+this.customer_name+"</option>");
       });
       elem.selectpicker('refresh');
       console.log(res);
     },
     error:function(e){
        elem.append("<option value='' class='bg-danger'>خطأ اتصل بمصمم النظام</option>");
        console.log(e);
     }
   });
}
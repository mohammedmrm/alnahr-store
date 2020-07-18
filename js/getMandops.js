function getMandops(elem,store){
   $.ajax({
     url:"script/_getMandops.php",
     type:"POST",
     data:{store: store},
     success:function(res){
       elem.html("");
       elem.append("<option>اختر مندوب</option>");
       $.each(res.data,function(){
         elem.append("<option value='"+this.id+"'>"+this.name+'-'+this.phone+"</option>");
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
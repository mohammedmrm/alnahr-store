function getCategories(elem){
   $.ajax({
     url:"script/_getCategories.php",
     type:"POST",
     data:{branch: branch},
     success:function(res){
       elem.html("");
       elem.append(
           '<option value="">... اختر ...</option>'
       );
       $.each(res.data,function(){
         elem.append("<option value='"+this.id+"'>"+this.name+"</option>");
       });
       console.log(res);
       elem.selectpicker('refresh');
     },
     error:function(e){
        elem.append("<option value='' class='bg-danger'>خطأ اتصل بمصمم النظام</option>");
        console.log(e);
     }
   });
}
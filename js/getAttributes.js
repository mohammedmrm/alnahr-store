function getAttributes(elem){
$.ajax({
  url:"script/_getAttributes.php",
  type:"POST",
  success:function(res){
   console.log(res);
   elem.html("");
     elem.append(
       '<option>... اختر  ...</option>'
     );
   $.each(res.data,function(){
     elem.append(
       '<option value="'+this.id+'">'+this.name +'</option>'
     );
     elem.selectpicker('refresh');
   });
  },
  error:function(e){
    console.log(e);
  }
});
}
function getBasketByStaff(elem) {
  $.ajax({
    url: "script/_getBasketByStaff.php",
    type: "POST",
    success: function (res) {
      elem.html("");
      elem.append("<option>....اختر....</option>");
      $.each(res.data, function () {
        type = "";
        if (this.type == '2') {
          type = " (استبدال) ";
        }
        elem.append("<option value='" + this.id + "'>سلة رقم " + this.id + '-' + this.customer_name + type + "</option>");
      });
      elem.selectpicker('refresh');
      console.log(res);
    },
    error: function (e) {
      elem.append("<option value='' class='bg-danger'>خطأ اتصل بمصمم النظام</option>");
      console.log(e);
    }
  });
}
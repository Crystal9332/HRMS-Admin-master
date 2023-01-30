$(document).ready(function() {
  $("form#form_setting").on("submit", function(e) {
    e.preventDefault();

    var fd = new FormData();
    fd.append("file", $("#logo")[0].files[0]);
    fd.append("name", $("#name").val());
    fd.append("location", $("#location").val());
    fd.append("email", $("#email").val());
    fd.append("phone", $("#phone").val());
    
    $.ajax({
        url: "/settings/updateInfo",
        type: "post",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: fd,
        dataType: "json",
        async: false,
        processData: false,
        contentType: false,
        success: function(data) {
          if(data.status == 1) {
            location.reload();
          } else if (data.status == 0) {
            showMessage(
                $("form")
                    .find("div.form-body")
                    .find("div.message"),
                "warning",
                "Email is already existed. Please use other email."
            );
          }
        }
    });

    return false;
  });

});

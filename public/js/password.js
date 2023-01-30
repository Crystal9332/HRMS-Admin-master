$(document).ready(function() {
    var password = document.getElementById("password"),
        confirm_password = document.getElementById("confirm_password");

    password.onchange = validatePassword;
    confirm_password.onkeyup = validatePassword;

    $("form.form-password").on("submit", function() {
        $.ajax({
            url: "/changePassword",
            type: "post",
            dataType: "text",
            async: false,
            data: {
                old_pass: $("#old_pass").val(),
                password: $("#password").val(),
                _token: _token
            },
            success: function(response) {
                if (response == "1") {
                    showMessage(
                        $("#password_modal")
                            .find("form")
                            .find(".modal-body"),
                        "success",
                        "Successfully changed!"
                    );
                    setTimeout(function() {
                        $("#password_modal").modal("hide");
                    }, 1000);
                } else if (response == -1) {
                    showMessage(
                        $("#password_modal")
                            .find("form")
                            .find(".modal-body"),
                        "warning",
                        "Previous password is wrong!"
                    );
                }
            }
        });
    });

    $("#password_modal").on("hide.bs.modal", function() {
        $("#old_pass").val("");
        $("#password").val("");
        $("#confirm_password").val("");
        $("#password_modal")
            .find(".alert")
            .remove();
    });

    function validatePassword() {
        if (password.value != confirm_password.value) {
            confirm_password.setCustomValidity("Passwords Don't Match");
        } else {
            confirm_password.setCustomValidity("");
        }
    }
});

function showMessage(e, i, c) {
    var l = $(
        '<div class="alert alert-' +
            i +
            ' alert-dismissible fade show add-category-message-type" role="alert">\n' +
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
            '<span aria-hidden="true">&times;</span>\n' +
            "</button>\n" +
            "<strong>" +
            c +
            "</strong>" +
            "</div>"
    );
    l.prependTo(e);
}

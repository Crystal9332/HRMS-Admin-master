$(document).ready(function() {
    $("#city").on("change", function() {
        if ($(this).val() == "") {
            $("#site").val("");
            return;
        }

        $.ajax({
            url: "/getSites/" + $(this).val(),
            type: "get",
            dataType: "json",
            async: false,
            success: function(response) {
                $("#site").empty();
                $("#site").append(
                    $("<option>", {
                        value: "",
                        text: "Choose Site"
                    })
                );
                $.each(response.data, function(i, data) {
                    $("#site").append(
                        $("<option>", {
                            value: data.id,
                            text: data.name
                        })
                    );
                });
            }
        });
    });
});

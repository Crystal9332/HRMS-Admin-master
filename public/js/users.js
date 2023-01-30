$(document).ready(function() {
    var content_table = false,
        flag = false;

    initUserTable();

    $("#user-table tbody").on("click", ".delete-user", function() {
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this data!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!"
        }).then(result => {
            if (result.value) {
                let id = $(this).attr("d-id");
                $.ajax({
                    url: "/users/destroy",
                    type: "delete",
                    data: {
                        id: id,
                        _token: _token
                    },
                    dataType: "text",
                    success: function(data) {
                        if (data == "1") {
                            swal(
                                "Deleted!",
                                "Data has been deleted.",
                                "success"
                            );
                            initUserTable();
                        } else if (data == "-1") {
                            swal(
                                "Warning!",
                                "Can't delete this user.",
                                "warning"
                            );
                        }
                    }
                });
            } else if (
                // Read more about handling dismissals
                result.dismiss === swal.DismissReason.cancel
            ) {
            }
        });
    });

    function initUserTable() {
        if (content_table) {
            content_table.clear().draw();
            content_table.destroy();
        }
        content_table = $("#user-table").DataTable({
            responsive: true,
            ajax: {
                url: "getUsers"
            },
            columns: [
                {
                    data: "userId"
                },
                {
                    data: "name"
                },
                {
                    data: "email"
                },
                {
                    data: "phone"
                },
                {
                    data: "city"
                },
                {
                    data: "site"
                },
                {
                    data: "job"
                },
                {
                    data: "expiry_date"
                },
                {
                    data: "role"
                },
                {
                    data: "approvedStatus"
                },
                {
                    data: "id"
                }
            ],
            columnDefs: [
                {
                    targets: -2,
                    orderable: false,
                    render: function(data) {
                        let checkStatus = data.status == 1 ? "checked" : "";
                        return (
                            `<input type="checkbox" class="approve-switch" e-id="` +
                            data.id +
                            `" data-color="#009efb" data-secondary-color="#f62d51" ` +
                            checkStatus +
                            `/>`
                        );
                    }
                },
                {
                    targets: -1,
                    orderable: false,
                    render: function(id) {
                        let url = "/users/" + id;
                        return (
                            `
                        <a href="` +
                            url +
                            "/edit" +
                            `"><i class="mdi mdi-lead-pencil"></i></a>&nbsp;&nbsp;
                        <a href="` +
                            url +
                            `"><i class="mdi mdi-eye"></i></a>&nbsp;&nbsp;
                        <a href="` +
                            "/showReport/" + id +
                            `"><i class="ti-book"></i></a>&nbsp;&nbsp;
                        <a href="javascript:;"><i class="mdi mdi-delete delete-user" d-id="` +
                            id +
                            `"></i></a>
                    `
                        );
                    }
                }
            ],
            order: [[0, "asc"]],
            initComplete: function(settings, json) {
                $(".approve-switch").each(function() {
                    new Switchery($(this)[0], $(this).data());
                });
                $(".approve-switch").on("change", function() {
                    if (flag) return (flag = false);
                    let switchBtn = $(this);
                    let message = "Yes, Block this user!";
                    let btnColor = "rgb(221, 107, 85)";
                    if (switchBtn.is(":checked")) {
                        message = "Yes, Aprrove this user!";
                        btnColor = "rgb(0, 158, 251)";
                    }
                    swal({
                        title: "Are you sure?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: btnColor,
                        confirmButtonText: message
                    }).then(result => {
                        if (result.value) {
                            $.ajax({
                                url: "/approveUser",
                                type: "POST",
                                data: {
                                    id: switchBtn.attr("e-id"),
                                    approved: switchBtn.is(":checked") ? 1 : 0,
                                    _token: _token
                                },
                                dataType: "text",
                                success: function(data) {
                                    console.log("data", data);
                                }
                            });
                        } else {
                            flag = true;
                            switchBtn.click();
                        }
                    });
                });
            }
        });
    }
});

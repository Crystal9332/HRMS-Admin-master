$(document).ready(function() {
    let qr_table = $("#qr-table").DataTable({
        responsive: true,
        ajax: {
            url: "getQrs"
        },
        columns: [
            {
                data: "id"
            },
            {
                data: "city"
            },
            {
                data: "site"
            },
            {
                data: "email"
            },
            {
                data: "start_time"
            },
            {
                data: "end_time"
            },
            {
                data: "send_time"
            },
            {
                data: "id"
            }
        ],
        columnDefs: [
            {
                targets: -1,
                orderable: false,
                render: function(id) {
                    let url = "/qrs/" + id;
                    return (
                        `
                        <a href="` +
                        url +
                        `"><i class="mdi mdi-eye"></i></a>&nbsp;&nbsp;
                        <a href="javascript:;"><i class="mdi mdi-delete delete-qr" d-id="` +
                        id +
                        `"></i></a>
                    `
                    );
                }
            }
        ],
        order: [[0, "asc"]]
    });

    $("#qr-table tbody").on("click", ".delete-qr", function() {
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
                    url: "/qrs/destroy",
                    type: "delete",
                    data: {
                        id: id,
                        _token: _token
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.status == "1") {
                            swal(
                                "Deleted!",
                                "Data has been deleted.",
                                "success"
                            );
                            qr_table.ajax.reload();
                        } else if (data.status == "-1") {
                            swal(
                                "Warning!",
                                "Can't delete this qr-code. First delete all info that related with this qr-code.",
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
});

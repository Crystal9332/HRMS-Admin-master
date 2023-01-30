$(document).ready(function() {
    let group_table = $("#group-table").DataTable({
        responsive: true,
        ajax: {
            url: "/jobs"
        },
        columns: [
            {
                data: "cnt"
            },
            {
                data: "name"
            },
            {
                data: ""
            }
        ],
        columnDefs: [
            {
                targets: -1,
                orderable: false,
                render: function() {
                    return `
                        <a href="javascript:;" class="edit-group"><i class="mdi mdi-lead-pencil"></i></a>&nbsp;&nbsp;
                        <a href="javascript:;" class="delete-group"><i class="mdi mdi-delete"></i></a>
                    `;
                }
            }
        ],
        order: [[0, "asc"]]
    });

    $("#group-table tbody").on("click", ".edit-group", function() {
        let selectedData = group_table.row($(this).closest("tr")).data();

        $("#group-modal").modal("show");
        $("#group-modal #edit-id").val(selectedData.id);
        $("#group-modal #group-text").val(selectedData.name);
        $("#group-modal .modal-title").text("Edit Group");
        $("#group-modal .btn-group").text("Edit");
    });

    $("#group-table tbody").on("click", ".delete-group", function() {
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this data!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!"
        }).then(result => {
            if (result.value) {
                $.ajax({
                    url: "/jobs/destroy",
                    type: "delete",
                    data: {
                        id: group_table.row($(this).closest("tr")).data().id,
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
                            group_table.ajax.reload();

                            loadSubjectSelection();
                        } else if (data == "-1") {
                            swal(
                                "Warning!",
                                "Can't delete this group. First delete users that related with this group.",
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

    $("#group-modal").on("hide.bs.modal", function() {
        $("#group-modal #edit-id").val("0");
        $("#group-modal #group-text").val("");
        $("#group-modal .modal-title").text("Add Group");
        $("#group-modal .btn-group").text("Add");

        $("#group-modal")
            .find(".alert")
            .remove();
    });

    $(".form-group").on("submit", function(e) {
        e.preventDefault();

        let id = $("#edit-id").val();
        let text = $("#group-text").val();

        let url = "/jobs",
            method = "post";
        if (id > 0) {
            url = "/jobs/" + id;
            method = "put";
        }

        $.ajax({
            url: url,
            type: method,
            data: {
                name: text,
                _token: _token
            },
            dataType: "text",
            success: function(data) {
                processResult(data);
            }
        });
    });

    function processResult(data) {
        if (data == "1") {
            group_table.ajax.reload();

            $("#group-modal").modal("hide");
        } else if (data == -1) {
            showMessage(
                $("#group-modal")
                    .find("form")
                    .find(".modal-body"),
                "warning",
                "Group name is already existed!"
            );
        }
    }
});

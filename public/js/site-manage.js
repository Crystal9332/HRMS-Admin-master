/*
 * Functions
 */
//Load Site Table
let site_table = false;

function initializeTable(id) {
    if (site_table) {
        site_table.clear().draw();
        site_table.destroy();
    }

    site_table = $("#site-table").DataTable({
        responsive: true,
        ajax: {
            url: "getSites/" + id,
            type: "get"
        },
        columns: [
            {
                data: "cnt"
            },
            {
                data: "name"
            },
            {
                data: "office_phone"
            },
            {
                data: "first_mng_name"
            },
            {
                data: "first_phone"
            },
            {
                data: "second_mng_name"
            },
            {
                data: "second_phone"
            },
            {
                data: "email"
            },
            {
                data: "location"
            },
            {
                data: ""
            }
        ],
        columnDefs: [
            {
                targets: -3,
                render: function(email) {
                    let style = "text-info";
                    if (email == null) {
                        style = "text-warning";
                        email = "Not selected";
                    }

                    return `<div class="` + style + `">` + email + `</div>`;
                }
            },
            {
                targets: -1,
                orderable: false,
                render: function(data) {
                    return `
                <a href='javascript:;' class='edit-site'><i class='mdi mdi-lead-pencil'></i></a>&nbsp;&nbsp;
                <a href='javascript:;' class='delete-site'><i class='mdi mdi-delete'></i></a>
                `;
                }
            }
        ],
        order: [[0, "asc"]]
    });
}

//Load City for select
function loadCitySelection() {
    $.ajax({
        url: "/getCities",
        method: "get",
        dataType: "json",
        async: false,
        success: function(response) {
            $("#select-city").empty();

            $.each(response.data, function(i, data) {
                if (i == 0) {
                    initializeTable(data.id);
                    $("#select-city").append(
                        $("<option>", {
                            value: data.id,
                            text: data.name
                        }).prop("selected", true)
                    );
                    $("#selected_city_name").val(data.name);
                } else {
                    $("#select-city").append(
                        $("<option>", {
                            value: data.id,
                            text: data.name
                        })
                    );
                }
            });
        }
    });
}

$(document).ready(function() {
    let locations = {};

    $("#location").typeahead({
        source: function(term, process) {
            return $.get(
                route,
                {
                    term: term
                },
                function(data) {
                    locations = data;
                    return process(data);
                }
            );
        }
    });

    loadCitySelection();

    $("#site-table tbody").on("click", ".edit-site", function() {
        let selectedData = site_table.row($(this).closest("tr")).data();

        console.log(selectedData);

        $("#site-modal").modal("show");
        $("#site-modal #edit-site-id").val(selectedData.id);
        $("#site-modal #site_name").val(selectedData.name);
        $("#site-modal #office_phone").val(selectedData.office_phone);
        $("#site-modal #first_mng_name").val(selectedData.first_mng_name);
        $("#site-modal #first_phone").val(selectedData.first_phone);
        $("#site-modal #second_mng_name").val(selectedData.second_mng_name);
        $("#site-modal #second_phone").val(selectedData.second_phone);
        $("#site-modal #location").val(selectedData.location);
        $("#site-modal #ref_email").val(selectedData.email);
        $("#site-modal .modal-title").text("Edit Site");
        $("#site-modal .btn-site").text("Edit");
    });

    $("#site-table tbody").on("click", ".delete-site", function() {
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
                    url: "/sites/destroy",
                    type: "delete",
                    data: {
                        id: site_table.row($(this).closest("tr")).data().id,
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
                            site_table.ajax.reload();
                        } else if (data == "-1") {
                            swal(
                                "Warning!",
                                "Can't delete this site. First delete users that related with this site.",
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

    $("#site-modal").on("hide.bs.modal", function() {
        $("#site-modal #edit-site-id").val("0");
        $("#site-modal #site_name").val("");
        $("#site-modal #office_phone").val("");
        $("#site-modal #first_mng_name").val("");
        $("#site-modal #first_phone").val("");
        $("#site-modal #second_mng_name").val("");
        $("#site-modal #second_phone").val("");
        $("#site-modal #location").val("");
        $("#site-modal #ref_email").val("");
        $("#site-modal .modal-title").text("Add Site");
        $("#site-modal .btn-site").text("Add");

        $("#site-modal")
            .find(".alert")
            .remove();
    });

    $(".form-site").on("submit", function(e) {
        e.preventDefault();

        if (!checkLocations($("#location").val())) {
            $("#location").val("");
            return;
        }

        let id = $("#edit-site-id").val();

        let url = "/sites",
            method = "post";
        if (id > 0) {
            url = "/sites/" + id;
            method = "put";
        }

        $.ajax({
            url: url,
            type: method,
            data: {
                city_id: $("#select-city").val(),
                name: $("#site_name").val(),
                office_phone: $("#office_phone").val(),
                first_mng_name: $("#first_mng_name").val(),
                first_phone: $("#first_phone").val(),
                second_mng_name: $("#second_mng_name").val(),
                second_phone: $("#second_phone").val(),
                location: $("#location").val(),
                email: $("#ref_email").val(),
                _token: _token
            },
            dataType: "text",
            success: function(data) {
                if (data == "Success") {
                    site_table.ajax.reload();

                    $("#site-modal").modal("hide");
                } else if (data == "Invalid email") {
                    showMessage(
                        $("#site-modal")
                            .find("form")
                            .find(".modal-body"),
                        "warning",
                        "Reference email is already existed!"
                    );
                } else if (data == "Invalid site name") {
                    showMessage(
                        $("#site-modal")
                            .find("form")
                            .find(".modal-body"),
                        "warning",
                        "Site name is already existed!"
                    );
                }
            }
        });
    });

    $("#select-city").on("change", function() {
        $("#selected_city_name").val($("#select-city option:selected").text());

        initializeTable($(this).val());
    });

    function checkLocations(location) {
        let response = false;
        $.ajax({
            url: "/checkLocation",
            type: "get",
            dataType: "text",
            async: false,
            data: { location: location },
            success: function(data) {
                response = data;
            }
        });
        return response;
    }
});

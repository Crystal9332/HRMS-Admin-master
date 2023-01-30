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

    let city_table = $("#city-table").DataTable({
        responsive: true,
        ajax: {
            url: "/getCities"
        },
        columns: [
            {
                data: "cnt"
            },
            {
                data: "name"
            },
            {
                data: "country"
            },
            {
                data: "office_phone"
            },
            {
                data: "manager_name"
            },
            {
                data: "manager_phone"
            },
            {
                data: "second_mng_name"
            },
            {
                data: "second_mng_phone"
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
                targets: -1,
                orderable: false,
                render: function() {
                    return `
                <a href="javascript:;" class="edit-city"><i class="mdi mdi-lead-pencil"></i></a>&nbsp;&nbsp;
                <a href="javascript:;" class="delete-city"><i class="mdi mdi-delete"></i></a>
                `;
                }
            }
        ],
        order: [[0, "asc"]]
    });

    $("#city-table tbody").on("click", ".edit-city", function() {
        let selectedData = city_table.row($(this).closest("tr")).data();

        $("#city-modal").modal("show");
        $("#city-modal #edit-id").val(selectedData.id);
        $("#city-modal #city_name").val(selectedData.name);
        $("#city-modal #country").val(selectedData.country);
        $("#city-modal #office_phone").val(selectedData.office_phone);
        $("#city-modal #manager_name").val(selectedData.manager_name);
        $("#city-modal #manager_phone").val(selectedData.manager_phone);
        $("#city-modal #second_mng_name").val(selectedData.second_mng_name);
        $("#city-modal #location").val(selectedData.location);
        $("#city-modal .modal-title").text("Edit City");
        $("#city-modal .btn-city").text("Edit");
    });

    $("#city-table tbody").on("click", ".delete-city", function() {
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
                    url: "/cities/destroy",
                    type: "delete",
                    data: {
                        id: city_table.row($(this).closest("tr")).data().id,
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
                            city_table.ajax.reload();

                            loadSubjectSelection();
                        } else if (data == "-1") {
                            swal(
                                "Warning!",
                                "Can't delete this city. First delete sites that related with this city.",
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

    $("#city-modal").on("hide.bs.modal", function() {
        $("#city-modal #edit-id").val("0");
        $("#city-modal #city_name").val("");
        $("#city-modal #country").val("");
        $("#city-modal #office_phone").val("");
        $("#city-modal #manager_name").val("");
        $("#city-modal #manager_phone").val("");
        $("#city-modal #second_mng_name").val("");
        $("#city-modal #location").val("");
        $("#city-modal .modal-title").text("Add City");
        $("#city-modal .btn-city").text("Add");

        $("#city-modal")
            .find(".alert")
            .remove();
    });

    $(".form-city").on("submit", function(e) {
        e.preventDefault();

        if (!checkLocations($("#location").val())) {
            $("#location").val("");
            return;
        }

        let id = $("#edit-id").val(),
            url = "/cities",
            method = "post";
        if (id > 0) {
            url = "/cities/" + id;
            method = "put";
        }

        $.ajax({
            url: url,
            type: method,
            data: {
                name: $("#city_name").val(),
                country: $("#country").val(),
                office_phone: $("#office_phone").val(),
                manager_name: $("#manager_name").val(),
                manager_phone: $("#manager_phone").val(),
                second_mng_name: $("#second_mng_name").val(),
                second_mng_phone: $("#second_mng_phone").val(),
                location: $("#location").val(),
                _token: _token
            },
            dataType: "text",
            success: function(data) {
                processResult(data);
            }
        });
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

    function processResult(data) {
        if (data == "success") {
            city_table.ajax.reload();
            $("#city-modal").modal("hide");
        } else if (data == "fail") {
            showMessage(
                $("#city-modal")
                    .find("form")
                    .find(".modal-body"),
                "warning",
                "City name is already existed!"
            );
        }
    }
});

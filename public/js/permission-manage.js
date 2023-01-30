/*
 * Functions
 */
//Load Time Table
let permission_table = false,
    flag = false,
    users = false;

function initializeTable(city_id) {
    if (permission_table) {
        permission_table.clear().draw();
        permission_table.destroy();
    }

    permission_table = $("#permission_table").DataTable({
        responsive: true,
        ajax: {
            url: "/getPermissions/" + city_id,
            type: "get"
        },
        columns: [
            {
                data: "cnt"
            },
            {
                data: "site_name"
            },
            {
                data: "user_name"
            },
            {
                data: "user_email"
            },
            {
                data: "user_link"
            }
        ],
        columnDefs: [
            {
                targets: -1,
                orderable: false,
                render: function(user_link) {
                    return (
                        `
                        <a href='javascript:;' class='edit-permission' title='Change Site Manager'><i class='mdi mdi-lead-pencil'></i></a>&nbsp;&nbsp;
                        <a href='` +
                        user_link +
                        `' class='view-permission' title='View Site Manager information'><i class='mdi mdi-eye'></i></a>
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
                let message = "Yes, Block this permission!";
                let btnColor = "rgb(221, 107, 85)";
                if (switchBtn.is(":checked")) {
                    message = "Yes, Aprrove this permission!";
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
                            url: "/approveUserPermission",
                            type: "POST",
                            data: {
                                id: permission_table
                                    .row($(this).closest("tr"))
                                    .data().id,
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

//Load City for select
function loadCitySelection() {
    $.ajax({
        url: "/getCities",
        method: "get",
        dataType: "json",
        async: false,
        success: function(response) {
            $("#select_city").empty();

            $.each(response.data, function(i, data) {
                if (i == 0) {
                    getCityManager(data.id);
                    initializeTable(data.id);
                    $("#select_city").append(
                        $("<option>", {
                            value: data.id,
                            text: data.name
                        }).prop("selected", true)
                    );
                    $(".selected-city-name").val(data.name);
                } else {
                    $("#select_city").append(
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

function getUsers(site_id = 0) {
    let url = "/getUsersBySite/" + site_id;
    let obj = $("#select_site_manager");
    if (site_id == 0) {
        url = "/getUsersByCity/" + $("#select_city").val();
        obj = $("#select_city_manager");
    }
    $.ajax({
        url: url,
        method: "get",
        dataType: "json",
        async: false,
        success: function(result) {
            users = result.data;
            obj.empty();

            obj.append(
                $("<option>", {
                    value: "",
                    text: "Choose user"
                })
            );

            $.each(result.data, function(i, res) {
                obj.append(
                    $("<option>", {
                        value: res.id,
                        text: res.name
                    })
                );
            });
        }
    });
}

function generateHtml(id) {
    let user = false;
    $.each(users, function(i, data) {
        data.id == id ? (user = data) : "";
    });

    if (!user) return "";

    let html =
        `<div class="form-group row">
					<label class="col-sm-2 text-right control-label col-form-label">Email :</label>
					<div class="col-sm-9">
						<input type="text" class="form-control bg-white" value="` +
        user.email +
        `" readonly>
					</div>
				</div>`;
    html +=
        `<div class="form-group row">
					<label class="col-sm-2 text-right control-label col-form-label">Gender :</label>
					<div class="col-sm-9">
						<input type="text" class="form-control bg-white" value="` +
        user.gender +
        `" readonly>
					</div>
				</div>`;
    html +=
        `<div class="form-group row">
					<label class="col-sm-2 text-right control-label col-form-label">Phone :</label>
					<div class="col-sm-9">
						<input type="text" class="form-control bg-white" value="` +
        user.phone +
        `" readonly>
					</div>
				</div>`;
    return html;
}

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

function getCityManager(city_id) {
    $.ajax({
        url: "/getCityManager",
        type: "post",
        data: {
            city_id: city_id,
            _token: _token
        },
        dataType: "json",
        async: false,
        success: function(data) {
            $("#city_manager_id").val(data.id);
            $("#city_manager_name").val(data.name);
        }
    });
}

$(document).ready(function() {
    loadCitySelection();

    $("#edit_city_manager").on("click", function() {
        $("#modal_city_manager").modal("show");

        getUsers();
    });

    $("#modal_city_manager").on("hide.bs.modal", function() {
        $(".form-city-manager")
            .find(".modal-body")
            .find(".city-manager-info")
            .html("");
    });

    $(".form-city-manager").on("submit", function(e) {
        e.preventDefault();

        $.ajax({
            url: "/changeCityManager",
            type: "post",
            data: {
                user_id: $("#select_city_manager").val(),
                _token: _token
            },
            dataType: "text",
            success: function(data) {
                if (data == "success") {
                    $("#city_manager_id").val($("#select_city_manager").val());
                    $("#city_manager_name").val(
                        $("#select_city_manager option:selected").text()
                    );
                    $("#modal_city_manager").modal("hide");
                }
            }
        });
    });

    $("#permission_table tbody").on("click", ".edit-permission", function() {
        let selectedData = permission_table.row($(this).closest("tr")).data();

        $("#modal_site_manager").modal("show");
        $("#modal_site_manager #site_name").val(selectedData.site_name);

        getUsers(selectedData.site_id);
    });

    $("#modal_site_manager").on("hide.bs.modal", function() {
        $("#modal_site_manager #site_name").val("");
        $(".form-permission")
            .find(".modal-body")
            .find(".site-manager-info")
            .html("");
    });

    $(".form-permission").on("submit", function(e) {
        e.preventDefault();

        $.ajax({
            url: "/changeSiteManager",
            type: "post",
            data: {
                user_id: $("#select_site_manager").val(),
                _token: _token
            },
            dataType: "text",
            success: function(data) {
                if (data == "success") {
                    initializeTable($("#select_city").val());
                    $("#modal_site_manager").modal("hide");
                }
            }
        });
    });

    $("#select_city").on("change", function() {
        $(".selected-city-name").val($("#select_city option:selected").text());

        getCityManager($(this).val());
        initializeTable($(this).val());
    });

    $("#select_site_manager").on("change", function() {
        $(".form-permission")
            .find(".modal-body")
            .find(".site-manager-info")
            .html(generateHtml($(this).val()));
    });

    $("#select_city_manager").on("change", function() {
        $(".form-city-manager")
            .find(".modal-body")
            .find(".city-manager-info")
            .html(generateHtml($(this).val()));
    });
});

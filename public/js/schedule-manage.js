let schedule_table = false,
    flag = false;

function initializeTable(city_id) {
    if (schedule_table) {
        schedule_table.clear().draw();
        schedule_table.destroy();
    }

    schedule_table = $("#schedule-table").DataTable({
        responsive: true,
        ajax: {
            url: "/schedules/" + city_id,
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
                data: "start_time"
            },
            {
                data: "end_time"
            },
            {
                data: "email"
            },
            {
                data: "updated"
            },
            {
                data: "approved"
            },
            {
                data: ""
            }
        ],
        columnDefs: [
            {
                targets: -2,
                render: function(approved) {
                    let status = approved == 1 ? "checked" : "";
                    return (
                        `<input type="checkbox" class="approve-switch" data-color="#009efb" data-secondary-color="#f62d51" ` +
                        status +
                        `/>`
                    );
                }
            },
            {
                targets: -1,
                orderable: false,
                render: function(data) {
                    return `
                	<a href='javascript:;' class='edit-schedule'><i class='mdi mdi-lead-pencil'></i></a>&nbsp;&nbsp;&nbsp;
                	<a href='javascript:;' class='delete-schedule'><i class='mdi mdi-delete'></i></a>
                `;
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
                let message = "Yes, Block this schedule!";
                let btnColor = "rgb(221, 107, 85)";
                if (switchBtn.is(":checked")) {
                    message = "Yes, Aprrove this schedule!";
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
                            url: "/approveTimer",
                            type: "POST",
                            data: {
                                id: schedule_table
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

function initSite(city_id) {
  $.ajax({
      url: "/getSites/" + city_id,
      type: "get",
      dataType: "json",
      async: false,
      success: function(response) {
          $("#select_site").empty();
          $("#select_site").append(
              $("<option>", {
                  value: "",
                  text: "Choose Site"
              })
          );
          $.each(response.data, function(i, data) {
              $("#select_site").append(
                  $("<option>", {
                      value: data.id,
                      text: data.name
                  })
              );
          });
      }
  });
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

$(document).ready(function() {
    initializeTable($("#select-city").val());
    initSite($("#select-city").val());
    $("#selected_city_name").val($("#select-city option:selected").text());

    $("#schedule-table tbody").on("click", ".edit-schedule", function() {
        let selectedData = schedule_table.row($(this).closest("tr")).data();

        $("#schedule-modal").modal("show");
        $("#schedule-modal #edit_schedule_id").val(selectedData.id);
        $("#schedule-modal #select_site").val(selectedData.site_id);
        $("#schedule-modal #site_name").val(selectedData.site_name);
        $("#schedule-modal #start_time").val(selectedData.start_time);
        $("#schedule-modal #end_time").val(selectedData.end_time);
        $("#city-modal .modal-title").text("Edit Schedule");
        $("#schedule-modal .btn-schedule").text("Edit");
    });

    $("#schedule-table tbody").on("click", ".delete-schedule", function() {
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
                    url: "/schedules/destroy",
                    type: "delete",
                    data: {
                        id: schedule_table.row($(this).closest("tr")).data().id,
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
                            schedule_table.ajax.reload();
                        } else if (data.status == "-1") {
                            swal(
                                "Warning!",
                                "Can't delete this schedule. First delete all info that related with this schedule.",
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

    $("#schedule-modal").on("hide.bs.modal", function() {
      $("#schedule-modal #edit_schedule_id").val("0");
      $("#schedule-modal #start_time").val("");
      $("#schedule-modal #end_time").val("");
      $("#city-modal .modal-title").text("Add Schedule");
      $("#schedule-modal .btn-schedule").text("Add");

      $("#schedule-modal")
          .find(".alert")
          .remove();
    });

    $(".form-schedule").on("submit", function(e) {
      e.preventDefault();

      let id = $("#edit_schedule_id").val();
        url = "/schedules",
        method = "post";
      if (id > 0) {
        url = "/schedules/" + id;
        method = "put";
      }

      $.ajax({
        url: url,
        type: method,
        data: {
          site_id: $("#select_site").val(),
          start_time: $("#schedule-modal #start_time").val(),
          end_time: $("#schedule-modal #end_time").val(),
          _token: _token
        },
        dataType: "json",
        success: function(data) {
          console.log(data, data.status);
          if (data.status == 1) {
            initializeTable($("#select-city").val());
            $("#schedule-modal").modal("hide");
          }
        }
      });
    });

    $("#select-city").on("change", function() {
        $("#selected_city_name").val($("#select-city option:selected").text());

        initializeTable($(this).val());
        initSite($(this).val());
    });
});

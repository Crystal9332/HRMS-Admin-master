let qr_table = false;
function initializeTable(start, end) {
  if (qr_table) {
    qr_table.clear().draw();
    qr_table.destroy();
  }

  qr_table = $("#attend-table").DataTable({
    responsive: true,
    ajax: {
        url: "/reports/getOrders",
        type: "post",
        data: {
          start: start,
          end: end,
          _token: _token
        }
    },
    columns: [
      {
        data: "no"
      },
      {
        data: "city"
      },
      {
        data: "site"
      },
      {
        data: "start"
      },
      {
        data: "end"
      },
      {
        data: "attend"
      },
      {
        data: "late"
      },
      {
        data: "timeout"
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
          let url = "/reports/orders/" + id;
          return (
            `
            <a href="` + url + `"><i class="mdi mdi-eye"></i></a>&nbsp;&nbsp;
            `
          );
        }
      }
    ],
    order: [[0, "asc"]]
  });
}

$(document).ready(function() {  
  $("#daterange").daterangepicker({
    startDate: new Date(),
    endDate: new Date(),
    maxDate: new Date(),
    buttonClasses: ['btn', 'btn-sm'],
    applyClass: 'btn-danger',
    cancelClass: 'btn-inverse',
    locale: {
      format: 'MM/DD/YYYY'
    }
  });

  let curTime = new Date().toLocaleString("en-US", {timeZone: "Asia/Riyadh"});
  initializeTable(
    curTime,
    curTime
  );

  $('#daterange').on('apply.daterangepicker', function(ev, picker) {
    initializeTable(
      picker.startDate.format('YYYY-MM-DD'),
      picker.endDate.format('YYYY-MM-DD')
      );
  });
  
});

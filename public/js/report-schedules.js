let qr_table = false;
function initializeTable(start, end) {
  if (qr_table) {
    qr_table.clear().draw();
    qr_table.destroy();
  }

  qr_table = $("#attend-table").DataTable({
    responsive: true,
    ajax: {
        url: "/reports/getSchedules",
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
          let url = "/reports/periodSchedules/" + id + "/start/" + start + "/end/" + end;
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

function dateToYMD(date) {
  var d = date.getDate();
  var m = date.getMonth() + 1; //Month from 0 to 11
  var y = date.getFullYear();
  return '' + y + '-' + (m<=9 ? '0' + m : m) + '-' + (d <= 9 ? '0' + d : d);
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

  let curTime = new Date().toLocaleString("fr-CA", {timeZone: "Asia/Riyadh"}).slice(0, 10);
  console.log(curTime);
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

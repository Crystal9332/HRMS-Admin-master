let report_table = false, start, end;
function initializeTable() {
  if (report_table) {
    report_table.clear().draw();
    report_table.destroy();
  }

  report_table = $("#report-table").DataTable({
    dom: 'lBfrtip',
    responsive: true,
    ajax: {
        url: "/reports/getUserReport",
        type: "post",
        data: {
          id: $("#user_id").val(),
          type: $("#select_type").val(),
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
        data: "name"
      },
      {
        data: "start"
      },
      {
        data: "end"
      },
      {
        data: "in"
      },
      {
        data: "out"
      },
      {
        data: "result"
      },
    ],
    columnDefs: [
    ],
    order: [[0, "asc"]],
    buttons: [
      'copy',
      {
        extend: 'excel',
        title: title,
        filename: filename
      },
      {
        extend: 'pdfHtml5',
        orientation: 'landscape',
        pageSize: 'LEGAL',
        title: title,
        filename: filename,
        customize: function(doc) {
          doc.styles.title = {
            color: 'black',
            fontSize: '14',
            alignment: 'left'
          }
        } 
      }
    ]
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
  start = end = curTime;
  initializeTable();

  $('#daterange').on('apply.daterangepicker', function(ev, picker) {
    start = picker.startDate.format('YYYY-MM-DD');
    end = picker.endDate.format('YYYY-MM-DD');
    initializeTable();
  });

  $("#select_type").on("change", function() {
    initializeTable();
  });
  
});

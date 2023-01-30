@extends('layouts.common.index')

@section('page-title')
Reporter Mangement <i class="breadcrumb-symbol"></i> View Details
@endsection

@section('styles')
  <style>
    .dt-buttons {
      margin-left: 20px
    }
    .dt-buttons .dt-button {
      border: none;
      cursor: pointer;
    }
    .dt-buttons .dt-button:hover {
      background: #ff7b54;
    }
    .dt-buttons .dt-button:focus {
      outline: none;
    }
  </style>
@endsection

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-md-1"></div>
          <div class="col-md-7 row">
            <div class="col-md-2">
              City: <span class="font-weight-bold">{{$city}}</span>
            </div>
            <div class="col-md-2">
              Site: <span class="font-weight-bold">{{$site}}</span>
            </div>
            <div class="col-md-4">
              Start Time: <span class="font-weight-bold">{{$start}}</span>
            </div>
            <div class="col-md-4">
              End Time: <span class="font-weight-bold">{{$end}}</span>
            </div>
          </div>
          <div class="col-md-4 d-flex justify-content-end">
            <a
              class="col-md-4 offset-md-4 btn btn-rounded btn-block btn-outline-secondary"
              href="{{route('schedules')}}"
            >
              View All
            </a>
          </div>
        </div>
        <div class="table-responsive mt-3">
          <table id="view-table" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th width="3%">No</th>
                <th>Date</th>
                <th>Attend</th>
                <th>Late</th>
                <th>Timeout</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($schedules as $schedule)
                <tr>
                  <td>{{$schedule['no']}}</td>
                  <td>{{$schedule['date']}}</td>
                  <td>{{$schedule['attend']}}</td>
                  <td>{{$schedule['late']}}</td>
                  <td>{{$schedule['timeout']}}</td>
                  <td>
                      <a href="/reports/schedules/{{$schedule['id']}}/date/{{$schedule['date']}}"><i class="mdi mdi-eye"></i></a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
  <!-- start - This is for export functionality only -->
  <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
  <!-- end - This is for export functionality only -->
  <script>
    let title = 'City:'+'{{$city}}'+'    Site:'+'{{$site}}'+'    Start Time:'+'{{$start}}'+'    End Time:'+'{{$end}}';
    let filename = '{{$city}}'+'-'+'{{$site}}'+'_'+'{{$start}}'+'_'+'{{$end}}';
    $('#view-table').DataTable({
      dom: 'lBfrtip',
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
  </script>
@endsection
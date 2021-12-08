@extends('admin.layouts.master')


@section('styles')

<style>
#customers {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}
.buttons-pdf {
  margin-right: 10px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #313d78;
  color: white;
}

.form-control {
  display: inline !important;
  width: 15% !important;
}
</style>
<link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}"/>
<link href="{{ asset('css/jquery.datepick.css') }}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Received SMS List</div>

                <div class="card-header">

                <form method="POST" action="{{ route('search.received.sms-lists') }}">
               {{ csrf_field() }}

                From Date : <input type="text" name="from_date" value="{{ @$fromdate }}" id="popupDatepickerFrom" readonly="" class="form-control">

                To Date : <input type="text" name="to_date" value="{{ @$to_date }}" id="popupDatepickerTo" readonly="" class="form-control">

                Status :  <select name="status" id="status" class="form-control">
                            @if(@$status == 'ALL')
                              <option value="ALL" selected="">ALL</option>
                            @else
                              <option value="ALL">ALL</option>
                            @endif
                            
                            @if(@$status == 'VALID')
                              <option value="VALID" selected="">VALID</option>
                            @else
                              <option value="VALID">VALID</option>
                            @endif

                            @if(@$status == 'INVALID')
                              <option value="INVALID" selected="">INVALID</option>
                            @else
                              <option value="INVALID">INVALID</option>
                            @endif

                            @if(@$status == 'REPEAT')
                              <option value="REPEAT" selected="">REPEAT</option>
                            @else
                              <option value="REPEAT">REPEAT</option>
                            @endif
                          </select>

                <button type="submit" class="btn btn-danger form-control">Search</button>

                </form>

                </div>
                <br>

                <div class="card-body">
                    <table id="customers">
                        <thead>
                            <th>Sl. No</th>
                            <th>Mobile Number</th>
                            <th>Campaign Code</th>
                            <th>SMS Message</th>
                            <th>Received Time</th>
                            <th>Location</th>
                            <th>Status</th>
                        </thead>
                        <tbody>
                            @foreach($received_sms_list as $key=>$list)
                                <tr>
                                    <td>{{  ++$key }}</td>
                                    <td>{{  $list->sent_mobile }}</td>
                                    <td>{{  $list->campaign_code }}</td>
                                    <td>{{  $list->sms_content }}</td>
                                    <td>{{  $list->received_time->format('d/m/Y h:i:s A') }}</td>
                                    <td>{{  $list->location }}</td>
                                    <td>{{  $list->status }}</td>
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
<script src="{{ asset('js/datatables.min.js') }}" defer></script>
<script src="{{ asset('js/jquery.plugin.js') }}" defer></script>
<script src="{{ asset('js/jquery.datepick.js') }}" defer></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" defer></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js" defer></script>





<script type="text/javascript">
  $(document).ready( function () {
  $('#customers').DataTable({
  paging: true,
   aLengthMenu: [ 
   [25, 50, 100, 200, -1], 
   [25, 50, 100, 200, "All"] 
   ], 
   iDisplayLength: -1,
  columnDefs: [{
    targets: 'no-sort',
    orderable: false
  }],
  dom: '<"row"<"col-sm-6"Bl><"col-sm-6"f>>' +
    '<"row"<"col-sm-12"<"table-responsive"tr>>>' +
    '<"row"<"col-sm-5"i><"col-sm-7"p>>',
  fixedHeader: {
    header: true
  },
  buttons: {
    buttons: [{
      extend: 'excel',
      text: '<i class="fa fa-file-excel-o"></i> Export to Excel',
      title: $('h1').text(),
      exportOptions: {
        modifier: {
          page: 'current'
        }
      },
      dom: 'Bfrtip',
    }, {
      extend: 'pdf',
      text: '<i class="fa fa-file-pdf-o"></i> PDF',
      title: $('h1').text(),
      exportOptions: {
        modifier: {
          page: 'applied'
        }
      },
      footer: true
    }],
    
    dom: {
      
      container: {
        className: 'dt-buttons'
      },
      button: {
        className: 'btn btn-primary'
      }
    }
  }
});

    $('#popupDatepickerFrom, #popupDatepickerTo').datepick({dateFormat: 'dd-mm-yyyy'});
  });
</script>
@endsection

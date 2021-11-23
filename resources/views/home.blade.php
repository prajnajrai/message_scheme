@extends('layouts.app')
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

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #4CAF50;
  color: white;
}

.form-control {
  display: inline !important;
  width: 15% !important;
}
</style>
<link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}"/>
<link href="{{ asset('css/jquery.datepick.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Received SMS List</div>

                <div class="card-header">

                <form method="POST" action="{{ route('search.received.sms-list') }}">

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

                <div class="card-body">
                    <table id="customers">
                        <thead>
                            <th>Sl. No</th>
                            <th>Mobile Number</th>
                            {{--<th>Campaign Code</th>--}}
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
                                    {{--<td>{{  $list->campaign_code }}</td>--}}
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
<script type="text/javascript">
  $(document).ready( function () {
    $('#customers').DataTable();
    $('#popupDatepickerFrom, #popupDatepickerTo').datepick({dateFormat: 'dd-mm-yyyy'});
  });
</script>
@endsection
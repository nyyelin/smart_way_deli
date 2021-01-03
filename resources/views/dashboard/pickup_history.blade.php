@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> {{ __("Pickup History")}}</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="#">{{ __("Pickup History")}}</a></li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          @php $mytime = Carbon\Carbon::now(); @endphp
          

         
      <div class="row">
              <div class="form-group col-md-3">
              <label for="InputStartDate">{{ __("Start Date")}}:</label>
              <input type="hidden" name="" value="{{$rolename}}" class="role_name">

              <input type="date" class="form-control" id="InputStartDate" name="start_date">
            </div>
            <div class="form-group col-md-3">
              <label for="InputEndDate">{{ __("End Date")}}:</label>
              <input type="date" class="form-control" id="InputEndDate" name="end_date">
            </div>
            @role('staff')
            <div class="form-group col-md-3">
              <label for="InputClient">{{ __("Select Client")}}:</label>
                <select class="js-example-basic-single" id="InputClient" name="client">
                  <option value="">Choose Client</option>
                    @foreach($clients as $client)
                      <option value="{{$client->id}}" data-name="{{$client->clientname}}">{{$client->clientname}}</option>
                    @endforeach
                </select>
            </div>
            @endrole
            <div class="form-group col-md-3">
              <button class="btn btn-primary search_btn mt-4" type="button">{{ __("Search")}}</button>
            </div>
        </div>
          
          
          <div class="table-responsive">
            <table class="table" id="picktable">
              <thead>
                <tr>
                  <th>{{ __("#")}}</th>
                  <th>{{ __("Pickup Date")}}</th>
                 
                  <th>{{ __("Client Name")}}</th>
                  
                  <th>{{ __("Quantity")}}</th>
                  <th>{{ __("Amount")}}</th>
                  <th>{{ __("Actions")}}</th>
                </tr>
              </thead>
              <tbody>
              @role('client')
                @php $i=1; @endphp
                @foreach($pickups as $row)

                <tr>
                  <td>{{$i++}}</td>
                  <td>{{$row->schedule->pickup_date}}</td>
                  <td>{{Auth::user()->client->user->name}}</td>
                  <td>{{$row->schedule->quantity}}</td>
                  <td>{{$row->schedule->amount}}</td>
                  
                  @if($row->items)
                  <td><a class="btn btn-primary btn-sm d-inline-block btnEdit " href="{{route('historydetails',$row->id)}}">Detail</a></td>
                  @endif
                  
                </tr>

                @endforeach
              @endrole
                
              </tbody>
            </table>
          </div>
           
          
        </div>
      </div>
    </div>
  </main>
@endsection 
@section('script')
<script type="text/javascript">
  $(document).ready(function(){

 $('.js-example-basic-single').select2({width:'100%'});
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    function thousands_separators(num)
    {
      var num_parts = num.toString().split(".");
      num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      return num_parts.join(".");
    }

    $('.search_btn').click(function () {
      //alert("ok");
        var role_name = $('.role_name').val();
        // alert(role_name);
        var sdate = $('#InputStartDate').val();
        var edate = $('#InputEndDate').val();
        var client_id=$("#InputClient").val();
// console.log(start_date, end_date)
        var url="{{route('pickupbyclient')}}";
        var i=1;
         $('#picktable').DataTable({
        "processing": true,
        "serverSide": true,
        destroy:true,
        "sort":false,
        "stateSave": true,
        "ajax": {
            url: url,
            type: "POST",
            data:{sdate:sdate,edate:edate,client_id:client_id},
            dataType:'json',
        },
        "columns": [
        { "data":'DT_RowIndex'},
        { "data": "schedule.pickup_date"},
        { "data" : "schedule.client.user.name",
          // render:function(data){
          //   if(role_name == 'staff'){
          //     return data;
          //   }else if(role_name == 'client'){
          //     return 'Yours';
          //   }
          // }
        },
        { "data": "schedule.quantity" },
        { "data": "schedule.amount" },
        { "data": "id",
                    sortable:false,
                    render:function(data){
                      var routeurl="{{route('historydetails',':id')}}";
                      routeurl=routeurl.replace(':id',data);
                      return `<a class="btn btn-primary btn-sm d-inline-block btnEdit " href="${routeurl}" data-id="${data}">Detail</a>`;
                    }
                   }
        ],
        "info":false
    });
        
      })
  })
</script>
@endsection

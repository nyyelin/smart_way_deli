@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> Dashboard</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          @php $mytime = Carbon\Carbon::now(); @endphp
          <h3 class="tile-title d-inline-block">{{ __("Delay List")}} ({{$mytime->toFormattedDateString()}})</h3>

          <a href="#" class="btn btn-primary float-right wayassign" id="submit_assign">{{ __("Way Assign")}}</a>
          <div class="table-responsive">
                  <table class="table table-bordered dataTable">
                    <thead>
                      <tr>
                        <th>{{ __("#")}}</th>
                        <th>{{ __("Codeno")}}</th>
                        <th>{{ __("Township")}}</th>
                        <th>{{ __("Receiver Info")}}</th>
                        <th>{{ __("Expired Date")}}</th>
                        <th>{{ __("Amount")}}</th>
                        <th>{{ __("Actions")}}</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                         @php $i=1; @endphp
                        @foreach($delayitems as $row)
                        @if($row->township)

                        @php
                       $today=strtotime($mytime->toDateString());
                        $expdate=strtotime($row->created_at->toDateString());
                        $difference=$today-$expdate;
                        $differentday=round($difference / 86400);

                       @endphp
                        <td><div class="animated-checkbox">
                            <label class="mb-0">
                              <input type="checkbox" name="assign[]" value="{{$row->id}}" data-codeno="{{$row->codeno}}" @if($row->township) data-township="{{$row->township->id}}" @endif><span class="label-text"> </span>
                            </label>
                          </div></td>
                        <td>@if($differentday==1)<span class="badge badge-warning">{{$row->codeno}}</span> @elseif($differentday>1)<span class="badge badge-danger">{{$row->codeno}}</span>@endif</td>
                        
                        <td class="text-danger">{{$row->township->name}}</td>
                       
                        <td>
                          {{$row->receiver_name}} <span class="badge badge-dark">{{$row->receiver_phone_no}}</span>
                        </td>
                        <td>{{$row->expired_date}}</td>
                        <td>{{number_format($row->item_price)}}</td>
                        <td class="mytd">
                          <a href="#" class="btn btn-primary detail" data-id="{{$row->id}}">{{ __("Detail")}}</a>
                        </td>
                      </tr>
                      @endif
                      @endforeach
                    </tbody>
                  </table>
                </div>
        </div>
      </div>
    </div>
  </main>


  <div class="modal fade" id="itemDetailModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title rcode" id="exampleModalLabel"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p><strong>{{ __("Receiver Name")}}:</strong> <span id="rname">Ma Mon</span></p>
          <p ><strong >{{ __("Receiver Phone No")}}:</strong> <span id="rphone">09987654321</span></p>
          <p><strong >{{ __("Receiver Address")}}:</strong><span id="raddress"> No(3), Than Street, Hlaing, Yangon.</span></p>

          <p><strong>{{ __("Item name")}}:</strong> <span  id="ritemname"></span></p>
          <p><strong>{{ __("Item price")}}:</strong> <span  id="rprice"></span></p>
          <p><strong>{{ __("Delivery fee")}}:</strong> <span  id="rdfee"></span></p>

          <p><strong>{{ __("Remark")}}:</strong> <span class="text-danger" id="rremark">Don't press over!!!!</span></p>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">OK</button>
        </div>
      </div>
    </div>
  </div>


    <div class="modal fade" id="wayAssignModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{ __("Choose Delivery Man")}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="post" action="{{route('wayassign')}}">
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <label>{{ __("Way Code Numbers")}}:</label>
              <div id="selectedWays"></div>
            </div>

            {{-- <div class="form-group townships">
              <label>{{ __("Choose Township")}}:</label>
              <select class="js-example-basic-multiple form-control" name="township">
                @foreach($townships as $township)
                  <option value="{{$township->id}}">{{$township->name}}</option>
                @endforeach
              </select>
            </div> --}}
          

            <div class="form-group">
              <label>{{ __("Choose Delivery Man")}}:</label>
              <select class="js-example-basic-multiple form-control" name="delivery_man">
                @foreach($deliverymen as $man)
                  <option value="{{$man->id}}">{{$man->user->name}}</option>
                @endforeach
              </select>
            </div>
          </div>


          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("Close")}}</button>
            <button type="submit" class="btn btn-primary">{{ __("Assign")}}</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection 
@section('script')
<script type="text/javascript">
  $(document).ready(function(){
       $(".dataTable tbody").on('click','.detail',function(){
        var id=$(this).data('id');
        //console.log(id);
        $('#itemDetailModal').modal('show');
        $.ajaxSetup({
         headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        $.post('itemdetail',{id:id},function(res){
          $("#rname").html(res.receiver_name);
          $("#rphone").html(res.receiver_phone_no);
          $("#raddress").html(res.receiver_address);
          $("#rremark").html(res.remark);
          $(".rcode").html(res.codeno);
          var price = `${thousands_separators(res.item_price)}`;
          var deli_fee = `${thousands_separators(res.delivery_fees)}`;
          var total = res.item_price + res.delivery_fees;
          var total_amount = `${thousands_separators(total)}`;
          $('#rtotal').html(total_amount);
          $('#rprice').html(price);
          $('#rdfee').html(deli_fee);
          $('#ritemname').html(res.item_name)
        })
      })

        $('.wayassign').click(function () {
        var ways = [];
        $.each($("input[name='assign[]']:checked"), function(){
          let wayObj = {id:$(this).val(),codeno:$(this).data('codeno'),township:$(this).data('township')};
          ways.push(wayObj);
        });
        console.log(ways);
        var html="";
        for(let way of ways){
          // if(way.township){
          //   $('.townships').hide();
          // }else{
          //   $('.townships').show();
          // }
          html+=`<input type="hidden" value="${way.id}" name="ways[]"><span class="badge badge-primary mx-2">${way.codeno}</span>`;
        }
        $('#selectedWays').html(html);

        $('#wayAssignModal').modal('show');
      })

        $('.js-example-basic-multiple').select2({
        width: '100%',
        dropdownParent: $('#wayAssignModal')
      });


      var $submit = $("#submit_assign").hide();
      $cbs = $('input[name="assign[]"]').click(function() {
          $submit.toggle( $cbs.is(":checked") , 2000);
      });

      $(".wayedit").click(function(){
        $('#editwayAssignModal').modal('show');
        var id=$(this).data("id");
        //console.log(id);
        $("#wayid").val(id);
      })


      function thousands_separators(num)
    {
      var num_parts = num.toString().split(".");
      num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      return num_parts.join(".");
    }

  })
</script>

@endsection
@extends('main')
@section('content')
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> {{ __("Items")}}</h1>
      <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="{{route('client_items.index')}}">{{ __("Items")}}</a></li>
    </ul>
  </div>

  <div class="row">
      <div class="col-md-12">
        @if(session('successMsg') != NULL)
          <div class="alert alert-success alert-dismissible fade show myalert" role="alert">
              <strong> ✅ SUCCESS!</strong>
              {{ session('successMsg') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
        @endif
        <div class="tile">
          <h3 class="tile-title d-inline-block">{{ __("Item List")}}</h3>
          <a href="{{route('client_items.create')}}" class="btn btn-sm btn-primary float-right" id="submit_assign">{{ __("Add New")}}</a>
          <br>
          <a href="#" class="btn btn-sm btn-primary float-right order" id="submit_assign">{{ __("Order")}}</a>
          <br>


          <div class="bs-component">
            {{-- <ul class="nav nav-tabs">
              <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#collect">{{ __("In Stock")}}</a></li>
              <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#way">{{ __("On Ways")}}</a></li>
              <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#print">{{ __("Print Ways")}}</a></li>
            </ul> --}}
            <div class="tab-content mt-3" id="myTabContent">
              <div class="tab-pane fade active show" id="collect">
                <div class="table-responsive">
                  <table class="table table-bordered" id="checktable">
                    <thead>
                      <tr>
                        <th>{{ __("#")}}</th>
                        <th>{{ __("Codeno")}}</th>
                        <th>{{ __("Item")}}</th>
                        <th>{{ __("Receiver Info")}}</th>
                        <th>{{ __("Receiver Address")}}</th>
                        <th>{{ __("Expired Date")}}</th>
                        <th>{{ __("Price")}}</th>
                        <th>{{ __("Qty")}}</th>
                        <th>{{ __("Actions")}}</th>
                      </tr>
                    </thead>
                    <tbody>
                      
                      @foreach($items as $item)
                      @php
                        $a = strtotime($item->expired_date);
                        $date = date('d-m-Y',$a);
                        $price = number_format($item->item_price);
                      @endphp
                      <tr>  

                        <td class="align-middle">
                          <div class="animated-checkbox">
                            <label class="mb-0">
                              <input type="checkbox" name="assign[]" value="{{$item->id}}" data-codeno="{{$item->codeno}}" data-qty = "{{$item->item_qty}}" data-price = "{{$item->item_price}}"><span class="label-text"> </span>
                            </label>
                          </div>
                        </td>

                        <td class="align-middle">{{$item->codeno}}</td>
                        <td class="align-middle">{{$item->item_name}}</td>
                        <td class="align-middle">{{$item->receiver_name}}<br>
                          <span span class="badge badge-dark">{{$item->receiver_phone_no}}</span>
                        </td>

                        <td class="align-middle">{{$item->receiver_address}}<br>
                          <span span class="badge badge-dark">{{$item->send_type}}</span>
                        </td>

                        <td class="align-middle">{{$date}}</td>
                        <td class="align-middle">{{$price}}<br>
                          @if($item->paystatus == 2)
                          <span span class="badge badge-dark">FOC</span>
                          @endif
                        </td>
                        <td class="align-middle">{{$item->item_qty}}</td>
                        <td class="align-middle">
                          <a href="javascript:void(0)" class="btn btn-sm btn-primary detail" data-id="{{$item->id}}" data-item_name = "{{$item->item_name}}" data-price = "{{$item->item_price}}">{{ __("Detail")}}</a>

                          <a href="{{route('client_items.edit',$item->id)}}" class="btn btn-sm btn-warning">{{ __("Edit")}}</a>
                          <form action="{{ route('client_items.destroy',$item->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">{{ __("Delete")}}</button>
                          </form>
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
      </div>
    </div>

{{-- order confirm modal --}}
  <div class="modal fade" id="orderconfirm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{ __("Order Confirm")}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="post" action="{{route('client_order')}}">
          @csrf
          <div class="item_id">
            
          </div>
          <div class="modal-body">
            <div class="form-group row">
              <label class="col-md-4">{{ __("Order Date")}}:</label>
              <div class="col-md-8">
                @php
                  $date = Carbon\Carbon::today();
                  $day = date('d-m-Y  (D)',strtotime($date));
                @endphp
                <p>{{$day}}</p>

              </div>
            </div>

             <div class="form-group row">
              <label class="col-md-4">{{ __("Total Order")}}:</label>
              <div class="col-md-8">
                <p class="total_order"></p>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-md-4" id="remark">{{ __("Remark")}}:</label>
              <div class="col-md-8">
                <textarea  class="form-control" for="remark" name="remark"></textarea>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("Close")}}</button>
            <button type="submit" class="btn btn-primary">{{ __("Confirm")}}</button>
          </div>
        </form>
      </div>
    </div>
  </div>


</main>
@endsection



@section('script')
<script type="text/javascript">
  $(document).ready(function() {
    setTimeout(function(){ $('.myalert').hide(); showDiv2() },3000);
    $('#checktable').dataTable({
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bSort": true,
        "bInfo": true,
        "bAutoWidth": true,
        "bStateSave": true,
        "bprocessing":true,
        "bserverSide":true,
        "aoColumnDefs": [
            { 'bSortable': false, 'aTargets': [ -1,0] }
        ]
    });



    $('.order').click(function(){
      var order = [];
      var total_qty = 0;
      var total_price = 0;
      var html ='';
      var oTable = $('#checktable').dataTable();
      
      var datas = oTable.$('input[name ="assign[]"]:checked',{'page':'all'});
      $.each(datas,function(i,v){
        var orderdata = {id:$(v).val(),codeno:$(v).data('codeno'),qty:$(v).data('qty'),price:$(v).data('price')};
        order.push(orderdata);
      });

      $.each(order,function(key,order){
            total_qty += order.qty;
            total_price += order.price;
            html += `<input type="hidden" name="order[]" class="order" value="${order.id}">
                    <input type="hidden" name="total_qty" class="order" value="${total_qty}">
                    <input type="hidden" name="total_price" class="order" value="${total_price}"> `;
            
        });
      // console.log(html);

      $('.item_id').html(html);
      $('.total_order').text(order.length);
      $('#orderconfirm').modal('show');
      

    })


  })
</script>
@endsection
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
      <div class="col-md-10 mx-auto">
        <div class="tile">
          <h3 class="tile-title d-inline-block">Item Edit Form</h3>
          
          <form method="POST" action="{{route('client_items.update',$item->id)}}" >
            @csrf
            @method('PUT')
            <div class="row">
              <div class="col-md-6 mx-auto">

                <div class="form-group">
                  <label for="InputCodeno">{{ __("Codeno")}}:</label>
                  <input class="form-control" id="InputCodeno" type="text" value="{{$item->codeno}}" name="codeno" readonly>
                </div>

                <div class="form-group">
                  <label for="Inputitemname">{{ __("Item Name")}}:</label>
                  <input class="form-control" id="Inputitemname" type="text"  name="item_name" value="{{$item->item_name}}">
                  

                </div>


                <div class="form-group">
                  <label for="Inputitemprice">{{ __("Item Price")}}:</label>
                  <input class="form-control price" id="Inputitemprice" type="text" name="item_price" value="{{$item->item_price}}">
                 

                </div>


                <div class="form-group">
                  <label for="InputReceiverName">{{ __("Receiver Name")}}:</label>
                  <input class="form-control" id="InputReceiverName" type="text" name="receiver_name" value="{{ $item->receiver_name}}">
                  
                </div>

                <div class="form-group">
                  <label for="InputReceiverPhoneNumber">{{ __("Receiver Phone Number")}}:</label>
                  <input class="form-control" id="InputReceiverPhoneNumber" type="text" name="receiver_phoneno" value="{{ $item->receiver_phone_no}}" >
                 
                </div>

                <div class="form-group">
                  <label for="InputReceiverAddress">{{ __("Receiver Address")}}:</label>
                  <textarea class="form-control" id="InputReceiverAddress" name="receiver_address">{{ $item->receiver_address }}</textarea>
                   
                </div>

                <div class="row my-3">
                  <div class="col-4">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="sendtype" id="incity" value="City" @if($item->send_type == "City") checked="checked" @endif>
                      <label class="form-check-label" for="incity">
                        {{ __("In city")}}
                      </label>
                    </div>
                  </div>

                  <div class="col-4">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="sendtype" id="gate" value="Gate" @if($item->send_type == "Gate") checked="checked" @endif>
                      <label class="form-check-label" for="gate">
                        {{ __("Gate")}}
                      </label>
                    </div>
                  </div>

                  <div class="col-4">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="sendtype" id="post" value="Post Office" @if($item->send_type == "Post Office") checked="checked" @endif>
                      <label class="form-check-label" for="post">
                        {{ __("Post Office")}}
                      </label>
                    </div>
                  </div>
                  <div class="form-control-feedback text-danger"> {{$errors->first('sendtype') }} </div>
                </div>
                

               <div class="form-group">
                  <label for="InputAmount">{{ __("Qty")}}</label>
                  <input class="form-control qty" id="InputAmount" type="number" name="qty" value="{{$item->item_qty}}">
                  
                </div>
                
                

                <div class="form-group">
                  <label for="InputAmount">{{ __("Amount")}}: ({{ __("price + qty")}})</label>
                  @php
                    $amount = $item->item_price * $item->item_qty;
                  @endphp
                  <input class="form-control amount" id="InputAmount" type="number" value="{{$amount}}">
                  
                </div>

               
                 
                <div class="form-group">
                  <label for="InputRemark">{{ __("Remark")}}:</label>
                  <textarea class="form-control" id="InputRemark" name="remark">
                    {{$item->remark}}
                  </textarea>
                </div>

                <div class="form-group">
                 <input type="checkbox" id="foc" name="paystatus" value="2" @if($item->paystatus == 2) checked="checked" @endif>
                 <label class="form-check-label" for="foc">If this is foc</label>
                </div>

                <div class="form-group">
                  <button class="btn btn-primary" type="submit" id="checkbtn" >{{ __("Update")}}</button>
                 
                </div>

               
              </div>

              
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
      $('.amount').click(function(){
        var qty = $('.qty').val();
        var price = $('.price').val();
        var amount = qty*price;
        $('.amount').val(amount);
      })
  })
</script>
@endsection







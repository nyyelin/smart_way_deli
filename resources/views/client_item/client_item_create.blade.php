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
        <li class="breadcrumb-item"><a href="{{route('items.index')}}">{{ __("Items")}}</a></li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-10 mx-auto">
        <div class="tile">
          <h3 class="tile-title d-inline-block">Item Create Form</h3>
          @if(session('successMsg') != NULL)
            <div class="alert alert-success alert-dismissible fade show myalert" role="alert">
                <strong> ✅ SUCCESS!</strong>
                {{ session('successMsg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
          @endif
          <form method="POST" action="{{route('client_items.store')}}" >
            @csrf
            <div class="row">
              <div class="col-md-6 mx-auto">

                <div class="form-group">
                  <label for="InputCodeno">{{ __("Codeno")}}:</label>
                  <input class="form-control" id="InputCodeno" type="text" value="{{$item_code_no}}" name="codeno" readonly>
                </div>

                <div class="form-group">
                  <label for="Inputitemname">{{ __("Item Name")}}:</label>
                  <input class="form-control" id="Inputitemname" type="text"  name="item_name" value="{{ old('item_name') }}">
                  <div class="form-control-feedback text-danger"> {{$errors->first('item_name') }} </div>

                </div>


                <div class="form-group">
                  <label for="Inputitemprice">{{ __("Item Price")}}:</label>
                  <input class="form-control price" id="Inputitemprice" type="text" name="item_price" value="{{old('item_price')}}">
                  <div class="form-control-feedback text-danger"> {{$errors->first('item_price') }} </div>

                </div>


                <div class="form-group">
                  <label for="InputReceiverName">{{ __("Receiver Name")}}:</label>
                  <input class="form-control" id="InputReceiverName" type="text" name="receiver_name" value="{{ old('receiver_name') }}">
                  <div class="form-control-feedback text-danger"> {{$errors->first('receiver_name') }} </div>
                </div>

                <div class="form-group">
                  <label for="InputReceiverPhoneNumber">{{ __("Receiver Phone Number")}}:</label>
                  <input class="form-control" id="InputReceiverPhoneNumber" type="text" name="receiver_phoneno" value="{{ old('receiver_phoneno') }}" >
                  <div class="form-control-feedback text-danger"> {{$errors->first('receiver_phoneno') }} </div>
                </div>

                <div class="form-group">
                  <label for="InputReceiverAddress">{{ __("Receiver Address")}}:</label>
                  <textarea class="form-control" id="InputReceiverAddress" name="receiver_address">{{ old('receiver_address') }}</textarea>
                   <div class="form-control-feedback text-danger"> {{$errors->first('receiver_address') }} </div>
                </div>

                <div class="row my-3">
                  <div class="col-4">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="sendtype" id="incity" value="City" checked="checked">
                      <label class="form-check-label" for="incity">
                        {{ __("In city")}}
                      </label>
                    </div>
                  </div>

                  <div class="col-4">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="sendtype" id="gate" value="Gate" >
                      <label class="form-check-label" for="gate">
                        {{ __("Gate")}}
                      </label>
                    </div>
                  </div>

                  <div class="col-4">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="sendtype" id="post" value="Post Office" >
                      <label class="form-check-label" for="post">
                        {{ __("Post Office")}}
                      </label>
                    </div>
                  </div>
                  <div class="form-control-feedback text-danger"> {{$errors->first('sendtype') }} </div>
                </div>
                

               <div class="form-group">
                  <label for="InputAmount">{{ __("Qty")}}</label>
                  <input class="form-control qty" id="InputAmount" type="number" name="qty" value="1">
                  <div class="form-control-feedback text-danger"> {{$errors->first('qty') }} </div>
                </div>
                
                

                <div class="form-group">
                  <label for="InputAmount">{{ __("Amount")}}: ({{ __("price + qty")}})</label>
                  <input class="form-control amount" id="InputAmount" type="number">
                  
                </div>

               
                 
                <div class="form-group">
                  <label for="InputRemark">{{ __("Remark")}}:</label>
                  <textarea class="form-control" id="InputRemark" name="remark"></textarea>
                  <div class="form-control-feedback text-danger"> {{$errors->first('remark') }} </div>
                </div>

                <div class="form-group">
                 <input type="checkbox" id="foc" name="paystatus" value="2" >
                 <label class="form-check-label" for="foc">If this is foc</label>
                </div>

                <div class="form-group">
                  <button class="btn btn-primary" type="submit" id="checkbtn" >{{ __("Save")}}</button>
                 
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







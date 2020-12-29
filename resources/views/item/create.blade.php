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
      <div class="col-md-12">
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
          <form method="POST" action="{{route('items.store')}}" id="storeform">
            @csrf
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="InputCodeno">{{ __("Codeno")}}:</label>
                  <input class="form-control" id="InputCodeno" type="text" value="{{$itemcode}}" name="codeno" readonly>
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
                      <input class="form-check-input" type="radio" name="rcity" id="incity" value="1" checked="checked">
                      <label class="form-check-label" for="incity">
                        {{ __("In city")}}
                      </label>
                    </div>
                  </div>

                  <div class="col-4">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="rcity" id="gate" value="2" >
                      <label class="form-check-label" for="gate">
                        {{ __("Gate")}}
                      </label>
                    </div>
                  </div>

                  <div class="col-4">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="rcity" id="post" value="3" >
                      <label class="form-check-label" for="post">
                        {{ __("Post Office")}}
                      </label>
                    </div>
                  </div>
                  <div class="form-control-feedback text-danger"> {{$errors->first('rcity') }} </div>
                </div>

                <div class="form-group  mygate">
                  <label for="mygate">{{ __("Sender Gate")}}:</label><br>
                  <select class="js-example-basic-single " id="mygate" name="mygate"  >
                    <option value="">{{ __("Choose Gate")}}</option>
                    @foreach($sendergates as $row)
                      <option value="{{$row->id}}">{{$row->name}}</option>
                    @endforeach
                  </select>
                  <div class="form-control-feedback text-danger"> {{$errors->first('receiver_township') }} </div>
                </div>

                <div class="form-group  myoffice">
                  <label for="myoffice">{{ __("Sender PostOffice")}}:</label><br>
                  <select class="js-example-basic-single  " id="myoffice" name="myoffice"  >
                    <option value="">{{ __("Choose Post Office")}}</option>
                    @foreach($senderoffice as $row)
                      <option value="{{$row->id}}">{{$row->name}}</option>
                    @endforeach
                  </select>
                  <div class="form-control-feedback text-danger"> {{$errors->first('receiver_township') }} </div>
                </div>

                <div class="form-group township">
                  <label for="InputReceiverTownship">{{ __("Receiver Township")}}:</label><br>
                  <select class="js-example-basic-single  mytownship" id="InputReceiverTownship" name="receiver_township"  >
                    <option value="null">{{ __("Choose township")}}</option>
                    @foreach($townships as $row)
                      <option value="{{$row->id}}">{{$row->name}}</option>
                    @endforeach
                  </select>
                  <div class="form-control-feedback text-danger"> {{$errors->first('receiver_township') }} </div>
                </div>

                <div class="form-group">
                  <label for="txtDate">{{ __("Expired Date")}}:</label>
                  <input class="form-control pickdate" id="txtDate" type="date" name="expired_date"  value="@if($pickupeditem){{ $pickupeditem->expired_date }}@else{{old('expired_date')}}@endif">
                  <div class="form-control-feedback text-danger"> {{$errors->first('expired_date') }} </div>
                </div>

                <div class="form-group">
                  <label for="InputDeposit">{{ __("Deposit")}}:</label>
                  <input class="form-control" id="InputDeposit" type="number" name="deposit" value="@if($pickupeditem){{ $pickupeditem->item_price }}@else {{old('deposit')}} @endif">
                  <div class="form-control-feedback text-danger"> {{$errors->first('deposit') }} </div>
                </div>

                <div class="form-group">
                  <label for="InputDeliveryFees">{{ __("Delivery Fees")}}:</label>
                  <input class="form-control" id="InputDeliveryFees" type="number" name="delivery_fees" value="{{ old('delivery_fees') }}">
                  <div class="form-control-feedback text-danger"> {{$errors->first('delivery_fees') }} </div>
                </div>

                <div class="form-group">
                  <label for="other">{{ __("Other Charges")}}:</label>
                  <input class="form-control" id="other" type="number" name="othercharges" value="0">
                </div>

                <div class="form-group">
                  <label for="InputAmount">{{ __("Amount")}}: ({{ __("deposit+delivery fees+others")}})</label>
                  <input class="form-control" id="InputAmount" type="number" name="amount" value="{{ old('amount') }}">
                  <div class="form-control-feedback text-danger"> {{$errors->first('amount') }} </div>
                </div>

                <div class="form-group row">
                  <div class="col-6">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="amountstatus" id="amountpaid" value="1" >
                      <label class="form-check-label" for="amountpaid">
                       {{ __("Unpaid")}}
                      </label>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="amountstatus" id="amountunpaid"  value="2"  >
                      <label class="form-check-label" for="amountunpaid">
                        {{ __("All paid")}}
                      </label>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-control-feedback text-danger"> {{$errors->first('paystatus') }} </div>
                  </div>
                </div>
                 
                <div class="form-group">
                  <label for="InputRemark">{{ __("Remark")}}:</label>
                  <textarea class="form-control" id="InputRemark" name="remark">@if($pickupeditem){{$pickupeditem->remark}}@else{{old('remark')}}@endif</textarea>
                  <div class="form-control-feedback text-danger"> {{$errors->first('remark') }} </div>
                </div>
              </div>

              <div class="col-md-6">
                <input type="hidden" name="pickup_id" value="{{$pickup->id}}">

                <div class="card mt-4">
                  <div class="card-header">
                    <h5 class="card-title">Client Informations:</h5>
                  </div>
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item">{{ __("Name")}}: {{$client->user->name}}</li>
                    <li class="list-group-item">{{ __("Contact Person")}}: {{$client->contact_person}}</li>
                    <li class="list-group-item">{{ __("Phone Number")}}: {{$client->phone_no}}</li>
                    <li class="list-group-item">{{ __("Township")}}: {{$client->township->name}}</li>
                    <li class="list-group-item">{{ __("Left Item to collect")}}: {{$pickup->schedule->quantity - count($pickup->items)}}</li>

                    @php $total=0; @endphp
                    @foreach($pickup->items as $pickupitem)
                     @php $total+=$pickupitem->deposit @endphp
                    @endforeach

                    <input type="hidden" name="client_id" value="{{$client->id}}">

                    <input type="hidden" name="depositamount" value="{{$pickup->schedule->amount}}" class="depositamount">

                    <input type="hidden" name="depositamountforcheck" value="{{$pickup->schedule->amount-$total}}" class="depositamountforcheck">

                    <input type="hidden" class="lastqty" name="qty" value={{$pickup->schedule->quantity - count($pickup->items)}}>
                    <input type="hidden" class="totalqty" name="myqty" value="{{$pickup->schedule->quantity}}">
                    <li class="list-group-item">{{ __("Balance")}}: {{number_format($pickup->schedule->amount-$total)}} KS</li>
                  </ul>
                  @if($pickup->schedule->file)
                    <img src="{{asset($pickup->schedule->file)}}" class="img-fluid">
                  @endif
                </div>
              </div>
            </div>

            @if($pickup->schedule->quantity - count($pickup->items) == 1)
              <div class="form-group">
                <button class="btn btn-primary" type="button" id="checkbtn" >{{ __("Save")}}</button>
              </div>
            @else
              <div class="form-group">
                <button class="btn btn-primary" type="submit">{{ __("Save")}}</button>
              </div>
            @endif

            <!-- Modal -->
            <div class="modal fade" id="depositModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Deposit Amount: {{number_format($pickup->schedule->amount)}} KS</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">

                    <div class="row">
                      <div class="col-6">
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="paystatus" id="paid" value="1" checked="checked">
                          <label class="form-check-label" for="paid">
                           {{ __("Paid")}}
                          </label>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="col-6">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="paystatus" id="unpaid" value="2" >
                            <label class="form-check-label" for="unpaid">
                              {{ __("Unpaid")}}
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-control-feedback text-danger">
                          {{$errors->first('paystatus') }} 
                        </div>
                      </div>
                      <div class="col-md-12 mt-3">
                        <div class="form-group myknow">
                          <input type="checkbox" id="know">
                          <label for="know">{{ __("If you do not paid all deposit")}}</label> 
                        </div>
                      </div>
                    </div>
                    
                    <div class="row mt-3 paidamount">
                      <div class="form-row col-md-12">
                        <div class="col-md-4">
                          <label>Paid Amount:</label>
                        </div>
                        <div class="col-md-8">
                          <input type="number" name="paidamount" class="form-control" id="paidamount">
                        </div>
                        <div class="col-md-12">
                          <span class="d-none text-danger amounterrormsg">paidamount must be between 1 and depositamount!</span>
                        </div>
                      </div>
                    </div>

                    <div class="row mt-3 bank">
                      <div class="form-row col-md-12">
                        <div class="col-md-4">
                          <label>Choose Bank or Cash:</label>
                        </div>
                        <div class="col-md-8">
                          <select class="form-control payment_method" name="payment_method">
                            <option value="" data-amount="0">Choose Bank</option>
                            @foreach($banks as $bank)
                            <option value="{{$bank->id}}" data-amount="{{$bank->amount}}">{{$bank->name}} ({{$bank->amount}})</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="col-md-12">
                          <span class="d-none text-danger errormsg">Not Enough To Paid!</span>
                        </div>
                      </div>
                    </div>

                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary confirm_and_save">Confirm and Save</button>
                  </div>
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
  $(document).ready(function(){
    $('#amountpaid').attr('checked','checked');
    $(".paidamount").hide();
     $("#know").click(function(){
        if(this.checked){
          $(".paidamount").show();
        }else{
          $(".paidamount").hide();

        }
      })

    $('input[name="paystatus"]').click(function(){
      var inputValue = $(this).val();
      if(inputValue == 1){
        $('.bank').show();
        $('.myknow').show();
      }else{
        $('.bank').hide();
        $('.myknow').hide();
        $('.confirm_and_save').prop('disabled',false);
      }
    });

    $('.confirm_and_save').prop('disabled',true);
    $('#depositModal').on('change','#paidamount',function () {
      let depositamount = Number($('.depositamount').val());
      let paidamount=$(this).val();
      console.log(depositamount);
     if(paidamount>depositamount){
      $('.amounterrormsg').removeClass('d-none');
        $('.confirm_and_save').prop('disabled',true);
     }else{
       $('.errormsg').addClass('d-none');
        $('.confirm_and_save').prop('disabled',false);
     }
    })
    $('#depositModal').on('change','.payment_method',function () {
      let depositamount = Number($('.depositamount').val());
      let amount = Number($(this).find('option:selected').attr('data-amount'));
      // console.log(amount)
      if(amount==0){
        $('.errormsg').addClass('d-none');
        $('.confirm_and_save').prop('disabled',true);
      }else if(depositamount>amount){
        // console.log('hi')
        $('.errormsg').removeClass('d-none');
        $('.confirm_and_save').prop('disabled',true);
      }else{
        $('.errormsg').addClass('d-none');
        $('.confirm_and_save').prop('disabled',false);
      }
    })

    $(".mygate").hide();
    $(".myoffice").hide();
    setTimeout(function(){ $('.myalert').hide(); showDiv2() },3000);
    // $(".township").hide();
    // for in city
    var today = new Date();
    var numberofdays = 3;
    today.setDate(today.getDate() + numberofdays); 
    var day = ("0" + today.getDate()).slice(-2);
    var month = ("0" + (today.getMonth() + 1)).slice(-2);
    //console.log(month);
    var incityday= today.getFullYear()+"-"+(month)+"-"+(day) ;
    console.log(incityday);
    $(".pickdate").val(incityday);


    $(".mytownship").change(function(){
      var id=$(this).val();
      //console.log(id);
      $.ajaxSetup({
         headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
      $.post("/delichargebytown",{id:id},function(res){
        $("#InputDeliveryFees").val(res);
      })
    })

    $("#InputAmount").focus(function(){
      var deposit=parseInt($('#InputDeposit').val());
      var depositamount=$(".depositamountforcheck").val();
      var other=Number($("#other").val());
      console.log(deposit);
      //alert(other);
      var delivery_fees=parseInt($("#InputDeliveryFees").val());
      if(deposit>depositamount){
        alert("deposit amount is greate than total deposit amount!!please retype deposit fee again");
        $("#InputDeposit").val(0);
        $("#InputDeposit").focus();
      }else{
        var amount=deposit+delivery_fees+other;
      $(this).val(amount);
      }
     
    })

    $("#other").change(function(){
      //alert("ok");
      var deposit=parseInt($('#InputDeposit').val());
      var depositamount=$(".depositamountforcheck").val();
      var other=Number($("#other").val());
      var delivery_fees=parseInt($("#InputDeliveryFees").val());
     // alert(deposit+delivery_fees+other);
      $("#InputAmount").val(deposit+delivery_fees+other);
    })

    $("#InputDeposit").change(function(){
      var deposit=parseInt($('#InputDeposit').val());
      var depositamount=$(".depositamountforcheck").val();
      var delivery_fees=parseInt($("#InputDeliveryFees").val());
      
      if(deposit>depositamount){
        alert("deposit amount is greate than total deposit amount!!please retype deposit fee again");
        $("#InputDeposit").val(0);
        $("#InputDeposit").focus();
      }else{
        var amount=deposit+delivery_fees;
      $("#InputAmount").val(amount);
      }
      
     
    })


    $("#InputRemark").focus(function(){
      var deposit=parseInt($('#InputDeposit').val());
      var depositamount=$(".depositamountforcheck").val();
      var delivery_fees=parseInt($("#InputDeliveryFees").val());
      
      if(deposit>depositamount){
        alert("deposit amount is greate than total deposit amount!!please retype deposit fee again");
        $("#InputDeposit").val(0);
        $("#InputDeposit").focus();
      }else{
        var amount=deposit+delivery_fees;
      $("#InputAmount").val(amount);
      }
      
     
    })
    
    $(function(){
        var dtToday = new Date();
        
        var month = dtToday.getMonth() + 1;
        var day = dtToday.getDate();
        var year = dtToday.getFullYear();
        if(month < 10)
            month = '0' + month.toString();
        if(day < 10)
            day = '0' + day.toString();
        
        var maxDate = year + '-' + month + '-' + day;
        //alert(maxDate);
        $('#txtDate').attr('min', maxDate);
    });

    $("input[name=rcity]").click(function(){
    if ($(this).is(':checked'))
    {
      $(".township").show();
      var id=$(this).val();

      if(id==1){
        //alert("ok");
        var today = new Date();
        var numberofdays = 3;
        today.setDate(today.getDate() + numberofdays); 
        var day = ("0" + today.getDate()).slice(-2);
        var month = ("0" + (today.getMonth() + 1)).slice(-2);
        //console.log(month);
        var incityday= today.getFullYear()+"-"+(month)+"-"+(day) ;
        //console.log(incityday);
        $(".pickdate").val(incityday);
        $('#InputDeposit').prop('disabled',false);
        $("#InputDeposit").val();
        $('#InputDeposit').prop('readonly',false);
        $('#amountunpaid').removeAttr('checked');
        $('#amountpaid').attr('checked','checked');
        
      }else{
        //alert("ok");
        var today = new Date();
        var numberofdays = 7;
        today.setDate(today.getDate() + numberofdays); 
        var day = ("0" + today.getDate()).slice(-2);
        var month = ("0" + (today.getMonth() + 1)).slice(-2);
        //console.log(month);
        var gateday= today.getFullYear()+"-"+(month)+"-"+(day) ;
        console.log(gateday);
        $(".pickdate").val(gateday);
        $("#InputDeposit").val(0);
        $('#InputDeposit').prop('readonly',true);
        $('#amountpaid').removeAttr('checked');
        $('#amountunpaid').attr('checked','checked');
      }

      $.ajaxSetup({
         headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
      $.post("/townshipbystatus",{id:id},function(res){
       // console.log(id);
        var html="";
        html+=`<option>Choose township</option>`
        $.each(res,function(i,v){
          html+=`<option value="${v.id}">${v.name}</option>`
        })
        $("#InputReceiverTownship").html(html);
      })
    }
  });

  $("#gate").click(function(){
    
      $(".mygate").show();
     $(".myoffice").hide();
  })

  $("#incity").click(function(){
    $(".mygate").hide();
    $(".myoffice").hide();
  })

  $("#post").click(function(){
    
      $(".mygate").hide();
     $(".myoffice").show();
  })


    $('.js-example-basic-single').select2({width:'100%'});

    $("#checkbtn").click(function(e){
      //alert("ok");
      e.preventDefault();
     var damount=Number($(".depositamount").val());
     var lastdepostit=Number($("#InputDeposit").val());
     var lastqty=Number($(".lastqty").val());
     var totalqty=Number($(".totalqty").val());
     var myqty=totalqty-lastqty;
     //alert(myqty);
     var url="{{route('lastitem')}}";

     $.get(url,{myqty:myqty},function(res){
      //console.log(res);

      var lastamount=Number(res);
      var totalamount=lastamount+lastdepostit;
      //alert(totalamount);
      if(damount==totalamount){
        //alert("hi")
        $("#depositModal").modal('show');
      }else{
       $("#storeform").submit();
       //alert("ok")
      }

     })

    })

  })
</script>
@endsection
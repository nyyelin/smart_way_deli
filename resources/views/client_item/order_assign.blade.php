@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> {{ __("Schedules")}}</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="{{route('schedules.index')}}">{{ __("Schedules")}}</a></li>
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
          <form action="{{route('order_assign_store',$schedule->id)}}" method="post">
          @csrf 
          <h3 class="tile-title d-inline-block">{{ __("Order Assign of ")}} ( {{$schedule->client->user->name}} )</h3>
          
          <button class="btn btn-sm btn-primary float-right assign_btn" type="submit">{{ __("Assign")}}</button>

          
            <div class="row">
              <div class="col-md-12">
                
              
                 <div class="accordion" id="accordionExample">
                  @foreach($schedule->items as $key=> $item)
                    <div class="card">
                      <div class="card-header" id="headingOne">
                        <h2 class="mb-0">
                          <button class="btn btn-link btn-block text-left {{ $key != 0 ? 'collapsed' : '' }}" type="button" data-toggle="collapse" data-target="#collapse{{$key}}" aria-expanded="true" aria-controls="collapse{{$key}}">
                            {{$item->codeno}} 
                              @if($item->paystatus == 2)
                                <span span class="badge badge-dark">FOC</span>
                              @endif
                          </button>
                        </h2>
                      </div>

                      <div id="collapse{{$key}}" class="collapse @if($key==0) show @endif" aria-labelledby="headingOne" data-parent="#accordionExample">
                        <div class="card-body">
                         <div class="row mx-auto">
                           <div class="col-md-6 ">
                            <input type="hidden" name="item_id[]" value="{{$item->id}}">
                            <input type="hidden" name="delivery_fee[]" class="delivery_fee_hidden{{$key}}">
                            <input type="hidden" class="total" >
                              <div class="row">
                                <div class="col-md-4">
                                  Reciver Name
                                </div>

                                <div class="col-md-8">
                                  {{$item->receiver_name}}
                                </div>

                              </div>

                              <div class="row">
                                <div class="col-md-4">
                                  Reciver Phone
                                </div>

                                <div class="col-md-8">
                                  {{$item->receiver_phone_no}}
                                </div>

                              </div>


                              <div class="row">
                                <div class="col-md-4">
                                  Reciver Address
                                </div>

                                <div class="col-md-8">
                                  {{$item->receiver_address}}
                                </div>

                              </div>

                              <div class="row">
                                <div class="col-md-4">
                                  Item
                                </div>

                                <div class="col-md-8">
                                  {{$item->item_name}}
                                </div>

                              </div>


                              <div class="row">
                                <div class="col-md-4">
                                  Price {{-- @if($item->item_qty > 1) --}} ( *qty ) {{-- @endif --}}
                                </div>

                                <div class="col-md-8">
                                  {{$item->item_price}} {{-- @if($item->item_qty > 1) --}} ( * {{$item->item_qty}}){{--  @endif --}}
                                </div>

                              </div>

                           </div>

                           <div class="col-md-6">
                            @if($item->send_type == 'City')
                            {{-- township --}}
                             <div class="form-group row  mygate">
                                <label for="mygate">{{ __("Sender City")}}:</label><br>
                                <select class="js-example-basic-single mycity"  name="mycity[]"  data-key = "{{$key}}" data-id="{{$item->id}}" data-item="{{$schedule->items}}">
                                  <option value="">{{ __("Choose City")}}</option>
                                  @foreach($townships as $township)
                                    
                                    <option value="{{$item->id}}=>{{$township->id}}">{{ $township->name }}</option>
                                   
                                  @endforeach
                                </select>
                               
                              </div>

                             

                            @elseif($item->send_type == 'Gate')
                            {{-- gate --}}
                             <div class="form-group row  mygate">
                                <label for="mygate">{{ __("Sender Gate")}}:</label><br>
                                <select class="js-example-basic-single"  name="mygate[]"  data-key = "{{$key}}" data-id="{{$item->id}}">
                                  <option value="">{{ __("Choose Gate")}}</option>
                                  @foreach($sendergates as $gate)
                                   
                                    <option value="{{$item->id}}=>{{$gate->id}}">{{ $gate->name }}</option>
                                   
                                  @endforeach
                                </select>
                               
                              </div>
                              {{-- township --}}
                              <div class="form-group row  mygate">
                                <label for="mygate">{{ __("Sender Township")}}:</label><br>
                                <select class="js-example-basic-single mycity"  name="mycity[]"  data-key = "{{$key}}" data-id="{{$item->id}}">
                                  <option value="">{{ __("Choose City")}}</option>
                                  @foreach($gates as $g)
                                   
                                    <option value="{{$item->id}}=>{{$g->id}}">{{ $g->name }}</option>
                                   
                                  @endforeach
                                </select>
                               
                              </div>
                            @elseif($item->send_type == 'Post Office')
                            {{-- office --}}
                             <div class="form-group row  mygate">
                                <label for="mygate">{{ __("Sender Post Office")}}:</label><br>
                                <select class="js-example-basic-single"  name="mypostoffice[]"  data-key = "{{$key}}" data-id="{{$item->id}}">
                                  <option value="">{{ __("Choose Post Office")}}</option>
                                  @foreach($senderpostoffices as $post)
                                    
                                    <option value="{{$item->id}}=>{{$post->id}}">{{ $post->name }}</option>
                                   
                                  @endforeach
                                </select>
                               
                              </div>

                              {{-- township --}}

                              <div class="form-group row  mygate">
                                <label for="mygate">{{ __("Sender Township")}}:</label><br>
                                <select class="js-example-basic-single mycit"  name="mycity[]"  data-key = "{{$key}}" data-id="{{$item->id}}">
                                  <option value="">{{ __("Choose City")}}</option>
                                  @foreach($gates as $g)
                                   
                                    <option value="{{$item->id}}=>{{$g->id}}">{{ $g->name }}</option>
                                   
                                  @endforeach
                                </select>
                               
                              </div>
                            @endif

                             <div class="form-group row  mygate">
                                <label for="delivery_man">{{ __("Delivery Man")}}:</label><br>
                                <select class="js-example-basic-single deliveryman{{$key}}"  name="delivery_man[]">
                                  <option value="">{{ __("Choose Delivery Man")}}</option>
                                  @foreach($deliverymen as $deliveryman)

                                    <option value="{{$item->id}}=>{{$deliveryman->id}}">{{ $deliveryman->user->name }}</option>

                                  @endforeach
                                </select>
                               
                            </div>

                            <div class="form-group row  mygate">

                                <div class="col-md-6 ml-0 pl-0">
                                  <label for="deliveryfee">{{ __("Delivery Fee")}}:</label><br>
                                  <input type="number" class="form-control delivery_fee{{$key}}">
                                </div>

                                <div class="col-md-6">
                                  <input type="hidden" name="other_charges[]" class="orther_charge_data{{$key}}">
                                  <label for="othercharges">{{ __("Other Charges")}}:</label><br>
                                  <input type="text" class="form-control other_charge" data-key="{{$key}}" data-item_id = "{{$item->id}}" >
                                </div>
                               
                               
                              </div>


                              
                           </div>
                         </div>
                        </div>
                      </div>
                    </div>
                  @endforeach
                    
                  </div>
                </div>
              </div>
            </div>

          </form>
           
          </div>
        
      </div>
   
  </main>


@endsection 
@section('script')
  <script type="text/javascript">
    $(document).ready(function () {
        $('.assign_btn').hide();
        
       $.ajaxSetup({
           headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        $('.js-example-basic-single').select2({width:'100%'});

        $('.mycity').change(function(){
          var city_id = $(this).val();
          var id = city_id.split('=>');
          var key = $(this).data('key');
          var item_id = $(this).data('id');
          var deliveryman = '';
          var html='';
          var number = $('.total').val();
          var item = $(this).data('item');
          // console.log(number);
          if(!number){
            var total = 1;
          }else{
            var num = parseInt(number);
            var total = num+1;
          }
          if(item.length == total){
            $('.assign_btn').show();
          }
          
          var fee='';
          var fees=0;
          var item = $(this).data('item');
          
          $.post('deliverymanbytownship',{id:id[1]},function(res){
            if(res){

              $.each(res['township'],function(i,v){

                if(v.delivery_men.length > 0){


                  $.each(v.delivery_men,function(a,b){

                  html+= `
                                   
                          <option value="${item_id}=>${b.id}">${b.user.name}</option>`;
                    });

                   }else{

                    $.each(res['deliverymen'],function(c,d){

                        deliveryman += `
                                   
                            <option value="${item_id}=>${d.id}">${d.user.name}</option>`
                      })
                   }
                   fees = v.delivery_fees;
                   fee+= item_id + '=>' + v.delivery_fees;

                });
              
              if(html){
                $('.deliveryman'+key).html(html);

              }else{

                $('.deliveryman'+key).html(deliveryman);

              }
              $('.total').val(total);
              $('.delivery_fee_hidden'+key).val(fee);
              $('.delivery_fee'+key).val(fees);

            }
          })
        })

        $('.other_charge').change(function(){
          var key = $(this).data('key');
          var data = $(this).val();
          var id = $(this).data('item_id');
          

          $('.orther_charge_data'+key).val(id+'=>'+data);
          
        })

        
    })
  </script>
@endsection



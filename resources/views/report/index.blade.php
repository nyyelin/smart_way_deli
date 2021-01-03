@extends('main')
@section('content')
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> {{ __("Report")}}</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="{{route('report')}}">{{ __("Report")}}</a></li>
      </ul>
    </div>

    <div class="row">
      
      <div class="col-md-10 mx-auto">
        <div class="card">
          <div class="card-body">
            <div class="row form-group">
            
              <div class="col-md-5">
                <input type="date" name="date" class="form-control date">
              </div>

              <div class="col-md-5">

                <select class="js-example-basic-single form-control client_id" height="500px">
                  <option>Choose Client</option>
                  @foreach($clients as $client)
                    <option value="{{$client->id}}">{{$client->user->name}}</option>
                  @endforeach
                </select>
              </div>

              <div class="col-md-2">
                <button class="btn btn-info search_report">Search</button>
              </div>

            </div>

          </div>
        </div>
      </div>
    </div>


    <div class="row mt-4 client_show">
      

    </div>
  </main>
@endsection
@section('script')
<script type="text/javascript">
  $(document).ready(function(){

      $.ajaxSetup({
           headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

    $('.js-example-basic-single').select2({width:'100%'});
    $('.search_report').click(function(){
        var date = $('.date').val();
        var client_id = $('.client_id').val();
        var client_show = '';
        var deli_fee =0;
        var other_charge = 0;
        var service_charge=0;
        var total=0;
        var return_data = '';
        var array=new Array();
        var amount = 0;
        var name = '';
        var cname = '';
        var phone ='';
        var address ='';
        var refund_data = '';
        var name = '';
        var contact_person = '';
        var phone = '';
        var address = '';
        $.post('report_search',{date:date,client_id:client_id},function(res){
          
          var html = '';
          var total = 0;
          var amount = 0;
          var other_charge = 0;
          var delivery_fee = 0;
          var carry_fee = 0;
          var service_charge = 0;
          var guest_amount = 0;
          var pickupd_id = new Array();
          var item_array = new Array();

          if(res.length > 0){

            $.each(res,function(i,v){
              console.log(v);
              if(v.status_code == '001'){
                if(v.item !== null){

                  pickupd_id.push(v.item.pickup.id);

                  name = v.item.client.user.name;
                  contact_person = v.item.client.contact_person;
                  phone = v.item.client.phone_no;
                  address = v.item.client.address;
                  item_array.push(v.item.client_id);
                  delivery_fee += v.item.delivery_fees;
                  other_charge += v.item.other_fees;
                 $.each(v.item.pickup.expenses,function(a,b){
                  if(b.expense_type_id == 5){
                    amount = b.amount;
                    guest_amount = b.guest_amount;
                  }
                 })
                }
                 
              }
            })

            $.unique(pickupd_id);

            service_charge = item_array.length * 100;
            total += amount-(guest_amount + delivery_fee + other_charge + service_charge);


            html += `<div class="col-md-10 mx-auto">
                      <div class="card">
                        <div class="card-body">

                          <div class="row mx-auto ">
                            <div class="col-md-12 col-sm-12 ">

                                  <label class="d-inline-block float-right"><i class="fa fa-phone pr-2"></i>${phone}</label>
                                
                              <div class="row">

                                <div class="col-md-6 col-sm-6">

                                  <i class="fa fa-user pr-2 "></i>
                                  <label class="font-weight-bold">${name}</label><label class="pl-3">( ${contact_person} )</label>
                                  
                                </div>
       
                              </div>

                            
                              <div class="row mb-3 ">

                                <div class="col-md-6 col-sm-6">

                                  <i class="fa fa-home pr-2"></i><label>${address}</label>
                                  
                                </div>
                              </div>

                          </div>
                        </div>


                          <div class="row mx-auto mt-3">
                            <div class="col-md-12">
                              <table class="table ">
                                <thead>
                                  <tr>
                                    <th>#</th>
                                    <th>Amount</th>
                                    <th>Service Charges</th>
                                    <th>Delivery Fees</th>
                                    <th>Guest Amount</th>
                                    <th>Other Charges</th>
                                    
                                    <th>Total</th>

                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td>#</td>
                                    <td>${amount}</td>
                                    <td>${service_charge}</td>
                                    <td>${delivery_fee}</td>
                                    <td>${guest_amount}</td>
                                    <td>${other_charge}</td>
                                    <td> <form action="{{route('report_detail_show')}}" method="post">
                                      @csrf
                                      <input type="hidden" name="pickup_id" value="${pickupd_id}">
                                      <input type="hidden" name="cname" value="${name}">
                                      <input type="hidden" name="contact_person" value="${contact_person}">
                                      <input type="hidden" name="phone" value="${phone}">
                                      <input type="hidden" name="address" value="${address}">


                                      <button type="submit" class="btn btn-info rounded circle text-light display-4">${total}</button>

                                    </form></td>

                                  </tr>
                                </tbody>
                              </table>
                            </div>
                          </div>
                      


                        </div>
                      </div>
                    </div>`;

                    $('.client_show').html(html);

          }
        })
    })

  })
</script>


@endsection
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
            
              <div class="col-md-5 offset-md-2">
                <input type="date" name="date" class="form-control date">
              </div>

              <div class="col-md-2 offset-md-1">
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
        // var client_id = $('.client_id').val();
        var client_show = '';
        var deli_fee =0;
        var other_charge = 0;
        var service_charge=0;
        var total=0;
        var return_data = '';
        var array=new Array();
        var amount = 0;
        var refund_data = '';
        $.post('client_report_search',{date:date},function(res){
             
          
          if(res.length > 0){
            $.each(res,function(key,schedule){
                if(schedule.items.length > 0){
                
                  $.each(schedule.items,function(k,v){

                    if(v.way && v.way.status_code == '001'){
                    deli_fee += v.delivery_fees;

                    array.push(v.way.status_code);
                    if(v.other_fees > 0){

                    other_charge += v.other_fees;

                        }

                      }

                    })

                    service_charge += array.length*100;
                    

                    total += schedule.amount-(deli_fee+other_charge+service_charge);
                    amount+=schedule.amount;

                    

                      $.each(schedule.items,function(a,b){
                        if(b.way && b.way.status_code == '002'){
                            refund_data += `
                            <h3>Return list</h3>
                            <div class="row mx-auto mt-3">
                              <div class="col-md-12">
                                <table class="table ">
                                  <thead>
                                    <tr>

                                      <th>#</th>
                                      <th>Codeno</th>
                                      <th>Item Name</th>
                                      <th>Price * Qty</th>
                                      <th>Reciver info</th>
                                      <th>Action</th>
                                      
                                      
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td>#</td>
                                      <td>${b.codeno}</td>
                                      <td>${b.item_name}</td>
                                      <td>${b.item_price}*${b.item_qty}</td>
                                      <td>
                                        ${b.receiver_name}<br>
                                        <span class="badge badge-dark">${b.receiver_phone_no}</span>
                                      </td>
                                      <td> <h1 class="badge badge-danger">return</h1></td>

                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                            `;
                        }
                      })

                      
            
              }
            })


                client_show += `
                    <div class="col-md-10 mx-auto">
                      <div class="card">
                        <div class="card-body">
                        <div class="row mx-auto mt-3">
                          <div class="col-md-12">
                            <table class="table ">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>Amount</th>
                                  <th>Service Charges</th>
                                  <th>Delivery Fees</th>
                                  <th>Other Charges</th>
                                  
                                  <th>Total</th>

                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>#</td>
                                  <td>${amount}</td>
                                  <td>${service_charge}</td>
                                  <td>${deli_fee}</td>
                                  <td>${other_charge}</td>
                                  <td> <h4 class="text-info">${total}</h4></td>

                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                        ${refund_data}
                        `;

                        client_show+=`</div>
                                  </div>
                                </div>`;





                    $('.client_show').html(client_show);
          }else{


            client_show += `<div class="col-md-10 mx-auto">
                              <div class="card">
                                <div class="card-body">

                                  
                                      <div class="row">
                                      <div class="col-md-12">
                                          <h3 class="text-center">No Data</h3>
                                      </div>
                                      </div>
                                    
                                </div>
                              </div>
                            </div>`;

            $('.client_show').html(client_show);
          }

        })

    })


  })
</script>


@endsection
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

    <div class="row mt-4">

      <div class="col-md-10 mx-auto">
        <div class="card">
          <div class="card-body">

          <div class="row mx-auto ">
            <div class="col-md-12 col-sm-12 ">

                <label class="d-inline-block float-right"><i class="fa fa-phone pr-2"></i>{{$phone}}</label>
                  
                <div class="row">

                  <div class="col-md-6 col-sm-6">

                    <i class="fa fa-user pr-2 "></i>
                    <label class="font-weight-bold">{{$cname}}</label><label class="pl-3">( {{$contact_person}} )</label>
                    
                  </div>

                </div>

            </div>
          </div>


            <div class="row mx-auto mt-3">
              <div class="col-md-12">
                <table class="table">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Reciever Address</th>
                      <th>Reciver Name</th>
                      <th>Item</th>
                      <th>Qty</th>
                      <th>Amount</th>
                      <th>Delivery Fee</th>
                      <th>Remark</th>


                    </tr>
                  </thead>
                  <tbody>
                    @php
                      $i=1;
                      $total = 0;
                      $delivery_fee = 0;
                    @endphp
                    @foreach($items as $item)
                      @foreach($item as $row)
                      @php
                        $amount = $row->item_qty * $row->item_price;
                        $total+=$amount;
                        $delivery_fee += $row->delivery_fees;
                      @endphp
                        <tr @if($row->reportway->deleted_at) class="bg-danger text-white"  @endif>
                          <td>{{$i}}</td>
                          <td>{{$row->receiver_address}}</td>
                          <td>{{$row->receiver_name}}<br>
                            <span span class="badge badge-dark">{{$row->receiver_phone_no}}</span>
                          </td>
                          <td>{{$row->item_name}}</td>
                          <td>{{$row->item_qty}}</td>
                          <td>

                            {{$amount}}
                            @if($row->paystatus == 2)
                            <span span class="badge badge-dark">FOC</span>
                            @endif
                          </td>
                          <td>{{$row->delivery_fees}}</td>
                          <td>
                          @if($row->reportway->deleted_at)
                          {{$row->expired_date}}
                          @endif
                          </td>

                        </tr>
                      @php
                        $i++;
                      @endphp
                      @endforeach
                      
                    @endforeach
                    <tr>
                      <td colspan="5">
                        
                      </td>
                      <td>
                        {{$total}}
                      </td>
                      <td>{{$delivery_fee}}</td>
                      <td></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </main>
@endsection
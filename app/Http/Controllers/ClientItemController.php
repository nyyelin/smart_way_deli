<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Item;
use Carbon;
use Auth;
use App\Client;
use App\Schedule;
use App\SenderGate;
use App\SenderPostoffice;
use App\Township;
use App\Deliveryman;
use App\Pickup;
use App\Way;


class ClientItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::user()->client->id;
        $items = Item::where('client_id','=',$id)->where('schedule_id','=',null)->get();
        return view('client_item.client_item',compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $item_code_no = '';
        $id = Auth::user()->client->id;

        $client = Client::find($id);
        $codeno = $client->codeno;
        $date = Carbon\Carbon::now();
        $array = explode('-', $date->toDateString());
        $date_code = $array[2].'00'.'1';
        $item = Item::where('client_id',$id)->whereDate('created_at',Carbon\Carbon::today())->orderBy('id','DESC')->first();
          
        if(!$item){

        $item_code_no = $codeno.$date_code;
           

        }else{
        $code = $item->codeno;
        $mycode = substr($code, 13,14);
        $item_code_no = $codeno.$array[2].'00'.($mycode+1);
        }
          

        return view('client_item.client_item_create',compact('item_code_no'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $request->validate([
          'item_name'=>'required',
          'item_price'=>'required',
          'receiver_name'=>'required',
          'receiver_phoneno'=>'required',
          'receiver_address'=>'required',

          ]);

          // expired date
          $date = Carbon\Carbon::today();
          $date->toDateString();
          $expired_date = $date->addDays(3);
         

          $client_id = Auth::user()->client->id;
          $item = new Item;
          $item->codeno = $request->codeno;
          $item->expired_date = $expired_date;
          $item->item_name = $request->item_name;
          $item->item_price = $request->item_price;
          $item->receiver_name = $request->receiver_name;
          $item->receiver_phone_no = $request->receiver_phoneno;
          $item->receiver_address = $request->receiver_address;
          $item->send_type = $request->sendtype;
          $item->item_qty = $request->qty;
          $item->remark=$request->remark;
          $item->client_id = $client_id;
          if($request->paystatus){
            $item->paystatus = $request->paystatus;
          }else{
            $item->paystatus = 1;
          }

          $item->save();
          return redirect()->route('client_items.index')->with("successMsg",'New Item is ADDED in your data');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Item::find($id);
        return view('client_item.client_item_edit',compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $request->validate([
          'item_name'=>'required',
          'item_price'=>'required',
          'receiver_name'=>'required',
          'receiver_phoneno'=>'required',
          'receiver_address'=>'required',

          ]);

          // expired date
          $date = Carbon\Carbon::today();
          $date->toDateString();
          $expired_date = $date->addDays(3);
         

          $client_id = Auth::user()->client->id;
          $item = Item::find($id);
          $item->codeno = $request->codeno;
          $item->expired_date = $expired_date;
          $item->item_name = $request->item_name;
          $item->item_price = $request->item_price;
          $item->receiver_name = $request->receiver_name;
          $item->receiver_phone_no = $request->receiver_phoneno;
          $item->receiver_address = $request->receiver_address;
          $item->send_type = $request->sendtype;
          $item->item_qty = $request->qty;
          $item->remark=$request->remark;
          $item->client_id = $client_id;
          if($request->paystatus){
            $item->paystatus = $request->paystatus;
          }else{
            $item->paystatus = 1;
          }

          $item->save();
          return redirect()->route('client_items.index')->with("successMsg",'Updatesuccessfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Item::find($id);
        $item->delete();
        return redirect()->route('client_items.index')->with('successMsg','Existing Item is DELETED in your data');

    }

    public function client_order(Request $request)
    {
      // dd($request);
        $date = Carbon\Carbon::today();
        $date->toDateString();
        
        $id = Auth::user()->client->id;
        

        $schedule = new Schedule;
        $schedule->pickup_date = $date;
        $schedule->quantity = $request->total_qty;
        $schedule->amount = $request->total_price;
        $schedule->client_id = $id;
        $schedule->remark=$request->remark;
        $schedule->save();

        $s_id = $schedule->id;
        $items = $request->order;

        foreach($items as $value){
            $item = Item::find($value);
            $item->schedule_id = $s_id;
            $item->save();
        }
        return redirect()->route('client_items.index')->with('successMsg','Today,your orders are complete!');



    }

    public function order_assign($id)
    {
      $schedule = Schedule::find($id);
      $townships = Township::orderBy('name','ASC')->where('status',1)->get();
      $gates = Township::orderBy('name','ASC')->where('status',2)->get();
      $posts = Township::orderBy('name','ASC')->where('status',3)->get();

      $senderpostoffices = SenderPostoffice::orderBy('name','ASC')->get();
      $sendergates = SenderGate::orderBy('name','ASC')->get();
      $deliverymen = Deliveryman::all();

      return view('client_item.order_assign',compact('schedule','sendergates','senderpostoffices','townships','deliverymen','gates','posts'));
    }

    public function deliverymanbytownship(Request $request)
    {
      $township = Township::where('id','=',$request->id)->with(array('delivery_men'=>function($q){
        $q->with('user')->get(); 
      }))->get();

      $deliverymen = Deliveryman::with('user')->get();
      $data = ['township' => $township,
                'deliverymen' => $deliverymen];
      return response()->json($data);

    }


    public function order_assign_store(Request $request,$id)
    {
      dd($request);
      $date = Carbon\Carbon::today();
      $date->toDateString();
      
      $mycities = $request->mycity;

      $mygates = $request->mygate;

      $mypostoffices = $request->mypostoffice;

      $deliverymen = $request->delivery_man;

      $other_charges = $request->other_charges;

      $item_id = $request->item_id;

      $deliveryfees = $request->delivery_fee;

      $mycity_array = array();
      $mygate_array = array();
      $mypostoffice_array = array();
      $deliveryman_array = array();
      $other_charge_array = array();
      $deliveryfee_array = array();

      foreach ($mycities as $mycity) {
          list($k , $v) = explode('=>', $mycity);
          $mycity_array[$k] = $v;
          
      }
      if($mygates){
        foreach ($mygates as $mygate) {
            list($k , $v) = explode('=>', $mygate);
            $mygate_array[$k] = $v;
            
        }
      }

      if($mypostoffices){
        foreach ($mypostoffices as $mypostoffice) {
            list($k , $v) = explode('=>', $mypostoffice);
            $mypostoffice_array[$k] = $v;
            
        }
      }

      foreach ($deliverymen as $deliveryman) {
          list($k , $v) = explode('=>', $deliveryman);
          $deliveryman_array[$k] = $v;
          
      }


      foreach ($other_charges as $other_charge) {
        if($other_charge){
            list($k , $v) = explode('=>', $other_charge);
            $other_charge_array[$k] = $v;
          }
          
      }

      foreach ($deliveryfees as $deliveryfee) {
          list($k , $v) = explode('=>', $deliveryfee);
          $deliveryfee_array[$k] = $v;
      }
      $schedule = Schedule::find($id);
      $schedule->status=1;
      $schedule->save();

      $pickup = new Pickup;
      $pickup->status = 1;
      $pickup->schedule_id =$id;
      $pickup->staff_id = Auth::user()->staff->id;
      $pickup->save();

      $pickup_id = $pickup->id;

      for ($i=0; $i < count($item_id); $i++) { 


        
          $item = Item::find($item_id[$i]);

          if(array_key_exists($item_id[$i],$mycity_array )){
            $item->township_id = $mycity_array[$item_id[$i]];
          }


          if(count($mygate_array) > 0){
            if(array_key_exists($item_id[$i], $mygate_array)){
              $item->sender_gate_id = $mygate_array[$item_id[$i]];
            }

          }

          if(count($mypostoffice_array) > 0){
            if(array_key_exists($item_id[$i],$mypostoffice_array)){

              $item->sender_postoffice_id = $mypostoffice_array[$item_id[$i]];

            }

          }
          if(array_key_exists($item_id[$i],$deliveryfee_array)){

            $item->delivery_fees = $deliveryfee_array[$item_id[$i]];

          }

          if(count($other_charge_array) > 0){

            if(array_key_exists($item_id[$i], $other_charge_array)){

            $item->other_fees = $other_charge_array[$item_id[$i]];

            }
          }

          $item->pickup_id = $pickup_id;

          $item->staff_id = Auth::user()->staff->id;

          $item->save();

          $way = new Way;
          $way->status_code = '005';
          $way->delivery_date = $date;
          $way->item_id = $item_id[$i];
          if(array_key_exists($item_id[$i],$deliveryman_array)){

            $way->delivery_man_id = $deliveryman_array[$item_id[$i]];
          }
          $way->staff_id = Auth::user()->staff->id;
          $way->status_id = 5;
          $way->save();

      }

      return redirect()->route('schedules.index')->with("successMsg",'Client order assign complete!');
     

    }

    
}

















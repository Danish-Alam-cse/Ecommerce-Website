<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Coupon;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use PaytmWallet;


class Cart extends Controller
{
   public function __construct(){
        $this->middleware('auth');   
   }


   public function order(){
    $user = Auth::User();
    $cond = [['ordered',false],['user_id',$user->id]];
    $order = Order::where($cond)->get()->first();
    $orderitem = Order::find($order->id)->orderitem;
    $total = 0;
    foreach($orderitem as $oi){
        $total += $oi->pro->price;
    }

       $payment = PaytmWallet::with('receive');
       $payment->prepare([
         'order' =>rand(1,100),
         'user' => $user->id,
         'mobile_number' => $order->address->contact,
         'email' => $user->email,
         'amount' => $total,
         'callback_url' => 'http://127.0.0.1:8000/payment/status'
       ]);
       return $payment->receive();
   }

   
   public function paymentCallback(){
        $user = Auth::User();
        $cond = [['ordered',false],['user_id',$user->id]];
        $order = Order::where($cond)->get()->first();
        $orderitem = Order::find($order->id)->orderitem;
       $transaction = PaytmWallet::with('receive');
       
       $response = $transaction->response(); // To get raw response as array
       //Check out response parameters sent by paytm here -> http://paywithpaytm.com/developer/paytm_api_doc?target=interpreting-response-sent-by-paytm
       
       if($transaction->isSuccessful()){
            foreach($orderitem as $oi){
                $oi = OrderItem::find($oi->id);
                $oi->ordered = true;
                $oi->save();
            }
            $o = Order::find($order->id);
            $o->ordered = true;
            $o->save();

           return redirect()->route('myorder');
         //Transaction Successful
       }else if($transaction->isFailed()){
         //Transaction Failed
       }else if($transaction->isOpen()){
         //Transaction Open/Processing
       }
       $transaction->getResponseMessage(); //Get Response Message If Available
       //get important parameters via public methods
       $transaction->getOrderId(); // Get order id
       $transaction->getTransactionId(); // Get transaction id
   }    
   public static function get_cart_count(){
        $user = Auth::User();
        $cond = [['ordered',false],['user_id',$user->id]];
        $order = Order::where($cond)->get()->first();
        if($order){
            $orderitem = Order::find($order->id)->orderitem;
            return $orderitem->count();
        }
        return 0;
   }

   public function remove_item($item_id){

        $product = OrderItem::where(['product_id'=>$item_id])->delete();
        return redirect()->route('cart');

   }
   public function cart(){  
        $user = Auth::User();
        $cond = [['ordered',false],['user_id',$user->id]];
        $order = Order::where($cond)->get()->first();
        if($order){
            $orderitem = Order::find($order->id)->orderitem;
        
        
        }

        else{
            return redirect()->route('homepage');
        }
        return view('home.cart',['orderitem'=>$orderitem,"order"=>$order]);
   }
   
   public function myorder(){  
       
    $user = Auth::User();
    $cond = [['ordered',true],['user_id',$user->id]];
    $order = Order::where($cond)->orderBy('id','DESC')->get();
    // return view('home.myorder',["order"=>$order]);
    return $order;
    }
   public function addToCart($item_id){
            $product = Product::find($item_id);
            $user = Auth::User();
            $cond = [['ordered',false],['user_id',$user->id]];
            if($product){
                    $order = Order::where($cond)->get()->first();
                    if($order){
                        $orderitem = OrderItem::where($cond+['product_id'=>$item_id])->get()->first();
                        if($orderitem){
                            $orderitem->qty += 1;
                            $orderitem->save(); 
                        }
                        else{
                            $oi = new Orderitem;
                            $oi->product_id = $item_id;
                            $oi->user_id = $user->id;
                            $oi->order_id = $order->id;
                            $oi->ordered = false;
                            $oi->save();
                        }

                    }
                    else{
                        $o = Order::create([
                            'ordered' => false,
                            'user_id' => $user->id
                        ]);
                       
                            $oi = new Orderitem;
                            $oi->product_id = $item_id;
                            $oi->user_id = $user->id;
                            $oi->order_id = $o->id;
                            $oi->ordered = false;
                            $oi->save();
                        
                    }

                    return redirect()->back();

            }
            else{
                // $request->session()->flash('error', "Product Not found");
                return redirect()->back();
            }
   }

   public function removeCart($item_id){
    $product = Product::find($item_id);
    $user = Auth::User();
    $cond = [['ordered',false],['user_id',$user->id]];
    if($product){
            $order = Order::where($cond)->get()->first();
            if($order){
                $orderitem = OrderItem::where($cond+['product_id'=>$item_id])->get()->first();
                if($orderitem){
                    if($orderitem->qty > 1){
                    $orderitem->qty -= 1;
                    $orderitem->save();
                    }
                    else{
                        return redirect()->route('removeitem',['item_id'=>$item_id]);
                    }
                }
            }
            return redirect()->route('cart');

        }
    else{
        // $request->session()->flash('error', "Product Not found");
        return redirect()->back();
    }
   }

   public function checkout(){
    $user = Auth::User();
    $cond = [['ordered',false],['user_id',$user->id]];
    $order = Order::where($cond)->get()->first();
    $orderitem = Order::find($order->id)->orderitem;
    $address = Address::where("user_id",$user->id)->get();
    
       return view('home.checkout',['orderitem'=>$orderitem,"order"=>$order,'address'=>$address]);
   }


   public function insertCheckout(Request $req){    
       $req->validate([
           'name' => 'required',
           'contact' => 'required',
           'street' => 'required',
           'area' => 'required',
           'city' => 'required',
           'state' => 'required',
           'pincode' => 'required',
       ]);

       $address = Address::Create([
        'name' => $req->name,
        'contact' => $req->contact,
        'street' => $req->street,
        'area' => $req->area,
        'city' => $req->city,
        'state' => $req->state,
        'pincode' => $req->pincode,
        'user_id' => Auth::id()
       ]);

       return redirect()->back();
   }

   public function makePayment(Request $req){

    $address_id = $req->address_id;
    $user = Auth::User();
    $cond = [['ordered',false],['user_id',$user->id]];
    $order = Order::where($cond)->get()->first();
    $address = Address::find($address_id);

    $o = Order::find($order->id);
    $o->address_id = $address->id;
    $o->save();

    //hum karenge redirect baad mai

    return redirect()->route('pay');
   
   }
}

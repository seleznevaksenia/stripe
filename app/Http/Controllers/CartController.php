<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cart = null;
        if($request->session()->has('cart')){
            $cart = session()->get('cart');
        }
        return view('cart.create',compact('cart'));
    }

    public function create(Request $request)
    {
        $currency = 'usd';
        $username = $request->username;
        $line1 = $request->line1;
        $city = $request->city;
        $state = $request->state;
        $country = $request->country;
        $postal_code = $request->postal_code;
        $count = $request->count;
        $items = [];

        for($i = 0;$i<$count;$i++){
            $item = [
                "type" => "sku",
                "parent" => $request->sku[$i],
                "quantity" => $request->qty[$i],
            ];
            array_push($items,$item);
        }

        $order = \Stripe\Order::create([
            "items" => $items,
            "currency" => $currency,
            "shipping" => [
                "name" => $username,
                "address" => [
                    "line1" => $line1,
                    "city" => $city,
                    "state" => $state,
                    "country" => $country,
                    "postal_code" => $postal_code
                ]
            ]]
        );

        $result = self::payOrder($order->id);
        if($result->status === "paid"){
            Session::forget('cart');
            return redirect()->route('success');
        }
        else{
            return redirect()->route('unsuccess');
        }
    }

    public function addToCart(Request $request,$skuId){

        $uid = md5(uniqid(mt_rand(), true));
        if($request->shippable == true){
            $request->session()->push('shippable',$uid);
        }

        $request->session()->push('cart.'.$uid,
        [
            'sku' => $skuId,
            'name'=> $request->name,
            'price' => $request->price,
            'qty' => $request->qty,
            'shippable' => $request->shippable
        ]);
        return redirect()->route('index');
    }


    public function delete(Request $request,$uid){
        $shippable = $request->session()->get('shippable',null);

        if(($key = array_search($uid,$shippable)) !== FALSE){
            array_splice($shippable, $key, 1);
        }
        $request->session()->push('shippable',$shippable);

        $request->session()->forget('cart.'.$uid);
        return redirect()->route('cart');
    }

    protected function payOrder($orderId){

        $order = \Stripe\Order::retrieve($orderId);

        $result = $order->pay([
            "customer" => auth()->user()->stripe_id,
             "email" => auth()->user()->email
        ]);

        return $result;

    }

}

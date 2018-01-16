<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CardController extends Controller
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
        return view('card.create');
    }

    public function create(Request $request)
    {
        $month = $request->month;
        $year = $request->year;
        $number = $request->number;
        $cvc = $request->cvc;

        $object = \Stripe\Token::create([
            "card" =>[
                "number" => $number,
                "exp_month" => $month,
                "exp_year" => $year,
                "cvc" => $cvc
            ]
        ]);
        $token = $object->id;

        $stripe_user = \Stripe\Customer::create([
            "description" => "Customer for MySop",
            "email" => auth()->user()->mail,
            "source" => $token // obtained with Stripe.js
        ]);

        $customer = \Stripe\Customer::retrieve($stripe_user->id);

        //$customer->sources->create(array("source" => $token));

        $user = auth()->user();
        $user->stripe_id =  $stripe_user->id;
        $user->save();

        return redirect()->route('index');

    }

}

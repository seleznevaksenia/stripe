<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
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
        $products = null;
        try {
            $products = \Stripe\Product::all(array("limit" => 10));
            $products = $products->data;

        } catch (\Stripe\Error\InvalidRequest $e) {
            dd($e->getMessage());
        }

        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a Product.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('products.create');
    }

    /**
     * Show the form for creating a Sku to Product.
     *
     * @return \Illuminate\Http\Response
     */
    public function createSku($id)
    {
        $product = \Stripe\Product::retrieve($id);
        $currency = config('services.stripe.currencies');
        return view('products.sku.create', compact(['currency', 'product']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $name = $request->name;
        $description = $request->description;
        $size = $request->size;
        $gender = $request->gender;
        $shippable = $request->shippable;
        if(!$shippable){
            $shippable = false;
        }
        $attributes = [];
        $result = [
            "name" => $name,
            "description" => $description,
            "shippable" => $shippable
        ];

        if ($size) {
            array_push($attributes, $size);
        }
        if ($gender) {
            array_push($attributes, $gender);
        }

        if($size || $gender){
            $result["attributes"] = $attributes;
        }

        \Stripe\Product::create($result);

        return redirect()->route('index');
    }


    public function storeSku(Request $request, $id)
    {
        $request->validate([
            'price' => 'required|numeric',
            'currency' => 'required',
            'type' => 'required',
            'quantity' => 'required_if:type,finite',
            'size' => 'sometimes|required',
            'gender' => 'sometimes|required'

        ]);

        $product = $id;
        $size = $request->size;
        $gender = $request->gender;
        $price = Product::invertPrice($request->price);
        $currency = $request->currency;
        $type = $request->type;
        $quantity = $request->quantity;
        $attributes = [];
        $inventory = [];
        $inventory["type"] = $type;

        if ($quantity) {
            $inventory['quantity'] = $quantity;
        }

        $result = [
            "product" => $product,
            "price" => $price,
            "currency" => $currency,
            "inventory" => $inventory];

        if ($size) {
            $attributes['size'] = $size;
        }
        if ($gender) {
            $attributes['gender'] = $gender;
        }

        if($size || $gender){
            $result['attributes'] = $attributes;
        }

        $sku = \Stripe\SKU::create($result);
        return redirect()->route('index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $product = \Stripe\Product::retrieve($id);
        return view('products.show', compact('product'));
    }

    public function showSku($skuId)
    {
        $orders = \Stripe\Order::all();
        //if true you can delete sku
        $delete = true;

        foreach ($orders->data as $order) {
            foreach ($order->items as $item) {
                if ($item->parent === $skuId) {
                    $delete = false;
                    break 2;
                }
            }
        }
        $sku = \Stripe\SKU::retrieve($skuId);
        return view('products.sku.show', compact('sku', 'delete'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = \Stripe\Product::retrieve($id);
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Product $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'shippable' => 'required|bool'
        ]);

        $name = $request->name;
        $description = $request->description;
        $size = $request->size;
        $gender = $request->gender;

        $product = \Stripe\Product::retrieve($id);
        $product->name = $name;
        $product->description = $description;
        $product->attributes = [$size, $gender];
        $product->save();
        return redirect()->route('index');
    }

    public function updateSku(Request $request, $skuId)
    {

        $request->validate([
            'price' => 'required|numeric',
            'currency' => 'required',
            'type' => 'required',
            'quantity' => 'required_if:type,finite',
            'size' => 'sometimes|required',
            'gender' => 'sometimes|required'

        ]);


        $price = Product::invertPrice($request->price);
        $currency = $request->currency;
        $type = $request->type;
        $quantity = $request->quantity;
        $size = $request->size;
        $gender = $request->gender;
        $inventory = [];
        $attributes = [];

        $inventory['type'] = $type;
        if ($quantity) {
            $inventory['quantity'] = $quantity;
        }
        if ($size) {
            $attributes['size'] = $size;
        }
        if ($gender) {
            $attributes['gender'] = $gender;
        }

        $sku = \Stripe\SKU::retrieve($skuId);
        $sku->price = $price;
        $sku->currency = $currency;
        $sku->inventory = $inventory;
        $sku->attributes = $attributes;
        $sku->save();
        return redirect()->route('index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        //delete only if have no skus
        $product = \Stripe\Product::retrieve($id);
        $product->delete();
        return redirect()->route('index');

    }

    public function deleteSku($skuId)
    {
        //delete only if have no skus
        $sku = \Stripe\SKU::retrieve($skuId);
        $sku->delete();
        return redirect()->route('index');
    }
}

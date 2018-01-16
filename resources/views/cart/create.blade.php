@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @if($cart)
                @if(\Illuminate\Support\Facades\Session::get('shippable'))
                <div class="col-md-8 col-md-offset-2">
                    <h4>Shipping info</h4>
                    <fieldset class="form-horizontal">
                    <div class="form-group">
                        <label for="username" class="control-label col-xs-2">Name</label>
                        <div class="col-xs-10">
                            <input type="text" form="order" class="form-control" id="username" name = "username" placeholder="Name"
                            value="{{auth()->user()->name}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="line1" class="control-label col-xs-2">Line1</label>
                        <div class="col-xs-10">
                            <input type="text" form="order" class="form-control" id="line1" name = "line1" placeholder="line1">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="currency" class="control-label col-xs-2">City</label>
                        <div class="col-xs-10">
                            <input type="text" form="order" class="form-control" id="city" name = "city" placeholder="City">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="state" class="control-label col-xs-2">State</label>
                        <div class="col-xs-10">
                            <input type="text" form="order" class="form-control" id="state" name = "state" placeholder="State">
                        </div>
                    </div>
                    <div class="form-group quantity">
                        <label for="country" class="control-label col-xs-2">Country</label>
                        <div class="col-xs-10">
                            <input type="text" form="order" class="form-control" id="country" name ="country" placeholder="Country">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="postal_code" class="control-label col-xs-2">Postal code</label>
                        <div class="col-xs-10">
                            <input type="text" form="order" class="form-control" id="postal_code" name ="postal_code" placeholder="Postal code">
                        </div>
                    </div>
                    </fieldset>
                </div>
                @endif
            <div class="col-md-8 col-md-offset-2">
                    <h4>Order</h4>
                    <form disabled="disable" method="post" id="order" action="{{route('createOrder')}}">
                        {{ csrf_field() }}
                    </form>
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <td>SKU</td>
                            <td>Name</td>
                            <td>Price</td>
                            <td>Quantity</td>
                            <td>Total</td>
                            <td>Action</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($cart as $item => $value)
                            <tr>
                                <td><input name="sku[]" form="order" value="{{ $value[0]['sku'] }}"></td>
                                <td><input name="name[]" form="order" value="{{ $value[0]['name']}}"></td>
                                <td><input name="price[]" form="order" value="{{ $value[0]['price'] }}"></td>
                                <td><input name="qty[]" form="order" value="{{ $value[0]['qty']}}"></td>
                                <td>{{number_format($value[0]['price']*$value[0]['qty'], 2, '.', ',')}}</td>
                                <td>
                                    <form class="form-horizontal" method="post" action="{{route('deleteOrderItem',$item)}}">
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        {{method_field('DELETE')}}
                                        {{ csrf_field() }}
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        <input name="count" type="hidden" value="{{ count($cart)}}" form="order">
                        </tbody>
                    </table>
                        <button type="submit" form="order" class="btn btn-success btn-block">Checkout</button>
                @else
                    Yoor cart is empty! Add Order Items!
                @endif
            </div>
            </div>
        </div>
@endsection
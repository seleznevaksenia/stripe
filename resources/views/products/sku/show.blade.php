@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @include('validation.errors')
                <h4><b>SKU</b> {{$sku->id}}</h4>
                <form class="form-horizontal" method="post" action="{{route('updateSku',$sku->id)}}">
                    {{ csrf_field() }}
                    {{method_field('PUT')}}
                    <fieldset>
                        <div class="form-group">
                            <label for="size" class="control-label col-xs-2">Size</label>
                            <div class="col-xs-10">
                                <input type="text" class="form-control" id="size" name = "size" placeholder="Size"
                                       value="{{$sku->attributes->size}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="gender" class="control-label col-xs-2">Gender</label>
                            <div class="col-xs-10">
                                <input type="text" class="form-control" id="gender" name = "gender" placeholder="Gender"
                                       value="{{$sku->attributes->gender}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="currency" class ="control-label col-xs-2">Currency</label>
                            <div class="col-xs-10">
                                <input type="text" class ="form-control" id="currency" name = "currency" placeholder="Currency"
                                       value="{{$sku->currency}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="type" class ="control-label col-xs-2">Type</label>
                            <div class="col-xs-10">
                                <select class ="form-control" id ="type" name = "type">
                                    <option value="finite" @if ("finite" === $sku->inventory->type) selected @endif> finite</option>
                                    <option  value="infinite" @if ("infinite" === $sku->inventory->type) selected @endif> infinite</option>
                                    <option  value="bucket" @if ("bucket" === $sku->inventory->type) selected @endif> bucket</option>
                                </select>
                            </div>
                        </div>
                        @if($sku->inventory->type === 'finite')
                        <div class="form-group quantity">
                            <label for="quantity" class="control-label col-xs-2">Quantity</label>
                            <div class="col-xs-10">
                                <input type="text" class="form-control" id="quantity" name ="quantity" placeholder="Quantity"
                                       value="{{$sku->inventory->quantity}}">
                            </div>
                        </div>
                        @endif
                        <div class="form-group">
                            <label for="price" class="control-label col-xs-2">Price</label>
                            <div class="col-xs-10">
                                <input type="text" class="form-control" id="price" name ="price" placeholder="Price"
                                       value="{{\App\Product::invertPriceReverse($sku->price)}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-offset-2 col-xs-10">
                                <button type="submit" class="btn btn-primary btn-block">Edit SKU</button>
                            </div>
                        </div>
                    </fieldset>
                </form>
                @if($delete)
                    <form class="form-horizontal" method="post" action="{{route('deleteSku',$sku->id)}}">
                        <div class="form-group">
                            <div class="col-xs-offset-2 col-xs-10">
                                <button type="submit" class="btn btn-danger btn-block">Delete Sku</button>
                            </div>
                        </div>
                        {{method_field('DELETE')}}
                        {{ csrf_field() }}
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection
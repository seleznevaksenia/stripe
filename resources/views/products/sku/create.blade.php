@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @include('validation.errors')
                <h4>Add sku to <b>{{$product->name}}</b> ID:{{$product->id}}</h4>
                <form class="form-horizontal" method="post" action="{{route('storeSku',$product->id)}}">
                    {{ csrf_field() }}
                    <fieldset>
                        <div class="form-group">
                            <label for="price" class="control-label col-xs-2">Price*</label>
                            <div class="col-xs-10">
                                <input type="number" class="form-control" id="price" name = "price" placeholder="Price">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="currency" class="control-label col-xs-2">Currency</label>
                            <div class="col-xs-10">
                            <select class="form-control" id="currency" name = "currency">
                                @foreach($currency as $item)
                                    <option  value="{{ $item }}" > {{ $item }}</option>
                                @endforeach
                            </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="type" class="control-label col-xs-2">Type</label>
                            <div class="col-xs-10">
                                <select class="form-control" id="type" name = "type">
                                    <option selected value="finite" > finite</option>
                                    <option  value="infinite" > infinite</option>
                                    <option  value="bucket" > bucket</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group quantity">
                            <label for="quantity" class="control-label col-xs-2">Quantity*</label>
                            <div class="col-xs-10">
                                <input type="number" class="form-control" id="quantity" name ="quantity" placeholder="Quantity">
                            </div>
                        </div>
                        @if(data_get($product,'attributes.0'))
                        <div class="form-group">
                            <label for="size" class="control-label col-xs-2">Size</label>
                            <div class="col-xs-10">
                                <input type="text" class="form-control" id="size" name ="size" placeholder="Size">
                            </div>
                        </div>
                        @endif
                        @if(data_get($product,'attributes.1'))
                        <div class="form-group">
                            <label for="gender" class="control-label col-xs-2">Gender</label>
                            <div class="col-xs-10">
                                <input type="text" class="form-control" id="gender" name ="gender" placeholder="Gender">
                            </div>
                        </div>
                        @endif
                        <div class="form-group">
                            <div class="col-xs-offset-2 col-xs-10">
                                <button type="submit" class="btn btn-primary btn-block">Create sku</button>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
@endsection
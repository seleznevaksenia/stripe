@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                    <h4>Products</h4>
                <div> <a class="btn btn-small btn-success" href="{{ route('create') }}">Create Product</a></div>
                <br>
                @if(!empty($products))
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <td rowspan="2">ID</td>
                            <td rowspan="2">Name</td>
                            <td rowspan="2">Description</td>
                            <td colspan="2">Attributes</td>
                            <td rowspan="2">Skus</td>
                            <td rowspan="2">Action</td>
                        </tr>
                        <tr>
                            <td>Size</td>
                            <td>Gender</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $key)
                            <tr>
                                <td>{{ $key->id }}</td>
                                <td>{{ $key->name }}</td>
                                <td>{{ $key->description }}</td>
                                <td>{{ data_get($key,'attributes.0') }}</td>
                                <td>{{ data_get($key, 'attributes.1') }}</td>
                                <td>
                                    @foreach($key->skus->data as $sku)
                                        <div class="row">
                                            <div class="col-md-6">
                                                <a href="{{ route('showSku',$sku->id) }}"><span>{{$sku->id}}</span></a>
                                                <span>{{\App\Product::invertPriceReverse($sku->price)}}{{$sku->currency}}</span>
                                                <span>qty:{{number_format($sku->inventory->quantity, 0, '.', ',')}}</span>
                                            </div>
                                            @if($sku->inventory->quantity >0)
                                                <div class="col-md-6">

                                                <form class="form-inline" method="post" action="{{route('addToCart',$sku->id)}}">
                                                    <div class="form-group">
                                                        <input type="number" class="form-control" id="qty" name="qty">
                                                        <input type="hidden" class="form-control" id="price" name="price" value="{{$sku->price}}">
                                                        <input type="hidden" class="form-control" id="name" name="name" value="{{$key->name}}">
                                                        <input type="hidden" class="form-control" id="shippable" name="shippable" value="{{$key->shippable}}">
                                                    </div>
                                                    {{ csrf_field() }}
                                                    <button type="submit" class="btn btn-primary btn-sm">Add</button>
                                                </form>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </td>
                                <td>

                                    <a class="btn btn-success btn-sm" href="{{ route('show',$key->id) }}">Show</a>

                                    <a class="btn btn-info btn-sm" href="{{ route('edit' ,$key->id) }}">Edit</a>
                                    @if(empty($key->skus->data))
                                    <form class="form-horizontal" method="post" action="{{route('delete',$key->id)}}">
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        {{method_field('DELETE')}}
                                        {{ csrf_field() }}
                                    </form>
                                    @endif
                                    <a class="btn btn-sm btn-info" href="{{ route('createSku' ,$key->id) }}">Add sku</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    You haven't any product! Add please!
                @endif
            </div>
        </div>
    </div>
@endsection
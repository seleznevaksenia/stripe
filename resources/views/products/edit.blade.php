@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @include('validation.errors')
                    <h4>Edit</h4>
                    <form class="form-horizontal" method="post" action="{{route('update',$product->id)}}">
                        {{method_field('PUT')}}
                        {{ csrf_field() }}
                        <fieldset>
                            <div class="form-group">
                                <label for="name" class="control-label col-xs-2">Name</label>
                                <div class="col-xs-10">
                                    <input type="text" class="form-control" id="name" name = "name" placeholder="Name"
                                    value="{{$product->name}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description" class="control-label col-xs-2">Description</label>
                                <div class="col-xs-10">
                                    <input type="text" class="form-control" id="description" name = "description" placeholder="Description"
                                           value="{{$product->description}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="size" class="control-label col-xs-2">Size</label>
                                <div class="col-xs-10">
                                    <input type="text" class="form-control" id="size" name = "size" placeholder="Size"
                                           value="{{$product->attributes[0]}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="gender" class="control-label col-xs-2">Gender</label>
                                <div class="col-xs-10">
                                    <input type="text" class="form-control" id="gender" name ="gender" placeholder="Gender"
                                           value="{{$product->attributes[1]}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-offset-2 col-xs-10">
                                    <button type="submit" class="btn btn-primary btn-block">Edit</button>
                                </div>
                            </div>
                        </fieldset>
                    </form>
            </div>
        </div>
    </div>
@endsection
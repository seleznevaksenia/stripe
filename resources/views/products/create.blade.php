@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @include('validation.errors')
                <h4>General information</h4>
                <form class="form-horizontal" method="post" action="{{route('store')}}">
                    {{ csrf_field() }}
                    <fieldset>
                        <div class="form-group">
                            <label for="name" class="control-label col-xs-2">Name*</label>
                            <div class="col-xs-10">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="control-label col-xs-2">Description*</label>
                            <div class="col-xs-10">
                                <input type="text" class="form-control" id="description" name="description"
                                       placeholder="Description">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="radio-inline"><input type="checkbox" name="size" value="size">Add attribute
                                Size</label>
                            <label class="radio-inline"><input type="checkbox" name="gender" value="gender">Add
                                attribute Gender</label>
                        </div>
                        <div class="form-group">
                            <label class="radio-inline"><input type="radio" checked="checked" name="shippable" value='true'>Shippable</label>
                            <label class="radio-inline"><input type="radio" name="shippable" value='false'>Unshippable</label>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-offset-2 col-xs-10">
                                <button type="submit" class="btn btn-primary btn-block">Create</button>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
@endsection
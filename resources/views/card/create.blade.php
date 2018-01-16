@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @if(auth()->user()->stripe_id !== null)
                <h5>You have been already add your card information</h5>
                @endif
                <h4>Add card information</h4>
                <form class="form-horizontal" method="post" action="{{route('createCard')}}">
                    {{ csrf_field() }}
                    <fieldset>
                        <div class="form-group">
                            <label for="month" class="control-label col-xs-2">Card's expiration month*</label>
                            <div class="col-xs-10">
                                <input type="number" class="form-control" id="month" name = "month" placeholder="12">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="year" class="control-label col-xs-2">Card's expiration year*</label>
                            <div class="col-xs-10">
                                <input type="number" class="form-control" id="year" name ="year" placeholder="2017">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="number" class="control-label col-xs-2">Card number*</label>
                            <div class="col-xs-10">
                                <input type="number" class="form-control" id="number" name ="number" placeholder="Number">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="cvc" class="control-label col-xs-2">CVC*</label>
                            <div class="col-xs-10">
                                <input type="number" class="form-control" id="cvc" name ="cvc" placeholder="123">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-offset-2 col-xs-10">
                                <button type="submit" class="btn btn-primary btn-block">Create Card</button>
                            </div>
                        </div>
                    </fieldset>
                </form>

            </div>
        </div>
    </div>
@endsection
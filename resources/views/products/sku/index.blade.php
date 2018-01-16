@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-2">
                    <h4>Products</h4>
                <div> <a class="btn btn-small btn-success" href="{{ route('create') }}">Create Product</a></div>
                <br>

                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <td>ID</td>
                            <td>Name</td>
                            <td>Description</td>
                            <td>Size</td>
                            <td>Gender</td>
                            <td>Action</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $key)
                            <tr>
                                <td>{{ $key->id }}</td>
                                <td>{{ $key->name }}</td>
                                <td>{{ $key->description }}</td>
                                <td>{{ $key->attributes[0] }}</td>
                                <td>{{ $key->attributes[1] }}</td>

                                <!-- we will also add show, edit, and delete buttons -->
                                <td>

                                    <a class="btn btn-small btn-success" href="{{ route('show',$key->id) }}">Show</a>

                                    <a class="btn btn-small btn-info" href="{{ route('edit' ,$key->id) }}">Edit</a>
                                    <form class="form-horizontal" method="post" action="{{route('delete',$key->id)}}">
                                    <button type="submit" class="btn btn-small btn-danger">Delete</button>
                                        {{method_field('DELETE')}}
                                        {{ csrf_field() }}
                                    </form>
                                    <a class="btn btn-small btn-info" href="{{ route('createsku' ,$key->id) }}">Add sku</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
            </div>
        </div>
    </div>
@endsection
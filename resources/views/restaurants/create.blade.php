@extends('layout')



@section('content')
    <style>
        .uper {
            margin-top: 40px;
        }
    </style>
    <div class="card uper">
        <div class="card-header">
            Add Restaurant
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div><br />
            @endif
            <form method="post" action="{{ route('restaurants.store') }}">
                <div class="form-group">
                    @csrf
                    <label for="name">Restaurant Name:</label>
                    <input type="text" class="form-control" name="rest_name" placeholder="Enter name of a restaurant"/>
                </div>
                <div class="form-group">
                    <label for="address">Restaurant Address:</label>
                    <input type="text" class="form-control" name="rest_address" id="rest_address"/>
                </div>
                <div class="form-group">
                    <label for="number">Restaurant Number:</label>
                    <input type="text" class="form-control" name="tel_num" placeholder="Enter telephone number"/>
                </div>
                <button type="submit" class="btn btn-primary">Add</button>

            </form>
        </div>
    </div>

    <div class="link">
        <a href="{{ route('restaurants.index')}}" class="btn btn-primary">Restaurant List</a>
    </div>

@endsection



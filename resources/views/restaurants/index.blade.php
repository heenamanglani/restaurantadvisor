@extends('layout')


@section('content')
    <style>
        .uper {
            margin-top: 40px;
        }
    </style>

    <ul class="nav nav-tabs">

        <li><a href="#listview" class="listview" data-toggle="tab">List View</a></li>
        <li><a href="#mapview" class="mapview" data-toggle="tab">Map View</a></li>

    </ul>

    <div class="uper listviews">
        @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div><br />
        @endif
        <table class="table table-bordered">
            <thead>
            <tr class="table_header">
                <td>ID</td>
                <td>Restaurant Name</td>
                <td>Restaurant Address</td>
                <td>Restaurant Number</td>
                <td>Distance</td>
                <td>Direction</td>
                <td colspan="2">Action</td>
            </tr>
            </thead>
            <tbody>
            <?php $i = 0 ?>
            @foreach($restaurants as $rest)
                <?php $i++;


                if(isset($_COOKIE['clat']))
                    {
                        $lat1 = $_COOKIE['clat'];
                        $long1 = $_COOKIE['clong'];

                        $origin = $lat1.",".$long1;


                        $dest = $rest->lat.",".$rest->lng;

                        $url = "https://www.google.com/maps/dir/?api=1&origin=$origin&destination=$dest&key=AIzaSyCd1ROM9OflA9ao8n1c1ctFcVD6SGafOrM";
                    }
                    else{

                        $lat1= 28.000;
                        $long1 = -26.7890;
                        $url = "www.google.com";
                    }




                ?>
                <tr>
                    <td>{{$i}}</td>
                    <td>{{$rest->rest_name}}</td>
                    <td>{{$rest->rest_address}}</td>
                    <td>{{$rest->tel_num}}</td>
                    <td>{{getDistanceBetweenPointsNew($lat1, $long1, $rest->lat, $rest->lng, $unit = 'Km')}} Km</td>
                    <td><a class="take_link" target="_blank" title="Take me there!" href="{{$url}}"><img alt="" src="{{ asset('directions.png') }}"></a></td>
                    <td><a href="{{ route('restaurants.edit',$rest->id)}}" class="btn btn-primary">Edit</a></td>
                    <td>
                        <form action="{{ route('restaurants.destroy', $rest->id)}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
            <div class="pull-right">
                <a href="{{ route('restaurants.create')}}" class="btn btn-primary">Create new restaurant</a>
            </div>
    </div>

    <div class="uper mapviews">
        <div id="map" style="width: 800px; height: 600px; position: relative; overflow: hidden;"></div>
    </div>


@endsection



<?php
function getDistanceBetweenPointsNew($latitude1, $longitude1, $latitude2, $longitude2, $unit = 'Km') {
    $theta = $longitude1 - $longitude2;
    $distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
    $distance = acos($distance);
    $distance = rad2deg($distance);
    $distance = $distance * 60 * 1.1515; switch($unit) {
        case 'Mi': break; case 'Km' : $distance = $distance * 1.609344;
    }
    return (round($distance,2));
}
?>

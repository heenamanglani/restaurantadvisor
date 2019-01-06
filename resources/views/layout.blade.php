<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" ng-app="RestaurantAdvisor">

<!--<script src="http://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyCd1ROM9OflA9ao8n1c1ctFcVD6SGafOrM"></script>-->


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.js"></script>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Restaurant Advisor</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">

</head>
<body>
<div class="container">
    <div class="link">
        <a href="{{url('/')}}">Restaurant Advisor</a>
    </div>
    @yield('content')
</div>

<script src="{{ asset('js/app.js') }}" type="text/js"></script>
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>

<script>



    jQuery(document).on('click', '.mapview', function () {

        jQuery('.listviews').hide();
        jQuery('.mapviews').show();


    });

    jQuery(document).on('click', '.listview', function () {

        jQuery('.mapviews').hide();
        jQuery('.listviews').show();
    });

    $(document).ready(function() {

        jQuery('.mapviews').hide();
    });

   /* jQuery(window).on("load", function(){

        jQuery('.mapviews').hide();
    });*/

</script>

@if (Request::path() == 'restaurants')
    <script  async defer src="http://maps.googleapis.com/maps/api/js?callback=initMap&key=AIzaSyAZGtQGJr9f0UqR_9aLZlTYougTGP4fCkk"></script>
    <script>

        // This example displays a marker at the center of Australia.
        // When the user clicks the marker, an info window opens.


        function initMap() {


            $.ajax
            ({
                url: "{{ url('/restaurants/show') }}",
                type: 'get',
                success: function(result)
                {
                    $.each(result, function(){
                        //Plot the location as a marker
                        var pos = new google.maps.LatLng(this.lat, this.lng);
                        var markers = new google.maps.Marker({
                            position: pos,
                            map: map,
                            icon: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png'
                        });

                        var contentStrings = '<div id="content">'+
                            '<div id="siteNotice">'+
                            '</div>'+
                            '<h1 id="firstHeading" class="firstHeading">'+ this.rest_name + '</h1>'+
                            '<div id="bodyContent">'+
                            '<p>'+ this.rest_address + '</p>'+
                            '</div>'+
                            '</div>';

                        var infowindows = new google.maps.InfoWindow({
                            content: contentStrings
                        });

                        markers.addListener('click', function() {
                            infowindows.open(map, markers);
                        });
                    });
                }
            });

            var lat =  Cookies.get("clat");
            var long = Cookies.get("clong");


            var currentposition = {
                lat : parseFloat(lat ),
                lng : parseFloat(long)
            }
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 12,
                center: currentposition
            });

            var contentString = '<div id="content">'+
                '<div id="siteNotice">'+
                '</div>'+
                '<h1 id="firstHeading" class="firstHeading">Your current location</h1>'+
                '<div id="bodyContent">'+
                '</div>'+
                '</div>';

            var infowindow = new google.maps.InfoWindow({
                content: contentString
            });

            var marker = new google.maps.Marker({
                position: currentposition,
                map: map,
                title: 'Your current location'
            });

            marker.addListener('click', function() {
                infowindow.open(map, marker);
            });



        }
    </script>
@else

    <script src="http://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyAZGtQGJr9f0UqR_9aLZlTYougTGP4fCkk"></script>
    <script type="text/javascript">

        google.maps.event.addDomListener(window, 'load', function () {
            var places = new google.maps.places.Autocomplete(document.getElementById('rest_address'));

            google.maps.event.addListener(places, 'place_changed', function () {

            });
        });


    </script>


@endif

</body>
</html>

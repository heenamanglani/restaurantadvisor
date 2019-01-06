var map, mapMobile;
var mapLoaded = false, mapMobileLoaded = false;
var mapVisible = false, mapMobileVisible = false;
var markers = [];
var allMarker = [];
var bound;
var finalObj;
var iw;
var oms;
var usualColor;
var spiderfiedColor;
var iconWithColor;
var shadow;
var clusterMarker = [];

usualColor = 'eebb22';
spiderfiedColor = 'ffee22';

iconWithColor = function (type) {

    if (type == 'ft') {
        return getDomain() + '/public/images/pin_truck.png';
    } else if (type = 'lr')
    {
        return getDomain() + '/public/images/pin_rest.png';
    } else
    {
        return getDomain() + '/public/images/pin_inde.png';
    }

}

shadow = new google.maps.MarkerImage(
        'https://www.google.com/intl/en_ALL/mapfiles/shadow50.png',
        new google.maps.Size(37, 34), // size   - for sprite clipping
        new google.maps.Point(0, 0), // origin - ditto
        new google.maps.Point(10, 34)  // anchor - where to meet map location
        );

function refreshMap(ids)
{
    //alert(ids);
    clusterMarker = [];
    initMap(ids);
}

function initMap(ids) {

    map = new google.maps.Map(document.getElementById('map_canvas'), {
        center: new google.maps.LatLng(29.76328, -95.36327),
        zoom: 18
    });

    iw = new google.maps.InfoWindow();
    oms = new OverlappingMarkerSpiderfier(map, {markersWontMove: true, markersWontHide: true, keepSpiderfied: true});

    oms.addListener('click', function (marker) {
        iw.setContent(marker.desc);
        iw.open(map, marker);
    });

    oms.addListener('spiderfy', function (markers) {
        iw.close();
    });

    oms.addListener('unspiderfy', function (markers) {
        iw.close();
    });

    calculateBound(ids);
    mapLoaded = true;
}



function getDomain() {
    var url = window.location.href;
    var arr = url.split("/");
    var result = arr[0] + "//" + arr[2];
    return result;
}


function calculateBound(ids) {
    if (ids !== '')
    {
        idds = ids;
    } else {
        idds = '';
    }
    var data = null;
    if ($("#user-lat").val())
    {
        data = {'ids': idds, 'lat': $("#user-lat").val(), 'lng': $("#user-lng").val()};
    } else {
        data = {'ids': idds, 'lat': 0, 'lng': 0};
    }
    $.ajax({
        url: 'https://www.localserves.com/mapajaxsearch',
        type: "post",
        data: data,
        dataType: 'json',
        success: function (response) {
            //console.log(response);
            var jsonstring = JSON.stringify(response);
            DomMap(response);

        }
    });

// var businesses = JSON.parse($('#businesses').val());
// console.log('heena');
// console.log(businesses);

    bound = new google.maps.LatLngBounds();
    var h;
    function DomMap(businesses) {
        console.log(businesses);
        var location_exists = businesses['location-exists'], is_address = $("#is-address").val(),
                exact_location = $("#exact-address").val();
        businesses.forEach(function (b, i) {

//    console.log(b);
            console.log(i);
            var datum = b;
            loc = new google.maps.LatLng(b.lat, b.lng);
            bound.extend(loc);

            var marker = new google.maps.Marker({
                position: loc,
                title: b.item_name,
                icon: iconWithColor(b.business_type),
                map: map,
            });

            var itemRating = b.item_review;

            var star;
            var loggedIn = b['logged_in'], communityLink = b['community_page']

            if (b.item_review == 1) {
                star = '<img class="map_img" src="/public/images/yellowstar.png" width="10px"  height="10px" ><img class="map_img" src="/public/images/grey.png" width="10px"  height="10px"><img class="map_img" src="/public/images/grey.png" width="10px"  height="10px"><img class="map_img" src="/public/images/grey.png" width="10px"  height="10px"><img  class="map_img" src="/public/images/grey.png" width="10px"  height="10px">';
            } else if (b.item_review == 2) {
                star = '<img class="map_img" src="/public/images/yellowstar.png" width="10px"  height="10px"><img class="map_img" src="/public/images/yellowstar.png" width="10px"  height="10px"><img class="map_img" src="/public/images/grey.png" width="10px"  height="10px"><img class="map_img" src="/public/images/grey.png" width="10px"  height="10px"><img class="map_img" src="/public/images/grey.png" width="10px"  height="10px">';
            } else if (b.item_review == 3) {
                star = '<img class="map_img" src="/public/images/yellowstar.png" width="10px"  height="10px"><img class="map_img" src="/public/images/yellowstar.png" width="10px"  height="10px"><img class="map_img" src="/public/images/yellowstar.png" width="10px"  height="10px"><img class="map_img" src="/public/images/grey.png" width="10px"  height="10px"><img class="map_img" src="/public/images/grey.png" width="10px"  height="10px">';
            } else if (b.item_review == 4) {
                star = '<img class="map_img" src="/public/images/yellowstar.png" width="10px"  height="10px"><img class="map_img" src="/public/images/yellowstar.png" width="10px"  height="10px"><img class="map_img" src="/public/images/yellowstar.png" width="10px"  height="10px"><img src="/public/images/yellowstar.png" class="map_img" width="10px"  height="10px"><img src="/public/images/grey.png" width="10px" class="map_img" height="10px">';
            } else if (b.item_review == 5)
            {
                star = '<img class="map_img" src="/public/images/yellowstar.png" width="10px"  height="10px"><img class="map_img" src="/public/images/yellowstar.png" width="10px"  height="10px"><img class="map_img" src="/public/images/yellowstar.png" width="10px"  height="10px"><img class="map_img" src="/public/images/yellowstar.png" width="10px"  height="10px"><img class="map_img" src="/public/images/yellowstar.png" width="10px"  height="10px">';
            } else {
                star = '<img class="map_img" width="10px"  height="10px" src="/public/images/grey.png"><img class="map_img" src="/public/images/grey.png" width="10px"  height="10px"><img src="/public/images/grey.png" width="10px"  height="10px" class="map_img"><img src="/public/images/grey.png" width="10px"  height="10px" class="map_img"><img src="/public/images/grey.png" width="10px"  height="10px" class="map_img">';
            }



            if (b.is_price_visible == 'No')
            {
                var price = "$" + parseFloat(b.item_price).toFixed(2).toString();
            } else {
                var price = 'CALL FOR PRICE';
            }

            var image_link = b.business_handle + "/items/" + b.item_handle;

//            if (!loggedIn) {
//                image_link = communityLink;
//            }
            var image = "https://www.localserves.com/admin/img.php?width=250&height=150&cropratio=3:2&image=https://www.localserves.com/public/uploads/items/" + encodeURIComponent(b.item_image);

//  if(b.item_all_reviews > 1)
//  {
            var spanstring = '<div title="Click for More Details!" class="rating-map-stars rating-div-map' + i + '" id="rating-div' + i + '">' + star + '</div><span class="allrating">[' + b.item_all_reviews + ']</span>'
//  }
//  else {
//    var spanstring = '';
//  }
            var distance = "NA";
            if ($("#user-lat").val())
            {
                console.log(is_address);
                if (is_address != '0')
                {
                    if ((exact_location == '' || exact_location == 0))
                    {
                        if (b.distance)
                            distance = '<div class="map-distance">' + parseFloat(b.distance).toFixed(2).toString() + ' miles' + '</div>';
                        else {
                            distance = '<div class="map-distance">0.00 miles</div>';
                        }
                    }
                } else if (exact_location == '' || exact_location == 0) {
                    distance = '<div class="map-distance">' + b.distance + '</div>';
                } else {
                    distance = '<div class="map-distance">0.00 miles</div>';
                }
            }
//    alert(distance);
            var contentString = '<div class="infoContent">' +
                    '<div class="siteNotice">' +
                    '</div>' +
                    '<h3 class="firstHeading" title="Click for More Details!" href="' + image_link + '">' + b.item_name.toUpperCase() + '</h3>' +
                    '<div id="bodyContent">' +
                    '<a id="maplink" title="Click for More Details!" href="' + image_link + '">' +
                    '<div class="property-img-view" style="margin-left:23px; width:230px; height:160px; background-image: url(' + image + ')"></div></a>' +
                    '<div class="map-details">' +
                    '<span>Price : ' + price + '</span>' +
                    spanstring
                    + '</div>' + distance + '' +
                    '</div></div>';
            console.log('' + distance + 'sd');
            marker.desc = contentString;

            oms.addMarker(marker);
            clusterMarker.push(marker);




            if (itemRating == '')
            {
                itemRating = '0';
            } else
            {
                itemRating = itemRating;
            }

            //alert(itemRating);



            $('.rating-div-map' + i).rateYo({
                rating: itemRating,
                starWidth: "15px",
                readOnly: true,
                ratedFill: "#FFD200",
                fullStar: true
            });
        });

//new MarkerClusterer(map, clusterMarker, {imagePath: 'https://cdn.rawgit.com/googlemaps/v3-utility-library/master/markerclustererplus/images/m', maxZoom: 15});



        map.fitBounds(bound);

    }
}

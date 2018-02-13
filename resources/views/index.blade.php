<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('css/easy-autocomplete.min.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/easy-autocomplete/1.3.5/easy-autocomplete.themes.min.css" />
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">


        <!-- Scripts -->
        <script src="{{ asset('js/jquery.min.js' )}}"></script>
        <script src="{{ asset('js/jquery.easy-autocomplete.min.js' )}}"></script>
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false&libraries=places"></script>
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>

    </head>
    <body>
        <div class="flex-center position-ref">
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group" style="display:inline;">
                            <div class="input-group">
                                <input type="text" class="form-control" id="searchname" name="searchname" placeholder="Search Cities">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div id="map" style="width: 100%; height: 300px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

<script type="text/javascript">
    var latLng = {lat: 40.177200, lng: 44.503490};
    var options = {
        url: function (phrase) {
            return "autocomplete/cities?phrase=" + phrase;
        },

        getValue: "name",

        list: {
            match: {
                enabled: true
            },

            onChooseEvent: function () {
                let latitude = $("#searchname").getSelectedItemData().latitude;
                let longitude = $("#searchname").getSelectedItemData().longitude;
                latLng = {lat: latitude, lng: longitude};

                initNearestCities(latitude, longitude);
            },

            maxNumberOfElements: 10
        },

        theme: "square"
    };

    $("#searchname").easyAutocomplete(options);

    function initNearestCities(lat, lng) {
        $.ajax({
            url: '/get-nearest-cities',
            type: 'POST',
            data: {
                'lat': lat,
                'lng': lng,
            },
            success: function (response) {
                    posList = [];
                    response.forEach(function(loc) {
                        posList.push({lat: loc.latitude, lng: loc.longitude});
                    });

                    initMap(posList);
            }
        });
    }

    function initMap(posList) {
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 9,
            center: latLng
        });

        // Create markers.
       if(posList !== undefined) {
           posList.forEach(function(pos) {
               new google.maps.Marker({
                   position: pos,
                   map: map
               });
           });
       } else {
           new google.maps.Marker({
            position: latLng,
            map: map
        });
       }
    }
</script>

<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBvTxFQ2dbDwbzZuzpBJglkvE0s1fyUiXs&callback=initMap">
</script>


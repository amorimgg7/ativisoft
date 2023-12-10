<!DOCTYPE html>
<html>
<head>
    <title>Obter Localização Atual</title>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBOwuy8lvGmtzjlU4iXX1UCncwBbKF8u-s"></script>
    <style>
        #map {
            height: 400px;
            width: 100%;
        }
    </style>
</head>
<body>
    <button onclick="obterLocalizacao()">Obter Localização Atual</button>
    <div id="map"></div>
    <script>
        var map;

        function obterLocalizacao() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    var latLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                    mostrarMapa(latLng);
                });
            } else {
                console.log('Geolocalização não é suportada pelo seu navegador.');
            }
        }

        function mostrarMapa(latLng) {
            map = new google.maps.Map(document.getElementById('map'), {
                center: latLng,
                zoom: 12
            });

            var marker = new google.maps.Marker({
                position: latLng,
                map: map
            });
        }
    </script>
</body>
</html>

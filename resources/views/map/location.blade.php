<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lokasi Budidaya di Indramayu</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        #map {
            height: 770px;
        }
    </style>
</head>

<body>
    <div id="map"></div>

    {{-- <ul>
        @foreach ($locations as $location)
            <li>{{ $location->nama_desa }}</li>
        @endforeach
    </ul> --}}

    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script>
        var map = L.map('map').setView([-6.3473692, 108.2884701], 10);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        var locations = @json($locations);

        var markers = []; // Array untuk menyimpan marker locations

        locations.forEach(function(location) {
            var marker = L.marker([location.latitude, location.longitude]).addTo(map).bindPopup(location.nama_desa + ', Kecamatan ' + location.kecamatan);

            markers.push(marker.getLatLng()); // Simpan lokasi marker untuk perhitungan bounds
        });

        // Jika ada lokasi, atur peta agar menyesuaikan semua marker
        if (markers.length > 0) {
            var bounds = L.latLngBounds(markers);
            map.fitBounds(bounds, {
                padding: [50, 50]
            }); // Tambahkan padding agar tidak terlalu mepet
        }
    </script>
</body>

</html>

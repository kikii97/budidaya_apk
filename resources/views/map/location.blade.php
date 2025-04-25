<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GIS Mapbox 3D</title>
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css' rel='stylesheet' />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Global Reset */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: sans-serif;
            line-height: 1.6;
            overflow: hidden;
        }

        #map {
            height: 100vh;
            width: 100vw;
            position: relative;
        }

        .search-bar {
            position: absolute;
            top: 23px;
            left: 30px;
            z-index: 10;
            display: flex;
            align-items: center;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            padding: 8px 12px;
            width: auto;
            max-width: 90%;
            gap: 8px;
        }

        .search-bar input {
            border: none;
            outline: none;
            flex: 1;
            font-size: 16px;
            background: transparent;
        }

        .search-bar button {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 18px;
            color: #888;
            padding: 4px 8px;
        }

        .search-bar button:active {
            color: #333;
        }

        /* Style untuk layer control */
        .layer-control {
            position: absolute;
            bottom: 40px;
            right: 30px;
            z-index: 10;
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 1px 3px #0003;
            overflow: hidden;
        }

        .layer-control button {
            background: none;
            border: none;
            padding: 12.5px;
            cursor: pointer;
            font-size: 18px;
            color: #484848;
            display: block;
            text-align: center;
        }

        .layer-control button:hover {
            background: #f0f0f0;
        }

        /* Tambahan: Style untuk ikon back */
        .back-btn i {
            font-size: 16px;
        }

        /* Zoom Control */
        .navigation-control {
            position: absolute;
            top: 30px;
            right: 30px;
            padding: 4px;
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 1px 3px #0003;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            z-index: 1;
        }

        .navigation-control button {
            background: #fff;
            border: none;
            padding: 10px;
            cursor: pointer;
        }

        .navigation-control button:hover {
            background: #f0f0f0;
        }

        .navigation-control__zoom-in-icon,
        .navigation-control__zoom-out-icon {
            width: 18px;
            height: 18px;
            fill: #333;
        }

        .map-zoom-control button {
            background: #fff;
            border: 1px solid #ccc;
            padding: 10px 14px;
            font-size: 18px;
            /* border-radius: 6px; */
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .map-zoom-control button:hover {
            background: #f0f0f0;
        }

        @media (max-width: 768px) {
            .search-bar {
                width: auto;
                max-width: 95%;
                top: 15px;
                left: 15px;
                padding: 4px 8px;
            }

            .search-bar input {
                font-size: 12px;
            }

            .search-bar button {
                font-size: 14px;
                padding: 2px;
            }

            .navigation-control {
                /* bottom: 10px; */
                right: 10px;
            }

            .navigation-control button {
                padding: 6px;
                font-size: 14px;
            }

            .layer-control {
                bottom: 10px;
                right: 10px;
            }

            .layer-control button {
                padding: 7px;
                font-size: 15px;
            }
        }
    </style>
</head>

<body>
    <div id="map">

        <!-- Search Filter -->
        <div class="search-bar">
            <button class="back-btn"><i class="fa fa-arrow-left"></i></button>
            <input type="text" id="searchInput" placeholder="Search">
            <button class="search-btn"><i class="fa fa-search"></i></button>
            <button class="filter-btn" id="filterBtn" aria-label="Filter">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-adjustments-horizontal">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M14 6m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                    <path d="M4 6l8 0" />
                    <path d="M16 6l4 0" />
                    <path d="M8 12m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                    <path d="M4 12l2 0" />
                    <path d="M10 12l10 0" />
                    <path d="M17 18m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                    <path d="M4 18l11 0" />
                    <path d="M19 18l1 0" />
                </svg>
            </button>
        </div>

        <!-- Layer Control -->
        <div class="layer-control">
            <button id="layerToggle" aria-label="Komoditas Unggulan">
                <i class="fa fa-layer-group"></i>
            </button>

            <div id="layerOptions" class="layer-options">
                </button>
                <button aria-label="Udang">
                    <i class="fas fa-shrimp"></i>
                </button>
                <button aria-label="Rumput Laut">
                    <i class="fas fa-water"></i>
                </button>
                <button aria-label="Ikan Bandeng">
                    <i class="fas fa-fish"></i>
                </button>
                <button aria-label="Ikan Gurame">
                    <i class="fas fa-fish"></i>
                </button>
                <button aria-label="Ikan Lele">
                    <i class="fas fa-fish"></i>
                </button>
                <button aria-label="Ikan Nila">
                    <i class="fas fa-fish"></i>
                </button>
            </div>
        </div>

        <!-- Custom Zoom Control -->
        <div class="navigation-control map__navigation-control">
            <button class="navigation-control__zoom-in-button" type="button" onclick="map.zoomIn()">
                <svg id="plus" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg"
                    class="navigation-control__zoom-in-icon">
                    <path d="M6 8V14H8V8H14V6H8V0H6V6H0V8H6Z"></path>
                </svg>
            </button>
            <button class="navigation-control__zoom-out-button" type="button" onclick="map.zoomOut()">
                <svg id="minus" viewBox="0 0 14 2" xmlns="http://www.w3.org/2000/svg"
                    class="navigation-control__zoom-out-icon">
                    <path d="M14 2H0V0H14V2Z"></path>
                </svg>
            </button>
        </div>
    </div>


    <script src='https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.js'></script>

    <script>
        mapboxgl.accessToken = 'pk.eyJ1Ijoia2lraWtzMjMiLCJhIjoiY205dDZiZDgyMDgzdzJtcTk1bW81ZG4wOCJ9.2KzfsbK1tXHs7vuAkwMsKQ';

        var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/satellite-streets-v12',
            center: [108.2884701, -6.3473692],
            zoom: 10,
            pitch: 0,
            bearing: 0,
            antialias: true
        });

        var locations = @json($locations);
        var bounds = new mapboxgl.LngLatBounds();
        var markers = [];

        locations.forEach(function(location) {
            var marker = new mapboxgl.Marker()
                .setLngLat([location.longitude, location.latitude])
                .setPopup(new mapboxgl.Popup().setText(location.nama_desa + ', Kecamatan ' + location.kecamatan))
                .addTo(map);

            markers.push({
                marker,
                location
            });
            bounds.extend([location.longitude, location.latitude]);
        });

        if (locations.length > 0) {
            map.fitBounds(bounds, {
                padding: 50
            });
        }

        map.on('load', () => {
            map.addSource('mapbox-dem', {
                'type': 'raster-dem',
                'url': 'mapbox://mapbox.mapbox-terrain-dem-v1',
                'tileSize': 512,
                'maxzoom': 14
            });

            map.setTerrain({
                'source': 'mapbox-dem',
                'exaggeration': 1.5
            });

            map.addLayer({
                'id': 'hillshading',
                'source': 'mapbox-dem',
                'type': 'hillshade'
            });

            map.easeTo({
                pitch: 60,
                bearing: 20,
                duration: 4000,
                zoom: 12
            });
        });

        // Search filter function
        function filterMarkers() {
            var query = document.getElementById('searchInput').value.toLowerCase();
            markers.forEach(({
                marker,
                location
            }) => {
                if (location.nama_desa.toLowerCase().includes(query)) {
                    marker.getElement().style.display = 'block';
                } else {
                    marker.getElement().style.display = 'none';
                }
            });
        }
        // Contoh event: klik tombol filter
        document.getElementById('filterBtn').addEventListener('click', function() {
            alert('Filter options opened!');
        });

        const layerToggle = document.getElementById('layerToggle');
        const layerOptions = document.getElementById('layerOptions');

        layerToggle.addEventListener('click', () => {
            layerOptions.style.display = layerOptions.style.display === 'block' ? 'none' : 'block';
        });

        // Biar klik di luar dropdown nutup menu-nya
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.layer-control')) {
                layerOptions.style.display = 'none';
            }
        });
    </script>
</body>

</html>

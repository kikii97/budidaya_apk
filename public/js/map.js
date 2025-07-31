document.addEventListener("DOMContentLoaded", () => {
    // Hover interactivity
    let hoveredId = null;
    let hoverTimeout;
    let lastKecamatan = null;
    let fitBoundsTimeout = null;
    let hoveredDesaId = null;
    let kecamatanBounds = {};
    let renderTimeout;

    mapboxgl.accessToken =
        "pk.eyJ1Ijoia2lraWtzMjMiLCJhIjoiY205dDZiZDgyMDgzdzJtcTk1bW81ZG4wOCJ9.2KzfsbK1tXHs7vuAkwMsKQ";

    const map = new mapboxgl.Map({
        container: "map",
        style: "mapbox://styles/mapbox/light-v11",
        center: [108.1806802, -6.4399159],
        zoom: 9.5,
    });

    map.on("load", () => {
        map.addSource("batas-kec", {
            type: "geojson",
            data: kecamatan,
            generateId: true,
        });

        map.on("sourcedata", (e) => {
            if (e.sourceId === "batas-kec" && e.isSourceLoaded) {
                const features = map.querySourceFeatures("batas-kec");
                features.forEach((feature) => {
                    const name = feature.properties.Name;
                    kecamatanBounds[name] = turf.bbox(feature);
                });
            }
        });

        map.addLayer({
            id: "fill-kec-layer",
            type: "fill",
            source: "batas-kec",
            paint: {
                "fill-color": [
                    "case",
                    ["boolean", ["feature-state", "hover"], false],
                    "#9dd27f",
                    "rgba(0,0,0,0)",
                ],
                "fill-opacity": 0.5,
            },
        });

        map.addLayer({
            id: "batas-kec-layer",
            type: "line",
            source: "batas-kec",
            paint: {
                "line-color": "#616161",
                "line-width": 1,
            },
        });

        map.addLayer({
            id: "label-kec",
            type: "symbol",
            source: "batas-kec",
            layout: {
                "text-field": ["get", "Name"],
                "text-size": [
                    "interpolate",
                    ["linear"],
                    ["zoom"],
                    8,
                    10,
                    12,
                    14,
                ],
                "symbol-placement": "point", // <--- tambahkan ini
                "text-allow-overlap": true, // <--- ini juga penting!
                "text-ignore-placement": true,
            },
            paint: {
                "text-color": "#000",
                "text-halo-color": "#fff",
                "text-halo-width": 2,
            },
        });

        map.addSource("batas-desa", {
            type: "geojson",
            data: desa,
            generateId: true,
        });

        map.addLayer({
            id: "batas-desa-layer",
            type: "line",
            source: "batas-desa",
            paint: {
                "line-color": "#009688",
                "line-width": 1,
            },
            layout: {
                visibility: "visible",
            },
            filter: ["==", "sub_district", ""],
        });

        map.addLayer({
            id: "hover-shadow",
            type: "line",
            source: "batas-kec",
            paint: {
                "line-color": "rgba(0,0,0,0.6)",
                "line-width": 4,
                "line-blur": 3,
                "line-opacity": 0.7,
            },
            filter: ["==", "Name", ""], // awalnya kosong
        });

        map.addLayer({
            id: "hover-shadow-desa",
            type: "line",
            source: "batas-desa",
            paint: {
                "line-color": "rgba(0,0,0,0.6)",
                "line-width": 5,
                "line-opacity": 0.5,
            },
            filter: ["==", "village", ""], // awal kosong
        });

        map.addLayer({
            id: "fill-desa-shadow",
            type: "fill",
            source: "batas-desa",
            paint: {
                "fill-color": "rgba(0, 0, 0, 0.3)", // warna bayangan
                "fill-opacity": 0.3,
                "fill-translate": [2, 2], // geser bayangannya
            },
        });

        map.addLayer({
            id: "fill-desa-layer",
            type: "fill",
            source: "batas-desa",
            paint: {
                "fill-color": [
                    "case",
                    ["boolean", ["feature-state", "hover"], false],
                    "#9dd27f",
                    "rgba(0,0,0,0)",
                ],
                "fill-opacity": 0.6,
            },
            filter: ["==", "sub_district", ""],
        });

        map.addLayer({
            id: "hover-fill-kec",
            type: "line",
            source: "batas-kec",
            paint: {
                "line-color": "#ffc107",
                "line-width": 3,
            },
            filter: ["==", "Name", ""],
        });

        map.addLayer({
            id: "label-desa",
            type: "symbol",
            source: "batas-desa",
            layout: {
                "text-field": ["get", "village"],
                "text-size": 11,
                "text-font": ["Open Sans Bold", "Arial Unicode MS Bold"],
                "text-offset": [0, 0.8],
                "text-anchor": "top",
            },
            paint: {
                "text-color": "#333",
                "text-halo-color": "#ffffff",
                "text-halo-width": 1,
            },
            filter: ["==", "sub_district", ""],
        });

        

        let lastFlyToTime = 0;

        map.on("click", "fill-kec-layer", (e) => {
            if (e.features && e.features.length > 0) {
                const feature = e.features[0];
                const namaKecamatan = feature.properties.Name;

                if (lastKecamatan !== namaKecamatan) {
                    lastKecamatan = namaKecamatan;

                    // Ambil langsung feature geometry
                    const bbox = turf.bbox(feature);

                    const camera = map.cameraForBounds(bbox, {
                        padding: {
                            top: 80,
                            bottom: 80,
                            left: 100,
                            right: 100,
                        },
                    });
                    if (camera) {
                        map.easeTo({
                            ...camera,
                            duration: 1500,
                        });
                    }

                    // Set feature state hover
                    if (hoveredId !== null) {
                        map.setFeatureState(
                            {
                                source: "batas-kec",
                                id: hoveredId,
                            },
                            {
                                hover: false,
                            }
                        );
                    }
                    hoveredId = feature.id;
                    map.setFeatureState(
                        {
                            source: "batas-kec",
                            id: hoveredId,
                        },
                        {
                            hover: true,
                        }
                    );

                    // Set filter desa
                    map.setFilter("batas-desa-layer", [
                        "==",
                        "sub_district",
                        namaKecamatan.toUpperCase(),
                    ]);
                    map.setFilter("fill-desa-layer", [
                        "==",
                        "sub_district",
                        namaKecamatan.toUpperCase(),
                    ]);
                    map.setFilter("label-desa", [
                        "==",
                        "sub_district",
                        namaKecamatan.toUpperCase(),
                    ]);
                    map.setFilter("hover-shadow", [
                        "==",
                        "Name",
                        namaKecamatan,
                    ]);
                    map.setFilter("hover-shadow-desa", [
                        "==",
                        "Name",
                        namaKecamatan,
                    ]);
                }
            }
        });

        map.on("click", (e) => {
            const features = map.queryRenderedFeatures(e.point, {
                layers: ["fill-kec-layer"],
            });

            if (features.length === 0) {
                // Reset semua state
                if (hoveredId !== null) {
                    map.setFeatureState(
                        {
                            source: "batas-kec",
                            id: hoveredId,
                        },
                        {
                            hover: false,
                        }
                    );
                }
                hoveredId = null;
                lastKecamatan = null;

                // Reset filter
                map.setFilter("batas-desa-layer", ["==", "sub_district", ""]);
                map.setFilter("fill-desa-layer", ["==", "sub_district", ""]);
                map.setFilter("hover-shadow", ["==", "Name", ""]);
                map.setFilter("hover-shadow-desa", ["==", "Name", ""]);
                map.setFilter("label-desa", ["==", "sub_district", ""]);
                map.setFilter("hover-fill-desa", ["==", "village", ""]);

                // Zoom out ke view awal
                map.flyTo({
                    center: [108.1806802, -6.4399159],
                    zoom: 9.5,
                    speed: 0.9,
                });
            }
        });

        map.on("mouseleave", "fill-kec-layer", () => {
            if (hoveredId !== null) {
                map.setFeatureState(
                    {
                        source: "batas-kec",
                        id: hoveredId,
                    },
                    {
                        hover: false,
                    }
                );
            }
            hoveredId = null;
        });

        map.on("mousemove", "fill-desa-layer", (e) => {
            if (!lastKecamatan) return;

            const feature = e.features[0];
            const subDistrict = feature.properties.sub_district.toUpperCase();

            if (subDistrict !== lastKecamatan.toUpperCase()) return;

            if (hoveredDesaId !== null) {
                map.setFeatureState(
                    {
                        source: "batas-desa",
                        id: hoveredDesaId,
                    },
                    {
                        hover: false,
                    }
                );
            }

            hoveredDesaId = feature.id;

            map.setFeatureState(
                {
                    source: "batas-desa",
                    id: hoveredDesaId,
                },
                {
                    hover: true,
                }
            );
        });

        map.on("mouseleave", "fill-desa-layer", () => {
            if (hoveredDesaId !== null) {
                map.setFeatureState(
                    {
                        source: "batas-desa",
                        id: hoveredDesaId,
                    },
                    {
                        hover: false,
                    }
                );
            }
            hoveredDesaId = null;
        });

        map.addSource("batas-kab", {
            type: "geojson",
            data: kabupaten,
        });

        map.addLayer({
            id: "batas-kab-layer",
            type: "line",
            source: "batas-kab",
            layout: {
                "line-join": "round",
                "line-cap": "round",
            },
            paint: {
                "line-color": "#616161",
                "line-width": 1,
            },
        });

        renderMarkers();

        // Hover saat mouse bergerak di atas fill-kec-layer
        map.on("mousemove", "fill-kec-layer", (e) => {
            if (e.features.length > 0) {
                const feature = e.features[0];
                const id = feature.id;

                if (hoveredId !== null && hoveredId !== id) {
                    map.setFeatureState(
                        {
                            source: "batas-kec",
                            id: hoveredId,
                        },
                        {
                            hover: false,
                        }
                    );
                }

                hoveredId = id;

                map.setFeatureState(
                    {
                        source: "batas-kec",
                        id: hoveredId,
                    },
                    {
                        hover: true,
                    }
                );
            }
        });

        // Hapus hover jika mouse keluar dari layer
        map.on("mouseleave", "fill-kec-layer", () => {
            if (hoveredId !== null) {
                map.setFeatureState(
                    {
                        source: "batas-kec",
                        id: hoveredId,
                    },
                    {
                        hover: false,
                    }
                );
            }
            hoveredId = null;
        });
    });

    function getColorByKomoditas(komoditas) {
        switch (komoditas.toLowerCase()) {
            case "udang":
                return "red";
            case "rumput laut":
                return "green";
            case "ikan bandeng":
                return "blue";
            case "ikan gurame":
                return "orange";
            case "ikan lele":
                return "purple";
            case "ikan nila":
                return "brown";
            default:
                return "gray";
        }
    }

    let markers = [];

    function aggregateKomoditasByKecamatan(lokasi, selectedKomoditas) {
        const result = {};

        lokasi.forEach((item) => {
            if (
                selectedKomoditas.includes(item.jenis_komoditas.toLowerCase())
            ) {
                const key = item.kecamatan;
                if (!result[key]) {
                    result[key] = {
                        total: 0,
                        komoditas: item.jenis_komoditas,
                        lat: item.latitude,
                        lng: item.longitude,
                    };
                }
                result[key].total += 1;
            }
        });

        return result;
    }

    function renderMarkers() {
        clearTimeout(renderTimeout);
        renderTimeout = setTimeout(() => {
            // Hapus semua marker
            markers.forEach((marker) => marker.remove());
            markers = [];

            const selectedKomoditas = Array.from(
                document.querySelectorAll(".komoditas-filter:checked")
            ).map((cb) => cb.value.toLowerCase());

            lokasi.forEach((item) => {
                if (
                    selectedKomoditas.includes(
                        item.jenis_komoditas.toLowerCase()
                    )
                ) {
                    const el = document.createElement("div");
                    el.style.width = "20px";
                    el.style.height = "20px";
                    el.style.backgroundColor = getColorByKomoditas(
                        item.jenis_komoditas
                    );
                    el.style.borderRadius = "50%";
                    el.style.border = "2px solid #ffffff";
                    el.style.cursor = "pointer";

                    // Gunakan background image langsung
                    el.style.backgroundImage = `url(${getIconByKomoditas(
                        item.jenis_komoditas
                    )})`;
                    el.style.backgroundSize = "contain";
                    el.style.backgroundPosition = "center";
                    el.style.backgroundRepeat = "no-repeat";

                    // Ambil gambar pertama jika ada beberapa gambar
                    const gambar = Array.isArray(
                        JSON.parse(item.gambar || "[]")
                    )
                        ? JSON.parse(item.gambar)[0]
                        : item.gambar;
                    const gambarUrl = gambar
                        ? `apk_gis/public/storage/images/${gambar}`
                        : "/storage/images/default.png";

                    const marker = new mapboxgl.Marker({
                        element: el,
                        anchor: "center",
                    })
                        .setLngLat([item.longitude, item.latitude])
                        .setPopup(
                            new mapboxgl.Popup().setHTML(`
                                    <div style="max-width: 300px;">
                                        <img src="${gambarUrl}" alt="${item.jenis_komoditas}" style="max-width: 20%; height: auto; border-radius: 5px; margin-bottom: 10px;">

                                        <!-- Informasi -->
                                        <strong>Jenis Komoditas: ${item.jenis_komoditas}</strong><br>
                                        Kecamatan: ${item.kecamatan}<br>
                                        Desa: ${item.desa}<br>
                                        Alamat: ${item.alamat}<br>
                                        Telepon: ${item.telepon}<br>
                                        
                                        <!-- Tombol Detail -->
                                        <a href="/produk/${item.id}/detail" class="btn-detail" style="display: inline-block; margin-top: 10px; padding: 5px 10px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px;">Lihat Detail</a>
                                    </div>
                                `)
                        )
                        .addTo(map);

                    markers.push(marker);
                }
            });
        }, 100);
    }

    // Fungsi untuk mendapatkan warna fill berdasarkan komoditas
    function getColorByKomoditas(komoditas) {
        switch (komoditas.toLowerCase()) {
            case "udang":
                return "#E16E00"; // Oranye terang (mirip warna udang)
            case "rumput laut":
                return "#32CD32"; // Hijau limau (mirip warna rumput laut)
            case "ikan bandeng":
                return "#1E90FF"; // Biru cerah (mirip warna ikan bandeng)
            case "ikan gurame":
                return "#A9A9A9"; // Abu-abu sedang (mirip warna ikan gurame)
            case "ikan lele":
                return "#696969"; // Abu-abu gelap (mirip warna ikan lele)
            case "ikan nila":
                return "#DAA520"; // Goldenrod (mirip warna ikan nila)
            default:
                return "#FFFFFF"; // Putih sebagai fallback
        }
    }

    // Fungsi untuk mendapatkan path icon lokal berdasarkan komoditas
    function getIconByKomoditas(komoditas) {
        const basePath = "apk_gis/public/images/";
        switch (komoditas.toLowerCase()) {
            case "udang":
                return `${basePath}udang.png`;
            case "rumput laut":
                return `${basePath}rumputlaut.png`;
            case "ikan bandeng":
                return `${basePath}bandeng.png`;
            case "ikan gurame":
                return `${basePath}gurame.png`;
            case "ikan lele":
                return `${basePath}lele.png`;
            case "ikan nila":
                return `${basePath}nila.png`;
            default:
                return `${basePath}default.png`;
        }
    }

    // Event listener checkbox komoditas
    document.querySelectorAll(".komoditas-filter").forEach((cb) => {
        cb.addEventListener("change", () => {
            // Kalau semua dicentang manual -> centang "Pilih Semua"
            const allChecked = Array.from(
                document.querySelectorAll(".komoditas-filter")
            ).every((cb) => cb.checked);
            document.getElementById("select-all").checked = allChecked;

            renderMarkers();
        });
    });

    // Event listener Pilih Semua
    document
        .getElementById("select-all")
        .addEventListener("change", function () {
            const checked = this.checked;
            document
                .querySelectorAll(".komoditas-filter")
                .forEach((cb) => (cb.checked = checked));
            renderMarkers();
        });
});

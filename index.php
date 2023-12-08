<!DOCTYPE html>
<html>
<head>
    <title>Lugares de Interés Turístico en Terra de Soneira</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css">
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <style>
        .popup-content {
            max-width: 500px;
        }
        img{
            max-height: 80px;
        }
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        #map {
            height: 80vh;
        }
        #buttons {
            margin-top: 10px;
        }
        button {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div id="map"></div>
    <div id="buttons">
        <button onclick="filterMarkers('Camariñas')">Camariñas</button>
        <button onclick="filterMarkers('Vimianzo')">Vimianzo</button>
        <button onclick="filterMarkers('Zas')">Zas</button>
        <button onclick="showAllMarkers()">Mostrar Todos</button>
    </div>

    <script>
        var map = L.map('map').setView([43.102324, -9.0707226], 12);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
        }).addTo(map);

        var geojsonLayer;

        function agregarMarcador(lat, lng, name, description, image) {
            var marker = L.marker([lat, lng]).addTo(map);
            marker.bindPopup('<div class="popup-content"><b>' + name + '</b><br>' + description + '<br><img src="' + image + '" alt=" "></div>');
        }

        function filterMarkers(municipality) {
            map.eachLayer(function (layer) {
                if (layer instanceof L.Marker) {
                    map.removeLayer(layer);
                }
            });

            geojsonLayer.eachLayer(function (layer) {
                var properties = layer.feature.properties;
                if (properties.municipality === municipality) {
                    agregarMarcador(layer._latlng.lat, layer._latlng.lng, properties.name, properties.description, properties.image);
                }
            });
        }

        function showAllMarkers() {
            map.eachLayer(function (layer) {
                if (layer instanceof L.Marker) {
                    map.removeLayer(layer);
                }
            });

            geojsonLayer.eachLayer(function (layer) {
                var properties = layer.feature.properties;
                agregarMarcador(layer._latlng.lat, layer._latlng.lng, properties.name, properties.description, properties.image);
            });
        }

        // Cargar datos de GeoJSON desde un archivo
        fetch('lugares_interes.geojson')
            .then(response => response.json())
            .then(data => {
                geojsonLayer = L.geoJSON(data).addTo(map);
            })
            .catch(error => {
                console.error('Error loading GeoJSON:', error);
            });
    </script>
</body>
</html>

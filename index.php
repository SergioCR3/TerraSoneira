<!DOCTYPE html>
<html>
<head>
    <title>Lugares de Interés Turístico en Terra de Soneira</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="home.css">

</head>
<body>
    <div id="header">
        <h1 class="display-4">Soneira Tour</h1>
    </div>
    <nav class="navbar navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand">Lugares de Interés</a>
            <div class="btn-group">
                <button class="btn btn-secondary" onclick="filterMarkers('Camariñas')">Camariñas</button>
                <button class="btn btn-secondary" onclick="filterMarkers('Vimianzo')">Vimianzo</button>
                <button class="btn btn-secondary" onclick="filterMarkers('Zas')">Zas</button>
                <button class="btn btn-secondary" onclick="showAllMarkers()">Mostrar Todos</button>
            </div>
        </div>
    </nav>
    <div id="map"></div>

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

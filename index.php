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
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        #map {
            height: 100vh;
        }
    </style>
</head>
<body>
    <div id="map"></div>

    <script>
        function agregarMarcador(lat, lng, name, description) {
            var marker = L.marker([lat, lng]).addTo(map);
            marker.bindPopup('<b>' + name + '</b><br>' + description);
        }

        var map = L.map('map').setView([43.102324, -9.0707226], 12); // Cambia las coordenadas al centro de Terra de Soneira.

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
        }).addTo(map);

        // Cargar datos de GeoJSON desde un archivo
fetch('lugares_interes.geojson')
    .then(response => response.json())
    .then(data => {
        L.geoJSON(data, {
            pointToLayer: function (feature, latlng) {
                return L.marker(latlng).on('click', function () {
                    let popupContent = '<b>No data</b>'; // Mensaje predeterminado

                    if (feature.properties && feature.properties.name) {
                        popupContent = '<b>' + feature.properties.name + '</b>';
                    }

                    if (feature.properties && feature.properties.description) {
                        popupContent += '<br>' + feature.properties.description;
                    }

                    this.bindPopup(popupContent).openPopup();
                });
            }
        }).addTo(map);
    })
    .catch(error => {
        console.error('Error loading GeoJSON:', error);
    });    </script>
</body>
</html>
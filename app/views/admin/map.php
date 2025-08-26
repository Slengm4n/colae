<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Mapa de Quadras</title>
    <style>
        body { font-family: sans-serif; margin: 0; }
        h1 { text-align: center; padding: 20px; }
        /* Garante que o mapa ocupe um bom espaço na tela */
        #map { height: 80vh; width: 100%; }
    </style>
</head>
<body>
    <h1>Mapa de Quadras Cadastradas</h1>
    <div id="map"></div>

    <script>
        // Passa os dados das quadras do PHP para o JavaScript
        const venues = <?php echo json_encode($venuesWithCoords); ?>;

        function initMap() {
            // Define a localização inicial do mapa (ex: centro de São Paulo)
            const mapCenter = { lat: -23.550520, lng: -46.633308 };
            
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 12,
                center: mapCenter,
            });

            // Cria um marcador no mapa para cada quadra
            venues.forEach(venue => {
                const marker = new google.maps.Marker({
                    position: { 
                        lat: parseFloat(venue.latitude), 
                        lng: parseFloat(venue.longitude) 
                    },
                    map: map,
                    title: venue.name, // Nome que aparece ao passar o rato
                });
            });
        }
    </script>

    <!-- Carrega a API do Google Maps, chamando a nossa função initMap quando estiver pronta -->
    <!-- Lembre-se de substituir SUA_CHAVE_DE_API_VAI_AQUI pela sua chave -->
    <script async
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBQWIOMMnTnuoKmr9Qkvkfkaif45pzTSoE&callback=initMap">
    </script>
</body>
</html>

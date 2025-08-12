
        // Criar mapa (posição inicial genérica)
        var map = L.map('mapaId').setView([51.505, -0.09], 13);

        // Adicionar camada do OpenStreetMap
       L.tileLayer('https://cartodb-basemaps-a.global.ssl.fastly.net/light_all/{z}/{x}/{y}{r}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/">CARTO</a>',
    subdomains: 'abcd',
    maxZoom: 19
    }).addTo(map);

        // Tentativa de pegar localização do usuário
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function (pos) {
                    var lat = pos.coords.latitude;
                    var lng = pos.coords.longitude;

                    // Centralizar no usuário
                    map.setView([lat, lng], 15);

                    // Adicionar marcador
                    L.marker([lat, lng]).addTo(map)
                        .bindPopup("Você está aqui!")
                        .openPopup();
                },
                function (err) {
                    console.warn("Erro ao obter localização:", err);
                }
            );
        } else {
            alert("Geolocalização não suportada pelo seu navegador.");
        }
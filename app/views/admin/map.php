<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Mapa de Quadras - Kolaê</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans flex flex-col h-screen">

    <header class="bg-white shadow-md z-20">
        <nav class="container mx-auto px-6 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <a href="#" class="text-xl font-bold text-gray-800">Kolaê Admin</a>
                <a href="<?php echo BASE_URL; ?>/admin" class="text-gray-600 hover:text-blue-500">Dashboard</a>
                <a href="<?php echo BASE_URL; ?>/admin/usuarios" class="text-gray-600 hover:text-blue-500">Usuários</a>
                <a href="<?php echo BASE_URL; ?>/admin/esportes" class="text-gray-600 hover:text-blue-500">Esportes</a>
                <a href="<?php echo BASE_URL; ?>/admin/mapa" class="font-bold text-blue-600">Mapa</a> </div>
            <div>
                <a href="<?php echo BASE_URL; ?>/logout" class="text-red-500 hover:text-red-700 font-semibold">Sair</a>
            </div>
        </nav>
    </header>

    <main class="flex-grow relative">
        
        <div class="absolute top-4 left-1/2 -translate-x-1/2 z-10 w-full max-w-lg px-4">
            <div class="relative bg-white rounded-lg shadow-lg">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" /></svg>
                </div>
                <input type="text" id="venue-search-input" placeholder="Buscar pelo nome da quadra..." class="block w-full rounded-lg border-0 bg-white py-3 pl-10 pr-3 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-500 sm:text-sm">
                <div id="venue-search-results" class="absolute mt-1 w-full bg-white rounded-lg shadow-lg z-20 hidden"></div>
            </div>
        </div>
        
        <div id="map" class="w-full h-full"></div>

        <div id="venue-sidebar" class="absolute top-0 right-0 h-full w-full max-w-sm bg-white shadow-lg p-6 transform transition-transform duration-300 ease-in-out translate-x-full z-10">
            <button id="close-sidebar-btn" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <div>
                <img id="venue-image" src="" alt="Foto da quadra" class="w-full h-48 object-cover rounded-lg mb-4 bg-gray-200">
                <h2 id="venue-name" class="text-2xl font-bold text-gray-800"></h2>
                <p id="venue-address" class="text-gray-600 mt-2"></p>
                <a id="venue-details-link" href="#" class="mt-6 inline-block w-full text-center bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg">
                    Ver Mais Detalhes
                </a>
            </div>
        </div>

    </main>

    <script>
        const venues = <?php echo json_encode($venuesWithCoords); ?>;

        function initMap() {
            const mapCenter = { lat: -23.5430, lng: -46.3110 };
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 12,
                center: mapCenter,
                disableDefaultUI: true,
                zoomControl: true,
            });

            const sidebar = document.getElementById('venue-sidebar');
            const closeBtn = document.getElementById('close-sidebar-btn');
            const venueImage = document.getElementById('venue-image');
            const venueName = document.getElementById('venue-name');
            const venueAddress = document.getElementById('venue-address');
            const venueLink = document.getElementById('venue-details-link');
            const searchInput = document.getElementById('venue-search-input');
            const searchResultsContainer = document.getElementById('venue-search-results');
            
            closeBtn.addEventListener('click', () => {
                sidebar.classList.add('translate-x-full');
            });

            const bounds = new google.maps.LatLngBounds();
            const markers = []; 

            venues.forEach(venue => {
                const position = { lat: parseFloat(venue.latitude), lng: parseFloat(venue.longitude) };
                
                const marker = new google.maps.Marker({
                    position: position,
                    map: map,
                    title: venue.name,
                });
                
                marker.venueData = venue;
                markers.push(marker);

                bounds.extend(position);

                marker.addListener('click', () => {
                    const uploadBasePath = "<?php echo BASE_URL; ?>/public/uploads/venues/";
                    if (venue.image_path) {
                        venueImage.src = `${uploadBasePath}${venue.id}/${venue.image_path}`;
                    } else {
                        venueImage.src = 'https://via.placeholder.com/400x200.png?text=Sem+Imagem';
                    }
                    venueName.textContent = venue.name;
                    venueAddress.textContent = `${venue.street}, ${venue.number} - ${venue.city}`;
                    venueLink.href = `<?php echo BASE_URL; ?>/quadras/editar/${venue.id}`;
                    sidebar.classList.remove('translate-x-full');
                });
            });

            if (venues.length > 0) {
                map.fitBounds(bounds);
            }
            
            searchInput.addEventListener('input', () => {
                const searchTerm = searchInput.value.toLowerCase().trim();
                searchResultsContainer.innerHTML = '';

                if (searchTerm.length === 0) {
                    searchResultsContainer.classList.add('hidden');
                    return;
                }

                const filteredVenues = venues.filter(venue => venue.name.toLowerCase().includes(searchTerm));

                if (filteredVenues.length > 0) {
                    searchResultsContainer.classList.remove('hidden');
                    filteredVenues.forEach(venue => {
                        const resultItem = document.createElement('div');
                        resultItem.className = 'p-3 hover:bg-gray-100 cursor-pointer';
                        resultItem.textContent = venue.name;
                        
                        resultItem.addEventListener('click', () => {
                            const targetMarker = markers.find(m => m.venueData.id === venue.id);
                            if (targetMarker) {
                                map.setCenter(targetMarker.getPosition());
                                map.setZoom(16);
                                google.maps.event.trigger(targetMarker, 'click');
                            }
                            searchInput.value = venue.name;
                            searchResultsContainer.classList.add('hidden');
                        });
                        
                        searchResultsContainer.appendChild(resultItem);
                    });
                } else {
                    searchResultsContainer.classList.add('hidden');
                }
            });
        }
    </script>

    <?php require_once BASE_PATH . '/config.php'; ?>
    <script async src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_MAPS_API_KEY; ?>&callback=initMap"></script>
</body>
</html>
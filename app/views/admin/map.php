<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mapa de Locais - Kolae Admin</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome (para ícones) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            -webkit-font-smoothing: antialiased;
        }
    </style>
</head>

<body class="bg-[#0D1117] text-gray-200">

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside id="sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen bg-[#161B22] border-r border-gray-800 flex flex-col transition-transform -translate-x-full md:translate-x-0">
            <!-- Botão de Fechar para Mobile -->
            <button id="sidebar-close-btn" class="md:hidden absolute top-4 right-4 text-gray-500 hover:text-white">
                <i class="fas fa-times text-2xl"></i>
            </button>

            <div class="p-6 text-center border-b border-gray-800">
                <div class="w-24 h-24 rounded-full bg-gray-700 mx-auto flex items-center justify-center mb-4">
                    <i class="fas fa-user-shield text-4xl text-cyan-400"></i>
                </div>
                <h2 class="text-xl font-bold">
                    <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Admin'); ?>
                </h2>
                <p class="text-sm text-gray-400">Admin Kolae</p>
            </div>
            <nav class="flex-1 px-4 py-6 space-y-2">
                <a href="<?php echo BASE_URL; ?>/admin" class="flex items-center gap-4 px-4 py-3 text-sm font-semibold text-gray-400 hover:bg-gray-700/50 hover:text-white rounded-lg transition-colors"><i class="fas fa-home w-5 text-center"></i><span>Início</span></a>
                <a href="<?php echo BASE_URL; ?>/admin/usuarios" class="flex items-center gap-4 px-4 py-3 text-sm font-semibold text-gray-400 hover:bg-gray-700/50 hover:text-white rounded-lg transition-colors"><i class="fas fa-users w-5 text-center"></i><span>Usuários</span></a>
                <a href="<?php echo BASE_URL; ?>/admin/esportes" class="flex items-center gap-4 px-4 py-3 text-sm font-semibold text-gray-400 hover:bg-gray-700/50 hover:text-white rounded-lg transition-colors"><i class="fas fa-running w-5 text-center"></i><span>Esportes</span></a>
                <a href="<?php echo BASE_URL; ?>/admin/mapa" class="flex items-center gap-4 px-4 py-3 text-sm font-semibold bg-cyan-500/10 text-cyan-400 rounded-lg"><i class="fas fa-map-marker-alt w-5 text-center"></i><span>Mapa</span></a>
            </nav>
            <div class="p-4 border-t border-gray-800">
                <a href="http://localhost/colae/logout" class="flex items-center gap-4 px-4 py-3 text-sm font-semibold text-red-400 hover:bg-red-500/10 rounded-lg transition-colors"><i class="fas fa-sign-out-alt w-5 text-center"></i><span>Sair</span></a>
            </div>
        </aside>
        
        <!-- Overlay para fechar o menu em mobile -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black/60 z-30 hidden md:hidden"></div>

        <!-- Main Content -->
        <main class="md:ml-64 flex-1 relative">
            <div id="map" class="w-full h-full"></div>

            <!-- Mobile Top Bar: Menu + Search -->
            <div class="md:hidden absolute top-0 left-0 z-10 w-full p-4">
                <div class="flex items-center gap-3">
                    <!-- Botão Hamburger -->
                    <button id="sidebar-toggle" class="flex-shrink-0 text-white bg-black/40 p-3 rounded-lg backdrop-blur-sm shadow-lg">
                        <i class="fas fa-bars text-lg"></i>
                    </button>
                    <!-- Search Bar Mobile -->
                    <div class="relative flex-grow">
                        <div class="relative bg-[#161B22] border border-gray-700 rounded-lg shadow-lg">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <i class="fas fa-search text-gray-500"></i>
                            </div>
                            <input type="text" placeholder="Buscar local..." class="venue-search-input block w-full rounded-lg border-0 bg-transparent py-3 pl-10 pr-3 text-gray-200 placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-cyan-500 sm:text-sm">
                            <div class="venue-search-results absolute mt-1 w-full bg-[#161B22] border border-gray-700 rounded-lg shadow-lg z-20 hidden"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Desktop Search Bar -->
            <div class="hidden md:block absolute top-6 left-1/2 -translate-x-1/2 z-10 w-full max-w-md px-4">
                <div class="relative bg-[#161B22] border border-gray-700 rounded-lg shadow-lg">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <i class="fas fa-search text-gray-500"></i>
                    </div>
                    <input type="text" placeholder="Buscar pelo nome do local..." class="venue-search-input block w-full rounded-lg border-0 bg-transparent py-3 pl-10 pr-3 text-gray-200 placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-cyan-500 sm:text-sm">
                    <div class="venue-search-results absolute mt-1 w-full bg-[#161B22] border border-gray-700 rounded-lg shadow-lg z-20 hidden"></div>
                </div>
            </div>

            <!-- Venue Info Sidebar -->
            <div id="venue-sidebar" class="absolute top-0 right-0 h-full w-full sm:max-w-sm bg-[#161B22] shadow-lg p-6 transform transition-transform duration-300 ease-in-out translate-x-full z-20 border-l border-gray-800">
                <button id="close-sidebar-btn" class="absolute top-4 right-4 text-gray-500 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                <div>
                    <img id="venue-image" src="" alt="Foto do local" class="w-full h-48 object-cover rounded-lg mb-4 bg-gray-800">
                    <h2 id="venue-name" class="text-2xl font-bold text-white"></h2>
                    <p id="venue-address" class="text-gray-400 mt-2"></p>
                    <a id="venue-details-link" href="#" class="mt-6 inline-block w-full text-center bg-cyan-500 hover:bg-cyan-400 text-black font-bold py-3 px-4 rounded-lg transition-colors">
                        Ver Mais Detalhes
                    </a>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Os dados dos locais serão injetados aqui pelo PHP
        const venues = <?php echo json_encode($venuesWithCoords ?? []); ?>;

        function initMap() {
            const mapCenter = {
                lat: -23.5430,
                lng: -46.3110
            }; // Centro Padrão

            // Estilo do Mapa Escuro e Limpo
            const mapStyle = [{ elementType: "geometry", stylers: [{ color: "#242f3e" }] }, { elementType: "labels.text.stroke", stylers: [{ color: "#242f3e" }] }, { elementType: "labels.text.fill", stylers: [{ color: "#746855" }] }, { featureType: "administrative.locality", elementType: "labels.text.fill", stylers: [{ color: "#d59563" }] }, { featureType: "road", elementType: "geometry", stylers: [{ color: "#38414e" }] }, { featureType: "road", elementType: "geometry.stroke", stylers: [{ color: "#212a37" }] }, { featureType: "road", elementType: "labels.text.fill", stylers: [{ color: "#9ca5b3" }] }, { featureType: "road.highway", elementType: "geometry", stylers: [{ color: "#746855" }] }, { featureType: "road.highway", elementType: "geometry.stroke", stylers: [{ color: "#1f2835" }] }, { featureType: "road.highway", elementType: "labels.text.fill", stylers: [{ color: "#f3d19c" }] }, { featureType: "water", elementType: "geometry", stylers: [{ color: "#17263c" }] }, { featureType: "water", elementType: "labels.text.fill", stylers: [{ color: "#515c6d" }] }, { featureType: "water", elementType: "labels.text.stroke", stylers: [{ color: "#17263c" }] }, { featureType: "poi", elementType: "all", stylers: [{ "visibility": "off" }] }, { featureType: "transit", elementType: "all", stylers: [{ "visibility": "off" }] }];

            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 12,
                center: mapCenter,
                disableDefaultUI: true,
                zoomControl: true,
                styles: mapStyle
            });

            const sidebar = document.getElementById('venue-sidebar');
            const closeBtn = document.getElementById('close-sidebar-btn');
            const venueImage = document.getElementById('venue-image');
            const venueName = document.getElementById('venue-name');
            const venueAddress = document.getElementById('venue-address');
            const venueLink = document.getElementById('venue-details-link');

            closeBtn.addEventListener('click', () => {
                sidebar.classList.add('translate-x-full');
            });

            const bounds = new google.maps.LatLngBounds();
            const markers = [];

            venues.forEach(venue => {
                const position = {
                    lat: parseFloat(venue.latitude),
                    lng: parseFloat(venue.longitude)
                };

                const marker = new google.maps.Marker({
                    position: position,
                    map: map,
                    title: venue.name,
                    icon: {
                        path: google.maps.SymbolPath.CIRCLE,
                        scale: 8,
                        fillColor: "#38BDF8", // Cyan-400
                        fillOpacity: 1,
                        strokeWeight: 2,
                        strokeColor: "#0D1117"
                    }
                });

                marker.venueData = venue;
                markers.push(marker);
                bounds.extend(position);

                marker.addListener('click', () => {
                    const uploadBasePath = "<?php echo BASE_URL; ?>/public/uploads/venues/";
                    if (venue.image_path) {
                        venueImage.src = `${uploadBasePath}${venue.id}/${venue.image_path}`;
                    } else {
                        venueImage.src = 'https://placehold.co/400x200/161B22/E0E0E0?text=Sem+Imagem';
                    }
                    venueName.textContent = venue.name;
                    venueAddress.textContent = `${venue.street}, ${venue.number} - ${venue.city}`;
                    venueLink.href = `<?php echo BASE_URL; ?>/admin/quadras/editar/${venue.id}`;
                    sidebar.classList.remove('translate-x-full');
                });
            });

            if (venues.length > 0) {
                map.fitBounds(bounds);
            }

            // --- LÓGICA DE BUSCA ATUALIZADA ---
            const searchInputs = document.querySelectorAll('.venue-search-input');

            searchInputs.forEach(input => {
                const resultsContainer = input.nextElementSibling;
                
                input.addEventListener('input', () => {
                    const searchTerm = input.value.toLowerCase().trim();
                    resultsContainer.innerHTML = '';

                    if (searchTerm.length === 0) {
                        resultsContainer.classList.add('hidden');
                        return;
                    }

                    const filteredVenues = venues.filter(venue => venue.name.toLowerCase().includes(searchTerm));

                    if (filteredVenues.length > 0) {
                        resultsContainer.classList.remove('hidden');
                        filteredVenues.forEach(venue => {
                            const resultItem = document.createElement('div');
                            resultItem.className = 'p-3 hover:bg-gray-700/50 cursor-pointer text-sm';
                            resultItem.textContent = venue.name;

                            resultItem.addEventListener('click', () => {
                                const targetMarker = markers.find(m => m.venueData.id === venue.id);
                                if (targetMarker) {
                                    map.setCenter(targetMarker.getPosition());
                                    map.setZoom(16);
                                    google.maps.event.trigger(targetMarker, 'click');
                                }
                                input.value = venue.name;
                                resultsContainer.classList.add('hidden');
                            });

                            resultsContainer.appendChild(resultItem);
                        });
                    } else {
                        resultsContainer.classList.add('hidden');
                    }
                });
            });
            
            // Listener para fechar os resultados ao clicar fora
             document.addEventListener('click', (event) => {
                searchInputs.forEach(input => {
                    const resultsContainer = input.nextElementSibling;
                    if (!input.contains(event.target) && !resultsContainer.contains(event.target)) {
                        resultsContainer.classList.add('hidden');
                    }
                });
            });
        }
        
        document.addEventListener('DOMContentLoaded', () => {
            // Sidebar Script
            const mainSidebar = document.getElementById('sidebar');
            const toggleBtn = document.getElementById('sidebar-toggle');
            const sidebarCloseBtn = document.getElementById('sidebar-close-btn');
            const overlay = document.getElementById('sidebar-overlay');

            function openSidebar() {
                mainSidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            }

            function closeSidebar() {
                mainSidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }

            if (toggleBtn && sidebarCloseBtn && overlay) {
                toggleBtn.addEventListener('click', openSidebar);
                sidebarCloseBtn.addEventListener('click', closeSidebar);
                overlay.addEventListener('click', closeSidebar);
            }
        });
    </script>

    <?php 
    // Garante que a constante BASE_PATH está definida antes de usar.
    if (!defined('BASE_PATH')) {
        define('BASE_PATH', dirname(__DIR__, 2)); 
    }
    require_once BASE_PATH . '/config.php'; 
    ?>
    <script async src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_MAPS_API_KEY; ?>&callback=initMap"></script>
</body>

</html>


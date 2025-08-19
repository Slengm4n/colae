<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encontre Partidas</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #map { height: 70vh; }
        .user-marker .pulse {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #3388ff;
            position: relative;
        }
        .user-marker .pulse:after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(1); opacity: 1; }
            70% { transform: scale(3); opacity: 0; }
            100% { transform: scale(1); opacity: 0; }
        }
        .room-marker div {
            background: white;
            border-radius: 50%;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            border: 2px solid #333;
        }
        .room-marker.futebol div { background: #4CAF50; color: white; }
        .room-marker.basquete div { background: #FF5722; color: white; }
        .room-marker.tenis div { background: #2196F3; color: white; }
    </style>
</head>
<body>
    <nav class="navbar bg-primary navbar-dark">
        <div class="container">
            <span class="navbar-brand">Partidas Esportivas</span>
            <button id="create-room-btn" class="btn btn-light" disabled onclick="openCreateRoomModal()">
                Criar Partida
            </button>
        </div>
    </nav>
    
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        Filtros
                    </div>
                    <div class="card-body">
                        <select class="form-select mb-3" id="modality-filter">
                            <option value="">Todas Modalidades</option>
                            <option value="futebol">Futebol</option>
                            <option value="basquete">Basquete</option>
                            <option value="tenis">Tênis</option>
                        </select>
                        <input type="range" class="form-range" id="distance-range" min="1" max="50" value="10">
                        <p>Raio: <span id="distance-value">10</span> km</p>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div id="map"></div>
            </div>
        </div>
    </div>
    
    <!-- Modal Criar Sala -->
    <div class="modal fade" id="createRoomModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Criar Nova Partida</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="create-room-form">
                        <div class="mb-3">
                            <label class="form-label">Modalidade</label>
                            <select class="form-select" name="modality_id" required>
                                <option value="1">Futebol</option>
                                <option value="2">Basquete</option>
                                <option value="3">Tênis</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Título</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Descrição</label>
                            <textarea class="form-control" name="description"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Data</label>
                                <input type="date" class="form-control" name="start_date" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Hora</label>
                                <input type="time" class="form-control" name="start_time" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Máximo de Jogadores</label>
                            <input type="number" class="form-control" name="max_players" min="2" max="50" value="10">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="createRoom()">Criar Partida</button>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/scripts/Map.js"></script>
</body>
</html>
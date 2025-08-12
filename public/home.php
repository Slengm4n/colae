<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <title>Mapa com Leaflet</title>
    <style>
        #mapaId {
            height: 700px;
            width: 700px;
            border: solid 1px black;
        }
    </style>
</head>
<body>

    <h1>Mapa com Leaflet</h1>
    <div id="mapaId"></div>

    <form action="../services/logout.php">
        <button>Logout</button>
    </form>
<script src="../assets/scripts/Map.js"></script>
</body>
</html>

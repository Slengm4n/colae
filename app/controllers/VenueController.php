
<?php
require_once __DIR__ . '/../models/Venue.php';
require_once __DIR__ . '/../core/AuthHelper.php';

class VenueController
{

    public function index()
    {
        AuthHelper::check();
        $venues = Venue::getAll();
        require BASE_PATH . '/app/views/venues/index.php';
    }

    public function create()
    {
        AuthHelper::check();
        // Carrega os esportes e comodidades para os checkboxes do formulário
        //$sports = Sport::getAllActive(); // Você precisará criar este método no Sport model
        //$amenities = Amenity::getAll(); // Você precisará criar o Amenity model e este método
        require BASE_PATH . '/app/views/venues/create.php';
    }

    public function store()
    {
        AuthHelper::check();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'user_id' => $_SESSION['user_id'],
                'name' => $_POST['name'],
                'description' => $_POST['description'],
                'address' => $_POST['address'],
                'average_price_per_hour' => $_POST['average_price_per_hour'],
                'court_capacity' => $_POST['court_capacity'],
                'leisure_area_capacity' => $_POST['leisure_area_capacity'],
                'floor_type' => $_POST['floor_type'],
                'is_covered' => $_POST['is_covered']
            ];

            //if (Venue::create($data)) {
                header('Location: ' . BASE_URL . '/quadras');
                exit;
            } else {
                echo "Erro ao criar quadra";
            }
        }

    public function edit($id)
    {
        AuthHelper::check();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $venues = new Venue();
            $venues->id = $_POST['id'];
            $venues->name = htmlspecialchars($_POST['name']);
            $venues->description = htmlspecialchars($_POST['description']);
            $venues->address = htmlspecialchars($_POST['address']);
            $venues->price_per_hour = htmlspecialchars($_POST['price_per_hour']);
            $venues->court_capacity = htmlspecialchars($_POST['court_capacity']);
            $venues->play_area_capacity = htmlspecialchars($_POST['play_area_capacity']);
            $venues->floor_type = htmlspecialchars($_POST['floor_type']);
            $venues->is_covered = htmlspecialchars($_POST['is_covered']);

            if ($venues->update()) {
                header('Locaiton: /colae/quadras');
                exit;
            } else {
                header('Location: /colae/esportes/editar/');
                exit;
            }
        }
    }

    public function delete($id)
    {
        AuthHelper::check();
        if (Venue::delete($id)) {
            header("Location: /colae/quadras");
            exit;
        } else {
            echo "Erro ao excluir quadra";
        }
    }
}

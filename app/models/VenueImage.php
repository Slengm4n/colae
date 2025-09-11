<?php
require_once __DIR__ . '/../core/Database.php';

class VenueImage
{
    /**
     * Salva o caminho de uma imagem no banco de dados, associado a uma quadra.
     * @param int $venueId O ID da quadra.
     * @param string $filePath O caminho do arquivo da imagem.
     * @return bool
     */
    public static function create($venueId, $filePath)
    {
        $pdo = Database::getConnection();
        $query = "INSERT INTO venue_images (venue_id, file_path) VALUES (:venue_id, :file_path)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':venue_id', $venueId);
        $stmt->bindParam(':file_path', $filePath);
        return $stmt->execute();
    }
}

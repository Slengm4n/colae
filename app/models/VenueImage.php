<?php
// Em app/models/VenueImage.php

require_once __DIR__ . '/../core/Database.php';

class VenueImage
{
    /**
     * Salva o caminho de uma imagem no banco de dados, associando-a a uma quadra.
     */
    public static function create($venueId, $filePath)
    {
        $pdo = Database::getConnection();
        $sql = "INSERT INTO venue_images (venue_id, file_path) VALUES (:venue_id, :file_path)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':venue_id', $venueId, PDO::PARAM_INT);
        $stmt->bindParam(':file_path', $filePath);
        return $stmt->execute();
    }
}
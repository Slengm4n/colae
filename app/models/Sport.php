<?php

namespace App\Models;

use App\Core\Database;
use PDO;

/**
 * Class Sport
 * Gerencia todas as operações de banco de dados para a entidade de desporto.
 */
class Sport
{
    /**
     * Conta o total de desportos ativos.
     * @return int
     */
    public static function countAll(): int
    {
        $pdo = Database::getConnection();
        $query = "SELECT COUNT(id) FROM sports WHERE status = 'active'";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }

    /**
     * Busca todos os desportos ATIVOS.
     * @return array
     */
    public static function getAll(): array
    {
        $pdo = Database::getConnection();
        // --- CORREÇÃO AQUI ---
        // Adicionamos o filtro para buscar apenas desportos com status 'active'.
        $query = "SELECT * FROM sports WHERE status = 'active' ORDER BY name ASC";
        // --- FIM DA CORREÇÃO ---
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Busca um desporto específico pelo seu ID.
     * @param int $id
     * @return mixed
     */
    public static function findById(int $id)
    {
        $pdo = Database::getConnection();
        $query = "SELECT * FROM sports WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Cria um novo desporto no banco de dados.
     * @param array $data
     * @return bool
     */
    public static function create(array $data): bool
    {
        $pdo = Database::getConnection();
        $data['status'] = 'active'; // Define um status padrão
        $query = "INSERT INTO sports (name, icon, status) VALUES (:name, :icon, :status)";
        $stmt = $pdo->prepare($query);
        return $stmt->execute($data);
    }

    /**
     * Atualiza um desporto existente.
     * @param int $id
     * @param array $data
     * @return bool
     */
    public static function update(int $id, array $data): bool
    {
        if (empty($data)) {
            return true;
        }

        $pdo = Database::getConnection();
        $fields = [];
        foreach (array_keys($data) as $key) {
            $fields[] = "$key = :$key";
        }
        $query = "UPDATE sports SET " . implode(', ', $fields) . " WHERE id = :id";

        $stmt = $pdo->prepare($query);

        // --- CORREÇÃO AQUI ---
        // Adicionamos o ID ao array de dados antes de executar a query.
        $data['id'] = $id;
        // --- FIM DA CORREÇÃO ---

        return $stmt->execute($data);
    }

    /**
     * Realiza um "soft delete" de um desporto.
     * @param int $id
     * @return bool
     */
    public static function delete(int $id): bool
    {
        return self::update($id, ['status' => 'inactive']);
    }
}

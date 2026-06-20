<?php
/**
 * AutoHub LK — Base Model
 * All models extend this to get a PDO instance.
 */

class Model
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Execute a prepared statement and return all rows.
     */
    protected function fetchAll(string $sql, array $params = []): array
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Execute a prepared statement and return one row.
     */
    protected function fetchOne(string $sql, array $params = []): array|false
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch();
    }

    /**
     * Execute a prepared statement (INSERT/UPDATE/DELETE) and return affected rows.
     */
    protected function execute(string $sql, array $params = []): int
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->rowCount();
    }

    /**
     * Get the last inserted ID.
     */
    protected function lastInsertId(): string
    {
        return $this->db->lastInsertId();
    }

    /**
     * Count rows matching a query.
     */
    protected function count(string $sql, array $params = []): int
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return (int) $stmt->fetchColumn();
    }
}

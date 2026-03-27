<?php
namespace App\Core;

/**
 * Base Model
 * Provides common database operations via PDO
 */
class Model {
    protected $db;
    protected $table;

    public function __construct() {
        $this->db = \Database::getInstance()->getConnection();
    }

    /**
     * Find a record by ID
     */
    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM `{$this->table}` WHERE `id` = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Find all records
     */
    public function findAll($orderBy = 'id', $direction = 'DESC') {
        $stmt = $this->db->query("SELECT * FROM `{$this->table}` ORDER BY `{$orderBy}` {$direction}");
        return $stmt->fetchAll();
    }

    /**
     * Find records by a specific column
     */
    public function findBy($column, $value) {
        $stmt = $this->db->prepare("SELECT * FROM `{$this->table}` WHERE `{$column}` = :value");
        $stmt->execute(['value' => $value]);
        return $stmt->fetchAll();
    }

    /**
     * Find a single record by a specific column
     */
    public function findOneBy($column, $value) {
        $stmt = $this->db->prepare("SELECT * FROM `{$this->table}` WHERE `{$column}` = :value LIMIT 1");
        $stmt->execute(['value' => $value]);
        return $stmt->fetch();
    }

    /**
     * Insert a new record
     */
    public function create($data) {
        $columns = implode('`, `', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $sql = "INSERT INTO `{$this->table}` (`{$columns}`) VALUES ({$placeholders})";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($data);

        return $this->db->lastInsertId();
    }

    /**
     * Update a record by ID
     */
    public function update($id, $data) {
        $setClause = [];
        foreach ($data as $key => $value) {
            $setClause[] = "`{$key}` = :{$key}";
        }
        $setClause = implode(', ', $setClause);

        $sql = "UPDATE `{$this->table}` SET {$setClause} WHERE `id` = :id";
        $data['id'] = $id;

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    /**
     * Delete a record by ID
     */
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM `{$this->table}` WHERE `id` = :id");
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Count all records
     */
    public function count($where = null, $params = []) {
        $sql = "SELECT COUNT(*) as total FROM `{$this->table}`";
        if ($where) {
            $sql .= " WHERE {$where}";
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch();
        return $result['total'];
    }

    /**
     * Custom query execution
     */
    public function query($sql, $params = []) {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    /**
     * Paginated results
     */
    public function paginate($page = 1, $perPage = null, $where = null, $params = [], $orderBy = 'id DESC') {
        $perPage = $perPage ?: ITEMS_PER_PAGE;
        $offset = ($page - 1) * $perPage;

        $countSql = "SELECT COUNT(*) as total FROM `{$this->table}`";
        $dataSql = "SELECT * FROM `{$this->table}`";

        if ($where) {
            $countSql .= " WHERE {$where}";
            $dataSql .= " WHERE {$where}";
        }

        $dataSql .= " ORDER BY {$orderBy} LIMIT {$perPage} OFFSET {$offset}";

        $countStmt = $this->db->prepare($countSql);
        $countStmt->execute($params);
        $total = $countStmt->fetch()['total'];

        $dataStmt = $this->db->prepare($dataSql);
        $dataStmt->execute($params);
        $data = $dataStmt->fetchAll();

        return [
            'data'        => $data,
            'total'       => $total,
            'per_page'    => $perPage,
            'current_page'=> $page,
            'last_page'   => ceil($total / $perPage),
        ];
    }
}

<?php

use App\Core\Model;

class CheatSheet extends Model {
    protected $table = 'cheat_sheets';

    /**
     * Get all cheat sheets grouped by language and category
     */
    public function getGroupedCheatSheets() {
        $stmt = $this->db->query("SELECT * FROM {$this->table} ORDER BY language, category, difficulty");
        $sheets = $stmt->fetchAll();
        
        $grouped = [];
        foreach ($sheets as $sheet) {
            $grouped[$sheet['language']][$sheet['category']][] = $sheet;
        }
        
        return $grouped;
    }

    /**
     * Get distinct programming languages available
     */
    public function getLanguages() {
        $stmt = $this->db->query("SELECT DISTINCT language FROM {$this->table} ORDER BY language");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}

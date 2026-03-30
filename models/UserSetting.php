<?php

use App\Core\Model;

class UserSetting extends Model {
    protected $table = 'user_settings';

    /**
     * Get all settings for a specific user as a key-value associative array
     */
    public function getSettings($userId) {
        $stmt = $this->db->prepare("SELECT setting_key, setting_value FROM {$this->table} WHERE user_id = ?");
        $stmt->execute([$userId]);
        $rows = $stmt->fetchAll();
        
        $settings = [];
        foreach ($rows as $row) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
        return $settings;
    }

    /**
     * Get a specific setting for a user
     */
    public function getSetting($userId, $key, $default = null) {
        $stmt = $this->db->prepare("SELECT setting_value FROM {$this->table} WHERE user_id = ? AND setting_key = ? LIMIT 1");
        $stmt->execute([$userId, $key]);
        $row = $stmt->fetch();
        
        return $row ? $row['setting_value'] : $default;
    }

    /**
     * Save or update a setting for a user
     */
    public function saveSetting($userId, $key, $value) {
        // Upsert behavior using ON DUPLICATE KEY UPDATE
        $stmt = $this->db->prepare("
            INSERT INTO {$this->table} (user_id, setting_key, setting_value) 
            VALUES (?, ?, ?) 
            ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)
        ");
        return $stmt->execute([$userId, $key, $value]);
    }
}

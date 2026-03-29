<?php

use App\Core\Model;

class PlaygroundSnippet extends Model {
    protected $table = 'playground_snippets';

    /**
     * Get the user's latest saved snippet
     * For now, each user only gets 1 main scratchpad workspace (their latest)
     */
    public function getUserSnippet($userId) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE user_id = ? ORDER BY updated_at DESC LIMIT 1");
        $stmt->execute([$userId]);
        return $stmt->fetch();
    }

    /**
     * Save or update the user's snippet
     */
    public function saveSnippet($userId, $html, $css, $js) {
        $existing = $this->getUserSnippet($userId);
        
        if ($existing) {
            $stmt = $this->db->prepare("UPDATE {$this->table} SET html_code = ?, css_code = ?, js_code = ?, updated_at = NOW() WHERE id = ?");
            return $stmt->execute([$html, $css, $js, $existing['id']]);
        } else {
            $stmt = $this->db->prepare("INSERT INTO {$this->table} (user_id, title, html_code, css_code, js_code) VALUES (?, ?, ?, ?, ?)");
            return $stmt->execute([$userId, 'My Playground', $html, $css, $js]);
        }
    }
}

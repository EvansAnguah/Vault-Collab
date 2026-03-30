<?php

use App\Core\Controller;
use App\Core\Auth;
use App\Core\Session;

class SettingsController extends Controller {

    public function __construct() {
        parent::__construct();
        require_once BASE_PATH . '/models/UserSetting.php';
    }

    /**
     * Display the settings page
     */
    public function index() {
        $userId = Auth::id();
        $settingModel = new \UserSetting();
        $settings = $settingModel->getSettings($userId);

        // Define default settings if they don't exist
        $defaults = [
            'email_notifications' => '1',
            'dark_mode' => '0',
            'show_email_to_students' => '1'
        ];

        // Merge defaults with existing settings
        $userSettings = array_merge($defaults, $settings);

        $this->view('settings/index', [
            'pageTitle' => 'System Settings',
            'settings' => $userSettings
        ], 'app');
    }

    /**
     * Handle updating preferences
     */
    public function update() {
        $this->validateCsrf();
        
        $userId = Auth::id();
        $settingModel = new \UserSetting();

        // Checkboxes are only sent via POST if they are checked
        $emailNotif = isset($_POST['email_notifications']) ? '1' : '0';
        $darkMode = isset($_POST['dark_mode']) ? '1' : '0';
        $showEmail = isset($_POST['show_email_to_students']) ? '1' : '0';

        // Upsert the values
        $settingModel->saveSetting($userId, 'email_notifications', $emailNotif);
        $settingModel->saveSetting($userId, 'dark_mode', $darkMode);
        $settingModel->saveSetting($userId, 'show_email_to_students', $showEmail);

        $this->redirectWithMessage('/settings', 'success', 'Preferences saved successfully.');
    }
}

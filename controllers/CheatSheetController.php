<?php

use App\Core\Controller;

class CheatSheetController extends Controller {

    public function __construct() {
        parent::__construct();
        require_once BASE_PATH . '/models/CheatSheet.php';
    }

    /**
     * Display categorized cheat sheets
     */
    public function index() {
        $model = new \CheatSheet();
        
        $groupedSheets = $model->getGroupedCheatSheets();
        $languages = $model->getLanguages();

        $this->view('learning/cheat-sheets', [
            'pageTitle' => 'Cheat Sheets',
            'groupedSheets' => $groupedSheets,
            'languages' => $languages
        ], 'app');
    }
}

<?php

use App\Core\Controller;
use App\Core\Auth;

class PlaygroundController extends Controller {

    public function __construct() {
        parent::__construct();
        require_once BASE_PATH . '/models/PlaygroundSnippet.php';
    }

    /**
     * Display the CodeEditor/Playground interface
     */
    public function index() {
        $userId = Auth::id();
        $model = new \PlaygroundSnippet();
        
        $snippet = $model->getUserSnippet($userId);

        $this->view('playground/index', [
            'pageTitle' => 'Code Playground',
            'snippet' => $snippet,
            'isAppContainer' => false // Signal to layout not to restrict width, we want immersive IDE
        ], 'app');
    }

    /**
     * AJAX endpoint to save code snippet
     */
    public function save() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->json(['success' => false, 'message' => 'Invalid method'], 405);
        }

        $userId = Auth::id();
        $html = $this->postData('html_code', '');
        $css = $this->postData('css_code', '');
        $js = $this->postData('js_code', '');

        $model = new \PlaygroundSnippet();
        $saved = $model->saveSnippet($userId, $html, $css, $js);

        if ($saved) {
            return $this->json(['success' => true, 'message' => 'Workspace saved successfully']);
        }

        return $this->json(['success' => false, 'message' => 'Failed to save workspace'], 500);
    }
}

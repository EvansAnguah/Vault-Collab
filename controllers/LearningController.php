<?php

use App\Core\Controller;
use App\Core\Auth;

class LearningController extends Controller {

    public function __construct() {
        parent::__construct();
        require_once BASE_PATH . '/models/LearningResource.php';
        require_once BASE_PATH . '/models/Department.php';
    }

    /**
     * Display rich video tutorial learning resources
     */
    public function index() {
        $user = Auth::user();
        if (!$user) {
            $this->redirect('/login');
        }

        $deptId = $user['department_id'] ?? null;
        $deptName = 'General Studies';

        if ($deptId) {
            $deptModel = new \Department();
            $deptInfo = $deptModel->findById($deptId);
            if ($deptInfo) {
                $deptName = $deptInfo['name'];
            }
        }

        $model = new \LearningResource();
        $resources = $model->getResourcesForDepartment($deptId);

        $this->view('learning/resources', [
            'pageTitle' => 'Learning Resources',
            'resources' => $resources,
            'departmentName' => $deptName
        ], 'app');
    }
}

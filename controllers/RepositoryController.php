<?php

use App\Core\Controller;
use App\Core\Auth;
use App\Core\Session;

class RepositoryController extends Controller {

    public function __construct() {
        parent::__construct();
        require_once BASE_PATH . '/models/Repository.php';
        require_once BASE_PATH . '/models/RepoFile.php';
        require_once BASE_PATH . '/models/User.php';
        require_once BASE_PATH . '/models/Group.php';
    }

    /**
     * Workspace Dashboard (File Explorer & Editor)
     */
    public function workspace($id) {
        $repoModel = new \Repository();
        $repo = $repoModel->getWithDetails($id);

        if (!$repo) {
            $this->redirectWithMessage('/dashboard', 'error', 'Repository not found.');
            return;
        }

        // Access Check: Is user in the group or assigned supervisor?
        $userId = Auth::id();
        $groupModel = new \Group();
        $members = $groupModel->getMembers($repo['group_id']);
        $isInGroup = false;
        foreach ($members as $m) if ($m['id'] == $userId) $isInGroup = true;

        if (!$isInGroup && $repo['supervisor_id'] != $userId && Auth::role() != 'admin' && Auth::role() != 'hod') {
            $this->redirectWithMessage('/dashboard', 'error', 'You do not have access to this workspace.');
            return;
        }

        // Project must have a supervisor for students to enter
        if ($isInGroup && !$repo['supervisor_id'] && Auth::role() == 'student') {
            $this->redirectWithMessage('/dashboard', 'warning', 'Workspace is pending supervisor assignment by the HOD. Please wait.');
            return;
        }

        $fileModel = new \RepoFile();
        $fileTree = $fileModel->getTree($id);

        $this->view('repository/workspace', [
            'pageTitle' => 'Workspace: ' . $repo['title'],
            'repository' => $repo,
            'fileTree' => $fileTree,
            'members' => $members
        ], 'app');
    }

    /**
     * Get File Content (AJAX)
     */
    public function viewFile($repoId, $fileId) {
        $fileModel = new \RepoFile();
        $file = $fileModel->getWithDetails($fileId);

        if ($file && $file['repo_id'] == $repoId) {
            $this->json([
                'success' => true,
                'file' => $file
            ]);
        } else {
            $this->json(['success' => false, 'message' => 'File not found.']);
        }
    }

    /**
     * Save File Content (AJAX)
     */
    public function saveFile() {
        $this->validateCsrf();
        $fileId = $this->postData('file_id');
        $content = $this->postData('content');
        $repoId = $this->postData('repo_id');

        $fileModel = new \RepoFile();
        $file = $fileModel->find($fileId);

        if ($file && $file['repo_id'] == $repoId) {
            $data = [
                'content' => $content,
                'last_modified_by' => Auth::id()
            ];
            
            if ($fileModel->update($fileId, $data)) {
                // Also create a version record if you want history
                $this->db->prepare("INSERT INTO file_versions (file_id, content, version_number, changed_by) VALUES (?, ?, ?, ?)")
                         ->execute([$fileId, $content, 1, Auth::id()]);
                
                $this->json(['success' => true]);
            } else {
                $this->json(['success' => false, 'message' => 'Save failed.']);
            }
        } else {
            $this->json(['success' => false, 'message' => 'Unauthorized.']);
        }
    }

    /**
     * Create File/Folder (AJAX)
     */
    public function createFile() {
        $this->validateCsrf();
        $repoId = $this->postData('repo_id');
        $parentId = $this->postData('parent_id') ?: null;
        $name = $this->postData('name');
        $type = $this->postData('type'); // file or folder

        if (empty($name)) {
            $this->json(['success' => false, 'message' => 'Name required.']);
            return;
        }

        $fileModel = new \RepoFile();
        $id = $fileModel->create([
            'repo_id' => $repoId,
            'parent_id' => $parentId,
            'name' => $name,
            'type' => $type,
            'created_by' => Auth::id(),
            'content' => $type == 'file' ? '' : null
        ]);

        if ($id) {
            $this->json(['success' => true, 'id' => $id]);
        } else {
            $this->json(['success' => false, 'message' => 'Creation failed.']);
        }
    }

    /**
     * Rename File
     */
    public function renameFile() {
        $this->validateCsrf();
        $fileId = $this->postData('file_id');
        $newName = $this->postData('name');

        $fileModel = new \RepoFile();
        if ($fileModel->update($fileId, ['name' => $newName])) {
            $this->json(['success' => true]);
        } else {
            $this->json(['success' => false]);
        }
    }

    /**
     * Delete File/Folder
     */
    public function deleteFile() {
        $this->validateCsrf();
        $fileId = $this->postData('file_id');

        $fileModel = new \RepoFile();
        if ($fileModel->delete($fileId)) {
            $this->json(['success' => true]);
        } else {
            $this->json(['success' => false]);
        }
    }

    /**
     * Upload File (AJAX)
     */
    public function uploadFile() {
        $this->validateCsrf();
        $repoId = $this->postData('repo_id');
        $parentId = $this->postData('parent_id') ?: null;
        $file = $_FILES['file'];

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $this->json(['success' => false, 'message' => 'Upload failed.']);
            return;
        }

        // For this project, we'll store binary files in the filesystem 
        // and keep a record in the database.
        $uploadDir = BASE_PATH . '/public/uploads/repos/' . $repoId . '/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

        $fileName = time() . '_' . $file['name'];
        $targetPath = $uploadDir . $fileName;

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            $fileModel = new \RepoFile();
            $id = $fileModel->create([
                'repo_id' => $repoId,
                'parent_id' => $parentId,
                'name' => $file['name'],
                'type' => 'file',
                'file_path' => 'uploads/repos/' . $repoId . '/' . $fileName,
                'mime_type' => $file['type'],
                'file_size' => $file['size'],
                'created_by' => Auth::id()
            ]);
            $this->json(['success' => true, 'id' => $id]);
        } else {
            $this->json(['success' => false, 'message' => 'Move failed.']);
        }
    }

    /**
     * Download entire Repository as ZIP
     */
    public function downloadRepo($id) {
        $repoModel = new \Repository();
        $repo = $repoModel->find($id);

        // Simple placeholder for ZIP logic
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="' . $repo['title'] . '.zip"');
        // Actually generate ZIP here...
        echo "ZIP_CONTENT_PLACEHOLDER";
        exit;
    }

    /**
     * Add Comment to File
     */
    public function addFileComment() {
        $this->validateCsrf();
        $fileId = $this->postData('file_id');
        $line = $this->postData('line_number');
        $comment = $this->postData('comment');

        $this->db->prepare("INSERT INTO file_comments (file_id, user_id, line_number, comment) VALUES (?, ?, ?, ?)")
                 ->execute([$fileId, Auth::id(), $line, $comment]);

        $this->json(['success' => true]);
    }

    /**
     * API: Get File Tree
     */
    public function getFileTree() {
        $repoId = $this->getData('repo_id');
        $fileModel = new \RepoFile();
        $tree = $fileModel->getTree($repoId);
        $this->json(['success' => true, 'tree' => $tree]);
    }
}

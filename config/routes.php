<?php
/**
 * Route Definitions
 * 
 * Format: $router->add('METHOD', '/path', 'Controller@method', ['middleware']);
 */

use App\Core\Router;

$router = Router::getInstance();

// ============================================================
// PUBLIC ROUTES (No authentication required)
// ============================================================

$router->add('GET', '/', 'AuthController@loginPage');
$router->add('GET', '/login', 'AuthController@loginPage');
$router->add('POST', '/login', 'AuthController@login');
$router->add('GET', '/register', 'AuthController@registerPage');
$router->add('POST', '/register', 'AuthController@register');
$router->add('GET', '/verify-email', 'AuthController@verifyEmail');
$router->add('GET', '/verify-account', 'AuthController@verifyAccountPage');
$router->add('POST', '/verify-account', 'AuthController@verifyAccount');
$router->add('GET', '/forgot-password', 'AuthController@forgotPasswordPage');
$router->add('POST', '/forgot-password', 'AuthController@forgotPassword');
$router->add('GET', '/reset-password', 'AuthController@resetPasswordPage');
$router->add('POST', '/reset-password', 'AuthController@resetPassword');
$router->add('GET', '/logout', 'AuthController@logout');
$router->add('GET', '/terms', 'AuthController@terms');

// API: Get programs by department (for dynamic dropdown)
$router->add('GET', '/api/programs', 'AuthController@getPrograms');

// ============================================================
// DASHBOARD ROUTES (Authenticated)
// ============================================================

$router->add('GET', '/dashboard', 'DashboardController@index', ['auth']);

// ============================================================
// ADMIN ROUTES
// ============================================================

$router->add('GET', '/admin/users', 'AdminController@manageUsers', ['admin']);
$router->add('GET', '/admin/create-hod', 'AdminController@createHodPage', ['admin']);
$router->add('POST', '/admin/create-hod', 'AdminController@createHod', ['admin']);
$router->add('GET', '/admin/create-supervisor', 'AdminController@createSupervisorPage', ['admin']);
$router->add('POST', '/admin/create-supervisor', 'AdminController@createSupervisor', ['admin']);
$router->add('GET', '/admin/upload-students', 'AdminController@uploadStudentsPage', ['admin']);
$router->add('POST', '/admin/upload-students', 'AdminController@uploadStudents', ['admin']);
$router->add('GET', '/admin/departments', 'AdminController@departments', ['admin']);
$router->add('POST', '/admin/departments', 'AdminController@createDepartment', ['admin']);
$router->add('POST', '/admin/programs', 'AdminController@createProgram', ['admin']);
$router->add('GET', '/admin/settings', 'AdminController@settings', ['admin']);

// ============================================================
// HOD ROUTES
// ============================================================

$router->add('GET', '/hod/groups', 'HodController@manageGroups', ['hod']);
$router->add('POST', '/hod/create-group', 'HodController@createGroup', ['hod']);
$router->add('GET', '/hod/repo-requests', 'HodController@repoRequests', ['hod']);
$router->add('POST', '/hod/repo-requests/review', 'HodController@reviewRequest', ['hod']);
$router->add('GET', '/hod/assign-supervisor', 'HodController@assignSupervisorPage', ['hod']);
$router->add('POST', '/hod/assign-supervisor', 'HodController@assignSupervisor', ['hod']);
$router->add('GET', '/hod/upload-students', 'HodController@uploadStudentsPage', ['hod']);
$router->add('POST', '/hod/upload-students', 'HodController@uploadStudents', ['hod']);
$router->add('GET', '/hod/archived', 'HodController@archivedProjects', ['hod']);
$router->add('POST', '/hod/archive-project', 'HodController@archiveProject', ['hod']);
$router->add('GET', '/hod/submissions', 'HodController@reviewSubmissions', ['hod']);

// ============================================================
// SUPERVISOR ROUTES
// ============================================================

$router->add('GET', '/supervisor/groups', 'SupervisorController@myGroups', ['supervisor']);
$router->add('GET', '/supervisor/review/{id}', 'SupervisorController@reviewProject', ['supervisor']);
$router->add('POST', '/supervisor/review', 'SupervisorController@submitReview', ['supervisor']);
$router->add('GET', '/supervisor/logbook/{id}', 'SupervisorController@logbookReview', ['supervisor']);
$router->add('POST', '/supervisor/remark', 'SupervisorController@addRemark', ['supervisor']);
$router->add('POST', '/supervisor/notice', 'SupervisorController@postNotice', ['supervisor']);
$router->add('POST', '/supervisor/submit-to-hod', 'SupervisorController@submitToHod', ['supervisor']);

// ============================================================
// STUDENT ROUTES
// ============================================================

$router->add('GET', '/student/group', 'StudentController@myGroup', ['student']);
$router->add('GET', '/student/create-group', 'StudentController@createGroupPage', ['student']);
$router->add('POST', '/student/create-group', 'StudentController@createGroup', ['student']);
$router->add('POST', '/student/add-member', 'StudentController@addMember', ['student']);
$router->add('GET', '/student/request-repo', 'StudentController@requestRepoPage', ['student']);
$router->add('POST', '/student/request-repo', 'StudentController@requestRepo', ['student']);
$router->add('POST', '/student/submit-project', 'StudentController@submitProject', ['student']);

// ============================================================
// REPOSITORY / WORKSPACE ROUTES (Authenticated)
// ============================================================

$router->add('GET', '/workspace/{id}', 'RepositoryController@workspace', ['auth']);
$router->add('GET', '/workspace/{id}/file/{fileId}', 'RepositoryController@viewFile', ['auth']);
$router->add('POST', '/workspace/create-file', 'RepositoryController@createFile', ['auth']);
$router->add('POST', '/workspace/create-folder', 'RepositoryController@createFolder', ['auth']);
$router->add('POST', '/workspace/upload', 'RepositoryController@uploadFile', ['auth']);
$router->add('POST', '/workspace/save-file', 'RepositoryController@saveFile', ['auth']);
$router->add('POST', '/workspace/delete', 'RepositoryController@deleteFile', ['auth']);
$router->add('POST', '/workspace/rename', 'RepositoryController@renameFile', ['auth']);
$router->add('GET', '/workspace/{id}/download', 'RepositoryController@downloadRepo', ['auth']);
$router->add('GET', '/workspace/{id}/chapters', 'RepositoryController@chapters', ['auth']);
$router->add('GET', '/workspace/{id}/logbook', 'LogbookController@index', ['auth']);
$router->add('POST', '/logbook/add', 'LogbookController@addEntry', ['auth']);

// ============================================================
// CHAT & MEETING ROUTES (Authenticated)
// ============================================================

$router->add('GET', '/chat/{groupId}', 'ChatController@index', ['auth']);
$router->add('GET', '/video-call/{groupId}', 'ChatController@videoCall', ['auth']);
$router->add('GET', '/meetings/{repoId}', 'MeetingController@index', ['auth']);
$router->add('POST', '/meetings/schedule', 'MeetingController@schedule', ['auth']);

// ============================================================
// API ENDPOINTS (AJAX)
// ============================================================

$router->add('GET', '/api/chat/messages', 'ChatController@getMessages', ['auth']);
$router->add('POST', '/api/chat/send', 'ChatController@sendMessage', ['auth']);
$router->add('POST', '/api/chat/upload-image', 'ChatController@uploadImage', ['auth']);
$router->add('POST', '/api/chat/upload-voice', 'ChatController@uploadVoice', ['auth']);
$router->add('GET', '/api/notifications', 'NotificationController@getNotifications', ['auth']);
$router->add('POST', '/api/notifications/read', 'NotificationController@markRead', ['auth']);
$router->add('POST', '/api/file-comment', 'RepositoryController@addFileComment', ['auth']);
$router->add('GET', '/api/search-students', 'StudentController@searchStudents', ['auth']);
$router->add('GET', '/api/file-tree', 'RepositoryController@getFileTree', ['auth']);

// ============================================================
// TOOLS ROUTES (Student)
// ============================================================

$router->add('GET', '/playground', 'PlaygroundController@index', ['auth']);
$router->add('POST', '/playground/save', 'PlaygroundController@save', ['auth']);
$router->add('GET', '/cheat-sheets', 'CheatSheetController@index', ['auth']);
$router->add('GET', '/learning', 'LearningController@index', ['auth']);

// ============================================================
// PROFILE & SETTINGS
// ============================================================

$router->add('GET', '/profile', 'ProfileController@index', ['auth']);
$router->add('POST', '/profile/update', 'ProfileController@update', ['auth']);
$router->add('POST', '/profile/upload-photo', 'ProfileController@uploadPhoto', ['auth']);
$router->add('POST', '/profile/change-password', 'ProfileController@changePassword', ['auth']);
$router->add('GET', '/settings', 'SettingsController@index', ['auth']);
$router->add('POST', '/settings/update', 'SettingsController@update', ['auth']);

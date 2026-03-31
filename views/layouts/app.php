<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $metaDescription ?? APP_NAME ?>">
    <meta name="app-url" content="<?= APP_URL ?>">
    <meta name="csrf-token" content="<?= \App\Core\Session::getCsrfToken() ?>">
    
    <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) . ' | ' . APP_NAME : APP_NAME ?></title>
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?= APP_URL ?>/public/css/main.css">
    <link rel="stylesheet" href="<?= APP_URL ?>/public/css/dashboard.css">
    <?php if (isset($extraCss)): ?>
        <?php foreach ((array)$extraCss as $css): ?>
            <link rel="stylesheet" href="<?= APP_URL ?>/public/css/<?= $css ?>">
        <?php endforeach; ?>
    <?php endif; ?>
</head>
<body>
    <?php
    $user = \App\Core\Session::user();
    $flashSuccess = \App\Core\Session::getFlash('success');
    $flashError = \App\Core\Session::getFlash('error');
    $flashInfo = \App\Core\Session::getFlash('info');
    ?>

    <!-- Toast Container -->
    <div id="toast-container" style="position:fixed;top:20px;right:20px;z-index:9999;display:flex;flex-direction:column;gap:10px;max-width:380px;">
        <?php if ($flashSuccess): ?>
            <div class="alert alert-success animate__animated animate__fadeInRight">
                <span>✓</span><span><?= htmlspecialchars($flashSuccess) ?></span>
                <button class="alert-close">×</button>
            </div>
        <?php endif; ?>
        <?php if ($flashError): ?>
            <div class="alert alert-error animate__animated animate__fadeInRight">
                <span>✕</span><span><?= htmlspecialchars($flashError) ?></span>
                <button class="alert-close">×</button>
            </div>
        <?php endif; ?>
        <?php if ($flashInfo): ?>
            <div class="alert alert-info animate__animated animate__fadeInRight">
                <span>ℹ</span><span><?= htmlspecialchars($flashInfo) ?></span>
                <button class="alert-close">×</button>
            </div>
        <?php endif; ?>
    </div>

    <div class="app-layout">
        <!-- Sidebar -->
        <?php include BASE_PATH . '/views/layouts/components/sidebar.php'; ?>

        <!-- Main Content Area -->
        <div class="main-area">
            <!-- Topbar -->
            <?php include BASE_PATH . '/views/layouts/components/topbar.php'; ?>

            <!-- Page Content -->
            <main class="page-content">
                <?= $content ?>
            </main>
        </div>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebar-overlay"></div>

    <!-- Scripts -->
    <script src="<?= APP_URL ?>/public/js/app.js"></script>
    <?php if (isset($extraJs)): ?>
        <?php foreach ((array)$extraJs as $js): ?>
            <script src="<?= APP_URL ?>/public/js/<?= $js ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
    <script>
        lucide.createIcons();

        // Sidebar toggle
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebarOverlay = document.getElementById('sidebar-overlay');
        const mobileToggle = document.getElementById('mobile-sidebar-toggle');

        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('collapsed');
                localStorage.setItem('sidebar_collapsed', sidebar.classList.contains('collapsed'));
            });
        }

        if (mobileToggle) {
            mobileToggle.addEventListener('click', () => {
                sidebar.classList.toggle('mobile-open');
                sidebarOverlay.classList.toggle('active');
            });
        }

        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', () => {
                sidebar.classList.remove('mobile-open');
                sidebarOverlay.classList.remove('active');
            });
        }

        // Restore sidebar state
        if (localStorage.getItem('sidebar_collapsed') === 'true') {
            sidebar?.classList.add('collapsed');
        }
    </script>
</body>
</html>

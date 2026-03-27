<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $metaDescription ?? 'Project Vault & Collaboration Hub - Regional Maritime University' ?>">
    <meta name="app-url" content="<?= APP_URL ?>">
    <meta name="csrf-token" content="<?= \App\Core\Session::getCsrfToken() ?>">
    
    <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) . ' | ' . APP_NAME : APP_NAME ?></title>
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?= APP_URL ?>/public/css/main.css">
    <link rel="stylesheet" href="<?= APP_URL ?>/public/css/auth.css">
    
    <style>
        /* Page-specific inline overrides (if any) */
    </style>
</head>
<body class="auth-page">
    
    <?php
    // Flash Messages
    $flashSuccess = \App\Core\Session::getFlash('success');
    $flashError = \App\Core\Session::getFlash('error');
    $flashInfo = \App\Core\Session::getFlash('info');
    ?>

    <?php if ($flashSuccess): ?>
        <div id="toast-container" style="position:fixed;top:20px;right:20px;z-index:9999;max-width:380px;">
            <div class="alert alert-success animate__animated animate__fadeInRight">
                <span>✓</span>
                <span><?= htmlspecialchars($flashSuccess) ?></span>
                <button class="alert-close">×</button>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($flashError): ?>
        <div id="toast-container" style="position:fixed;top:20px;right:20px;z-index:9999;max-width:380px;">
            <div class="alert alert-error animate__animated animate__fadeInRight">
                <span>✕</span>
                <span><?= htmlspecialchars($flashError) ?></span>
                <button class="alert-close">×</button>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($flashInfo): ?>
        <div id="toast-container" style="position:fixed;top:20px;right:20px;z-index:9999;max-width:380px;">
            <div class="alert alert-info animate__animated animate__fadeInRight">
                <span>ℹ</span>
                <span><?= htmlspecialchars($flashInfo) ?></span>
                <button class="alert-close">×</button>
            </div>
        </div>
    <?php endif; ?>

    <!-- Branding Panel (Left) -->
    <div class="auth-branding">
        <div class="brand-content animate__animated animate__fadeIn">
            <div class="brand-logo">
                <div class="logo-icon">⚓</div>
                <div class="logo-text">
                    <h1>ProjectVault</h1>
                    <span><?= UNIVERSITY_NAME ?></span>
                </div>
            </div>

            <h2>Your Final Year <span>Project Hub</span></h2>
            <p>Collaborate with supervisors, build your project, and submit with confidence.</p>

            <div class="feature-pills">
                <div class="feature-pill animate__animated animate__fadeInUp" style="animation-delay: 0.1s;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><path d="M14 2v6h6"/></svg>
                    Code Editor
                </div>
                <div class="feature-pill animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    Team Collaboration
                </div>
                <div class="feature-pill animate__animated animate__fadeInUp" style="animation-delay: 0.3s;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    Live Chat
                </div>
                <div class="feature-pill animate__animated animate__fadeInUp" style="animation-delay: 0.4s;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15.6 11.6L22 7v10l-6.4-4.5v-1zM4 5h9a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V7c0-1.1.9-2 2-2z"/></svg>
                    Video Meetings
                </div>
                <div class="feature-pill animate__animated animate__fadeInUp" style="animation-delay: 0.5s;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                    Code Playground
                </div>
                <div class="feature-pill animate__animated animate__fadeInUp" style="animation-delay: 0.6s;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                    Cheat Sheets
                </div>
            </div>
        </div>
    </div>

    <!-- Form Panel (Right) -->
    <div class="auth-form-panel <?= isset($panelClass) ? $panelClass : '' ?>">
        <div class="auth-form-container animate__animated animate__fadeInRight">
            <?= $content ?>
        </div>
    </div>

    <!-- Terms & Conditions Modal -->
    <div class="modal-overlay terms-modal" id="terms-modal">
        <div class="modal">
            <div class="modal-header">
                <h3>Terms & Conditions</h3>
                <button class="modal-close">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>
            <div class="modal-body">
                <h4>1. Acceptance of Terms</h4>
                <p>By registering for and using the <?= APP_NAME ?>, you agree to comply with these Terms and Conditions. This platform is exclusively for students, supervisors, and staff of the <?= UNIVERSITY_NAME ?>.</p>

                <h4>2. Account Responsibilities</h4>
                <ul>
                    <li>You must use your official university email (@st.rmu.edu.gh) for registration.</li>
                    <li>You are responsible for maintaining the security of your account credentials.</li>
                    <li>Sharing accounts or credentials is strictly prohibited.</li>
                    <li>All information provided must be accurate and truthful.</li>
                </ul>

                <h4>3. Academic Integrity</h4>
                <ul>
                    <li>All work submitted must be original and your own.</li>
                    <li>Plagiarism in any form will not be tolerated.</li>
                    <li>Proper citations must be given when using external resources.</li>
                </ul>

                <h4>4. Usage Guidelines</h4>
                <ul>
                    <li>The platform must be used solely for academic project purposes.</li>
                    <li>Uploading malicious code or files is strictly prohibited.</li>
                    <li>Communication through the platform must be professional and respectful.</li>
                    <li>Do not upload copyrighted materials without proper authorization.</li>
                </ul>

                <h4>5. Data & Privacy</h4>
                <ul>
                    <li>Your project data is stored securely and accessible only to authorized users.</li>
                    <li>Archived projects are accessible only to HODs and system administrators.</li>
                    <li>The university reserves the right to access any content for academic review purposes.</li>
                </ul>

                <h4>6. Termination</h4>
                <p>The university reserves the right to suspend or terminate accounts that violate these terms without prior notice.</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" data-modal-close>I Understand</button>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="<?= APP_URL ?>/public/js/app.js"></script>
    <script src="<?= APP_URL ?>/public/js/auth.js"></script>
    <script>lucide.createIcons();</script>
</body>
</html>

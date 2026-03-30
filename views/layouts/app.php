<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Vault & Collab' ?> | Project Management</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    
    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0969da',
                        secondary: '#f6f8fa',
                        accent: '#1a7f37',
                        background: '#ffffff',
                        surface: '#f9fafb',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        heading: ['Outfit', 'sans-serif'],
                    },
                    boxShadow: {
                        'soft': '0 4px 20px rgba(0, 0, 0, 0.05)',
                        'premium': '0 10px 50px rgba(0, 0, 0, 0.08)',
                    }
                }
            }
        }
    </script>
    
    <style type="text/tailwindcss">
        @layer base {
            body { @apply bg-surface text-gray-900 antialiased font-sans; }
            h1, h2, h3, h4 { @apply font-heading font-bold text-gray-900; }
        }
        @layer components {
            .btn-nav { @apply flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 font-medium text-sm; }
            .btn-nav:hover { @apply bg-gray-100 text-primary translate-x-1; }
            .btn-nav.active { @apply bg-primary text-white shadow-lg shadow-primary/20 translate-x-1; }
            .glass-card { @apply bg-white/80 backdrop-blur-md border border-white/20 shadow-premium rounded-3xl; }
            .card-premium { @apply bg-white border border-gray-100 shadow-soft hover:shadow-premium transition-all duration-500 rounded-3xl p-6; }
        }
    </style>
</head>
<body class="bg-gray-50">

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-72 bg-white border-r border-gray-100 fixed h-full z-50 transition-all duration-500 overflow-y-auto overflow-x-hidden">
            <div class="p-8 flex items-center gap-3">
                <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center shadow-lg shadow-primary/30">
                    <i class="fa-solid fa-layer-group text-white text-xl"></i>
                </div>
                <span class="text-xl font-bold tracking-tight font-heading">Vault Hub</span>
            </div>
            
            <div class="px-6 py-4">
                <div class="text-[10px] uppercase font-bold text-gray-400 tracking-widest mb-6 px-4">Workspace Core</div>
                <nav class="space-y-2">
                    <a href="<?= APP_URL ?>/dashboard" class="btn-nav <?= active_route('/dashboard') ? 'active' : '' ?>">
                        <i class="fa-solid fa-chart-pie text-lg"></i> Dashboard
                    </a>
                    
                    <?php if (App\Core\Auth::role() == 'student'): ?>
                        <a href="<?= APP_URL ?>/student/group" class="btn-nav <?= active_route('/student/group') ? 'active' : '' ?>">
                            <i class="fa-solid fa-users-rectangle text-lg"></i> My Research Group
                        </a>
                        <a href="<?= APP_URL ?>/student/request-repo" class="btn-nav <?= active_route('/student/request-repo') ? 'active' : '' ?>">
                            <i class="fa-solid fa-code-pull-request text-lg"></i> New Project Repo
                        </a>
                    <?php endif; ?>

                    <?php if (App\Core\Auth::role() == 'hod'): ?>
                        <a href="<?= APP_URL ?>/hod/groups" class="btn-nav <?= active_route('/hod/groups') ? 'active' : '' ?>">
                            <i class="fa-solid fa-building-columns text-lg"></i> Research Registry
                        </a>
                        <a href="<?= APP_URL ?>/hod/repo-requests" class="btn-nav <?= active_route('/hod/repo-requests') ? 'active' : '' ?>">
                            <i class="fa-solid fa-clipboard-check text-lg"></i> Proposals
                        </a>
                        <a href="<?= APP_URL ?>/hod/submissions" class="btn-nav <?= active_route('/hod/submissions') ? 'active' : '' ?>">
                            <i class="fa-solid fa-file-export text-lg"></i> Final Submissions
                        </a>
                        <a href="<?= APP_URL ?>/hod/upload-students" class="btn-nav <?= active_route('/hod/upload-students') ? 'active' : '' ?>">
                            <i class="fa-solid fa-upload text-lg"></i> Bulk Manifest
                        </a>
                    <?php endif; ?>

                    <?php if (App\Core\Auth::role() == 'supervisor'): ?>
                        <a href="<?= APP_URL ?>/supervisor/groups" class="btn-nav <?= active_route('/supervisor/groups') ? 'active' : '' ?>">
                            <i class="fa-solid fa-folder-tree text-lg"></i> Assigned Projects
                        </a>
                    <?php endif; ?>

                    <?php if (App\Core\Auth::role() == 'admin'): ?>
                        <a href="<?= APP_URL ?>/admin/users" class="btn-nav <?= active_route('/admin/users') ? 'active' : '' ?>">
                            <i class="fa-solid fa-user-gear text-lg"></i> Identity Registry
                        </a>
                        <a href="<?= APP_URL ?>/admin/departments" class="btn-nav <?= active_route('/admin/departments') ? 'active' : '' ?>">
                            <i class="fa-solid fa-sitemap text-lg"></i> Faculty Structure
                        </a>
                    <?php endif; ?>
                </nav>

                <div class="mt-12 text-[10px] uppercase font-bold text-gray-400 tracking-widest mb-6 px-4">Account Access</div>
                <nav class="space-y-2">
                    <a href="<?= APP_URL ?>/profile" class="btn-nav <?= active_route('/profile') ? 'active' : '' ?>">
                        <i class="fa-solid fa-user-circle text-lg"></i> My Identity
                    </a>
                    <a href="<?= APP_URL ?>/settings" class="btn-nav <?= active_route('/settings') ? 'active' : '' ?>">
                        <i class="fa-solid fa-cog text-lg"></i> Core Preferences
                    </a>
                    <a href="<?= APP_URL ?>/logout" class="btn-nav text-red-500 hover:bg-red-50">
                        <i class="fa-solid fa-right-from-bracket text-lg"></i> Terminate Session
                    </a>
                </nav>
            </div>
            
            <div class="mt-auto p-8">
                <div class="bg-gray-50 rounded-2xl p-4 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary font-bold">
                        <?= strtoupper(substr(App\Core\Auth::user()['first_name'], 0, 1)) ?>
                    </div>
                    <div class="overflow-hidden">
                        <div class="text-sm font-bold truncate"><?= App\Core\Auth::user()['first_name'] ?></div>
                        <div class="text-[10px] uppercase font-bold text-gray-400"><?= App\Core\Auth::role() ?></div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Wrapper -->
        <main class="flex-1 ml-72 p-12 transition-all duration-500">
            <!-- Top Nav Removed / Integrated into Page Content for cleaner look -->
            
            <!-- Page Content -->
            <div id="content" class="animate__animated animate__fadeIn">
                <!-- Flash Messages -->
                <?php if ($success = App\Core\Session::getFlash('success')): ?>
                    <div class="mb-8 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl flex items-center gap-3 animate__animated animate__fadeInDown">
                        <i class="fa-solid fa-check-circle"></i>
                        <span class="text-sm font-medium"><?= $success ?></span>
                    </div>
                <?php endif; ?>

                <?php if ($error = App\Core\Session::getFlash('error')): ?>
                    <div class="mb-8 p-4 bg-rose-50 border border-rose-100 text-rose-700 rounded-2xl flex items-center gap-3 animate__animated animate__fadeInDown">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span class="text-sm font-medium"><?= $error ?></span>
                    </div>
                <?php endif; ?>

                <!-- View Component Injection -->
                <?= $content ?>
            </div>
            
            <footer class="mt-24 py-12 border-t border-gray-100 flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 bg-gray-200 rounded-lg flex items-center justify-center">
                        <i class="fa-solid fa-layer-group text-gray-500 text-[10px]"></i>
                    </div>
                    <span class="text-xs font-bold text-gray-400">Vault & Collab Hub</span>
                </div>
                <p class="text-xs text-gray-400 font-medium uppercase tracking-widest">&copy; <?= date('Y') ?> Regional Maritime University | System Alpha</p>
                <div class="flex items-center gap-4">
                    <a href="#" class="text-gray-300 hover:text-primary transition-colors"><i class="fa-brands fa-github text-lg"></i></a>
                    <a href="#" class="text-gray-300 hover:text-primary transition-colors"><i class="fa-brands fa-discord text-lg"></i></a>
                </div>
            </footer>
        </main>
    </div>

    <!-- Global Scripts -->
    <script>
        AOS.init({
            duration: 800,
            once: true,
            offset: 50,
            easing: 'ease-out-cubic'
        });
    </script>
    <script src="<?= APP_URL ?>/public/js/app.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Secure Access' ?> | Vault Hub</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0969da',
                        secondary: '#f6f8fa',
                        accent: '#1a7f37',
                        background: '#ffffff',
                        surface: '#f3f4f6',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        heading: ['Outfit', 'sans-serif'],
                    },
                    boxShadow: {
                        'premium': '0 10px 50px rgba(0, 0, 0, 0.1)',
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
            .input-premium { @apply w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all outline-none text-sm; }
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-6 overflow-hidden">

    <div class="w-full max-w-md animate__animated animate__fadeInUp">
        <!-- Logo Area -->
        <div class="flex flex-col items-center mb-10 group">
            <div class="w-20 h-20 bg-primary rounded-3xl flex items-center justify-center shadow-xl shadow-primary/30 mb-6 group-hover:scale-110 transition-transform duration-500">
                <i class="fa-solid fa-layer-group text-white text-4xl"></i>
            </div>
            <h1 class="text-3xl font-bold tracking-tight font-heading mb-2">Regional Maritime University</h1>
            <p class="text-gray-400 font-medium uppercase tracking-[0.2em] text-[10px]">Project Vault & Collaboration Hub</p>
        </div>
        
        <!-- Auth Card -->
        <div class="bg-white p-10 rounded-[2.5rem] shadow-premium border border-white relative overflow-hidden">
            <!-- Decorative Gradient -->
            <div class="absolute top-0 right-0 w-24 h-24 bg-primary/5 rounded-full -mr-12 -mt-12"></div>
            
            <div class="relative z-10">
                <!-- Status Messages -->
                <?php if ($success = App\Core\Session::getFlash('success')): ?>
                    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl flex items-center gap-3 animate__animated animate__headShake">
                        <i class="fa-solid fa-check-circle"></i>
                        <span class="text-xs font-medium"><?= $success ?></span>
                    </div>
                <?php endif; ?>

                <?php if ($error = App\Core\Session::getFlash('error')): ?>
                    <div class="mb-6 p-4 bg-rose-50 border border-rose-100 text-rose-700 rounded-2xl flex items-center gap-3 animate__animated animate__headShake">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span class="text-xs font-medium"><?= $error ?></span>
                    </div>
                <?php endif; ?>

                <?= $content ?>
            </div>
        </div>

        <div class="mt-12 text-center">
            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest leading-loose">
                Established for Academic Excellence & Research Integrity <br>
                RMU Systems Division &copy; <?= date('Y') ?>
            </p>
        </div>
    </div>

</body>
</html>

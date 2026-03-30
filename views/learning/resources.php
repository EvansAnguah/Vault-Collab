<div class="mb-12 animate__animated animate__fadeIn">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-8 text-center md:text-left">
        <div>
            <div class="flex items-center gap-3 mb-4 justify-center md:justify-start">
                <a href="<?= APP_URL ?>/dashboard" class="text-[10px] font-bold text-gray-400 uppercase tracking-widest hover:text-primary transition-colors">Registry Hub</a>
                <span class="text-gray-200">/</span>
                <span class="text-primary text-[10px] font-bold uppercase tracking-widest">Academic Knowledge Repository</span>
            </div>
            <h1 class="text-4xl font-heading font-bold tracking-tight text-gray-900 leading-tight">Recommended Learning Artifacts</h1>
        </div>
        <div class="px-6 py-3 bg-white border border-gray-100 rounded-2xl flex items-center gap-3 shadow-soft mx-auto md:mx-0">
            <i class="fa-solid fa-building-columns text-primary"></i>
            <span class="text-[10px] font-bold text-gray-900 uppercase tracking-widest leading-none"><?= e($departmentName) ?></span>
        </div>
    </div>
</div>

<?php if (empty($resources)): ?>
    <div class="card-premium py-32 text-center flex flex-col items-center justify-center animate__animated animate__pulse animate__infinite animate__slower" style="animation-duration: 5s;">
        <div class="w-32 h-32 bg-gray-50 rounded-[3rem] flex items-center justify-center mb-10 text-gray-200 shadow-inner">
            <i class="fa-solid fa-video-slash text-5xl"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 mb-2 font-heading tracking-tight italic uppercase">Queue Empty / No Resources Sync</h3>
        <p class="text-xs text-gray-400 font-medium italic opacity-80 uppercase tracking-widest max-w-sm">No curated learning artifacts have been designated for your faculty division yet.</p>
    </div>
<?php else: ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10" data-aos="fade-up">
        <?php foreach ($resources as $res): ?>
            <div class="card-premium p-0 overflow-hidden shadow-premium group border-none bg-white flex flex-col h-full hover:-translate-y-2 transition-all duration-500">
                <!-- Thumbnail -->
                <div class="relative aspect-video overflow-hidden">
                    <?php 
                        $thumbUrl = $res['thumbnail_url'] ? $res['thumbnail_url'] : 'https://images.unsplash.com/photo-1516116216624-53e697fedbea?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80'; 
                    ?>
                    <img src="<?= e($thumbUrl) ?>" alt="Resource Thumbnail" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center backdrop-blur-[2px]">
                        <div class="w-14 h-14 bg-white/20 rounded-full flex items-center justify-center text-white text-xl border border-white/30 shadow-2xl backdrop-blur-md transition-transform group-hover:scale-110 duration-500">
                            <i class="fa-solid fa-play animate-pulse"></i>
                        </div>
                    </div>
                    <div class="absolute top-4 left-4">
                        <span class="px-4 py-1.5 bg-primary/90 text-white rounded-full text-[8px] font-bold uppercase tracking-widest shadow-lg shadow-primary/20 backdrop-blur-md"><?= e($res['category']) ?></span>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-8 flex-1 flex flex-col">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 font-heading tracking-tight leading-snug group-hover:text-primary transition-colors duration-300"><?= e($res['title']) ?></h3>
                    <?php if ($res['description']): ?>
                        <p class="text-xs text-gray-400 font-medium italic leading-relaxed mb-10 flex-1 opacity-80 border-l-2 border-gray-100 pl-4"><?= e($res['description']) ?></p>
                    <?php endif; ?>
                    
                    <a href="<?= e($res['youtube_url']) ?>" target="_blank" class="w-full py-4 bg-gray-50 border border-gray-100 text-gray-900 rounded-2xl text-[10px] font-bold uppercase tracking-[0.2em] text-center transition-all hover:bg-primary hover:text-white hover:border-primary shadow-soft">
                        Access Knowledge <i class="fa-solid fa-arrow-up-right-from-square ml-3 text-[8px]"></i>
                    </a>
                </div>
                
                <div class="p-4 bg-gray-50/30 border-t border-gray-50 text-center">
                    <span class="text-[8px] font-bold text-gray-300 uppercase tracking-[0.4em]">Faculty Knowledge Protocol Layer</span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

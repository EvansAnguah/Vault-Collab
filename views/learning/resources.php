<style>
.section-header {
    margin-bottom: 2rem;
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
}

.section-header h1 {
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--navy-900);
}

.section-header p {
    color: var(--navy-500);
    margin-top: 0.5rem;
}

.dept-badge {
    background: var(--ocean-blue);
    color: white;
    padding: 8px 16px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.9rem;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

/* Video Grid */
.video-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 2rem;
}

.video-card {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05);
    border: 1px solid var(--navy-100);
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
}

.video-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
}

.video-thumb {
    position: relative;
    width: 100%;
    aspect-ratio: 16/9;
    background: var(--navy-100);
    overflow: hidden;
}

.video-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.video-card:hover .video-thumb img {
    transform: scale(1.05);
}

.play-overlay {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 60px;
    height: 60px;
    background: rgba(2, 6, 23, 0.7);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    opacity: 0;
    transition: opacity 0.3s ease;
    backdrop-filter: blur(4px);
}

.video-card:hover .play-overlay {
    opacity: 1;
}

.video-content {
    padding: 1.5rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.v-category {
    font-size: 0.8rem;
    text-transform: uppercase;
    font-weight: 800;
    color: var(--teal);
    letter-spacing: 1px;
    margin-bottom: 0.5rem;
}

.v-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--navy-900);
    margin-bottom: 0.8rem;
    line-height: 1.4;
}

.v-desc {
    font-size: 0.9rem;
    color: var(--navy-600);
    line-height: 1.5;
    margin-bottom: 1.5rem;
    flex: 1;
}

.v-action {
    display: block;
    width: 100%;
    text-align: center;
    padding: 12px;
    background: var(--navy-50);
    color: var(--ocean-blue);
    font-weight: 700;
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.2s ease;
}

.v-action:hover {
    background: var(--ocean-blue);
    color: white;
}
</style>

<div class="section-header">
    <div>
        <h1><i class="fa-solid fa-graduation-cap"></i> Recommended Resources</h1>
        <p>Curated tutorials and courses mapped to your curriculum.</p>
    </div>
    <div class="dept-badge">
        <i class="fa-solid fa-building-columns"></i> <?= htmlspecialchars($departmentName) ?>
    </div>
</div>

<?php if (empty($resources)): ?>
    <div class="card text-center" style="padding: 4rem;">
        <i class="fa-solid fa-video-slash" style="font-size: 4rem; color: var(--navy-200); margin-bottom: 1rem;"></i>
        <h3>No Resources Found</h3>
        <p class="text-muted">No learning resources have been added for your department yet.</p>
    </div>
<?php else: ?>
    <div class="video-grid">
        <?php foreach ($resources as $res): ?>
            <div class="video-card">
                <div class="video-thumb">
                    <?php 
                        // If no thumbnail, use a placeholder
                        $thumbUrl = $res['thumbnail_url'] ? $res['thumbnail_url'] : 'https://images.unsplash.com/photo-1516116216624-53e697fedbea?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80'; 
                    ?>
                    <img src="<?= htmlspecialchars($thumbUrl) ?>" alt="Thumbnail">
                    <div class="play-overlay"><i class="fa-solid fa-play"></i></div>
                </div>
                <div class="video-content">
                    <div class="v-category"><?= htmlspecialchars($res['category']) ?></div>
                    <h3 class="v-title"><?= htmlspecialchars($res['title']) ?></h3>
                    <?php if ($res['description']): ?>
                        <p class="v-desc"><?= htmlspecialchars($res['description']) ?></p>
                    <?php endif; ?>
                    <a href="<?= htmlspecialchars($res['youtube_url']) ?>" target="_blank" class="v-action">
                        Watch on YouTube <i class="fa-solid fa-arrow-up-right-from-square" style="font-size: 0.8em; margin-left: 5px;"></i>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

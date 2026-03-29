<style>
.section-header {
    margin-bottom: 2rem;
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

/* Cheat Sheet Layout */
.cheat-sheet-nav {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 2rem;
}

.lang-pill {
    padding: 8px 20px;
    background: #fff;
    border: 1px solid var(--navy-200);
    border-radius: 50px;
    color: var(--navy-700);
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.lang-pill.active, .lang-pill:hover {
    background: var(--ocean-blue);
    color: white;
    border-color: var(--ocean-blue);
}

.cheat-grid {
    column-count: 2;
    column-gap: 1.5rem;
}

@media (max-width: 900px) {
    .cheat-grid { column-count: 1; }
}

.cheat-card {
    break-inside: avoid;
    background: #fff;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
    border: 1px solid var(--navy-100);
}

.cheat-category {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--ocean-blue);
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid var(--navy-100);
}

.cheat-item {
    margin-bottom: 1.5rem;
}

.cheat-item:last-child {
    margin-bottom: 0;
}

.cheat-item h4 {
    font-size: 1rem;
    color: var(--navy-900);
    margin-bottom: 0.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.diff-badge {
    font-size: 0.7rem;
    padding: 2px 8px;
    border-radius: 12px;
    text-transform: uppercase;
    font-weight: 700;
}

.diff-beginner { background: #dcfce7; color: #166534; }
.diff-intermediate { background: #fef9c3; color: #854d0e; }
.diff-advanced { background: #fee2e2; color: #991b1b; }

.cheat-item p {
    font-size: 0.9rem;
    color: var(--navy-600);
    margin-bottom: 0.8rem;
}

.code-block {
    background: #1e293b;
    border-radius: 8px;
    padding: 1rem;
    overflow-x: auto;
}

.code-block code {
    font-family: 'Fira Code', 'Consolas', monospace;
    font-size: 0.9rem;
    color: #f8fafc;
}
</style>

<div class="section-header">
    <h1><i class="fa-solid fa-book-open"></i> Quick Syntax Reference</h1>
    <p>A collection of cheat sheets tailored for your technical interviews and coursework.</p>
</div>

<?php if (empty($groupedSheets)): ?>
    <div class="card text-center" style="padding: 4rem;">
        <i class="fa-solid fa-folder-open" style="font-size: 4rem; color: var(--navy-200); margin-bottom: 1rem;"></i>
        <h3>No Cheat Sheets Available</h3>
        <p class="text-muted">No references have been published yet.</p>
    </div>
<?php else: ?>

    <div class="cheat-sheet-nav">
        <!-- Optional: JS could hook into these to filter the masonry grid -->
        <div class="lang-pill active" data-filter="all">All Languages</div>
        <?php foreach ($languages as $lang): ?>
            <div class="lang-pill" data-filter="<?= htmlspecialchars($lang) ?>"><?= htmlspecialchars($lang) ?></div>
        <?php endforeach; ?>
    </div>

    <!-- Grouped by Language -> Category -->
    <?php foreach ($groupedSheets as $language => $categories): ?>
        <div class="language-section" data-language="<?= htmlspecialchars($language) ?>">
            <h2 style="margin-bottom: 1.5rem; color: var(--navy-800); font-weight: 800; font-size: 2rem;">
                <?= htmlspecialchars($language) ?>
            </h2>

            <div class="cheat-grid">
                <?php foreach ($categories as $categoryName => $items): ?>
                    <div class="cheat-card">
                        <div class="cheat-category">
                            <i class="fa-solid fa-code-branch"></i> <?= htmlspecialchars($categoryName) ?>
                        </div>
                        
                        <?php foreach ($items as $item): ?>
                            <div class="cheat-item">
                                <h4>
                                    <?= htmlspecialchars($item['title']) ?>
                                    <span class="diff-badge diff-<?= htmlspecialchars($item['difficulty']) ?>">
                                        <?= htmlspecialchars($item['difficulty']) ?>
                                    </span>
                                </h4>
                                <?php if ($item['description']): ?>
                                    <p><?= htmlspecialchars($item['description']) ?></p>
                                <?php endif; ?>
                                
                                <div class="code-block">
                                    <code><?= htmlspecialchars($item['code']) ?></code>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <hr style="border: 0; border-top: 1px dashed var(--navy-300); margin: 3rem 0;">
    <?php endforeach; ?>

<?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Basic filter logic
    const pills = document.querySelectorAll('.lang-pill');
    const sections = document.querySelectorAll('.language-section');

    pills.forEach(pill => {
        pill.addEventListener('click', () => {
            pills.forEach(p => p.classList.remove('active'));
            pill.classList.add('active');
            
            const filterLang = pill.getAttribute('data-filter');
            
            sections.forEach(section => {
                if (filterLang === 'all' || section.getAttribute('data-language') === filterLang) {
                    section.style.display = 'block';
                } else {
                    section.style.display = 'none';
                }
            });
        });
    });
});
</script>

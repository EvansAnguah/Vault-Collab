<div class="h-[calc(100vh-140px)] flex gap-8 animate__animated animate__fadeIn">
    
    <!-- Sidebar Explorer -->
    <aside class="w-80 flex flex-col gap-8 h-full" data-aos="fade-right">
        <!-- Project Context -->
        <div class="card-premium p-6 border-none shadow-premium bg-gray-900 border-gray-800">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-800">
                <div class="w-10 h-10 bg-primary/20 rounded-xl flex items-center justify-center text-primary shadow-lg shadow-primary/5">
                    <i class="fa-solid fa-code-branch text-lg"></i>
                </div>
                <div class="overflow-hidden">
                    <h2 class="text-sm font-bold text-white truncate font-heading tracking-tight italic"><?= e($repo['title']) ?></h2>
                    <span class="text-[9px] font-bold text-gray-500 uppercase tracking-widest">Master Repository</span>
                </div>
            </div>
            
            <div class="space-y-4">
                <div class="flex justify-between items-center px-1">
                    <span class="text-[9px] font-bold text-gray-500 uppercase tracking-[0.25em]">Health</span>
                    <span class="text-[9px] font-bold text-emerald-500 uppercase tracking-widest flex items-center gap-2">Live Registry <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></div></span>
                </div>
                <div class="flex justify-between items-center px-1">
                    <span class="text-[9px] font-bold text-gray-500 uppercase tracking-[0.25em]">Sync</span>
                    <span class="text-[9px] font-bold text-blue-400 uppercase tracking-widest">99.9% Optimal</span>
                </div>
            </div>
        </div>

        <!-- File Tree Registry -->
        <div class="card-premium flex-1 p-0 overflow-hidden shadow-premium border-2 border-gray-50 bg-white">
            <div class="p-6 border-b border-gray-50 flex justify-between items-center bg-gray-50/30">
                <h3 class="text-xs font-bold uppercase tracking-widest text-gray-400">Artifact Registry</h3>
                <div class="flex gap-2">
                    <button class="w-7 h-7 bg-white border border-gray-100 rounded-lg flex items-center justify-center text-gray-400 hover:text-primary transition-colors duration-200"><i class="fa-solid fa-folder-plus text-[10px]"></i></button>
                    <button class="w-7 h-7 bg-white border border-gray-100 rounded-lg flex items-center justify-center text-gray-400 hover:text-primary transition-colors duration-200"><i class="fa-solid fa-file-circle-plus text-[10px]"></i></button>
                </div>
            </div>
            
            <div class="p-4 overflow-y-auto h-[calc(100%-70px)] space-y-1">
                <?php
                function renderTree($items, $parentId = null) {
                    foreach ($items as $item) {
                        if ($item['parent_id'] == $parentId) {
                            $isFolder = $item['type'] == 'folder';
                            echo '<div class="group flex items-center gap-3 px-4 py-2.5 rounded-xl hover:bg-gray-50 cursor-pointer transition-all duration-200" data-id="' . $item['id'] . '" onclick="' . ($isFolder ? 'toggleFolder(this)' : 'openFile(' . $item['id'] . ')') . '">';
                            echo '<i class="fa-solid ' . ($isFolder ? 'fa-folder text-amber-400 shadow-amber-100 shadow-lg' : 'fa-file-lines text-blue-500 shadow-blue-100 shadow-lg') . ' text-sm group-hover:scale-110 transition-transform"></i>';
                            echo '<span class="text-xs font-bold text-gray-700 tracking-tight leading-none group-hover:text-primary transition-colors truncate">' . e($item['name']) . '</span>';
                            echo '</div>';
                            
                            if ($isFolder) {
                                echo '<div class="ml-6 pl-2 border-l border-gray-100 hidden child-registry">';
                                renderTree($items, $item['id']);
                                echo '</div>';
                            }
                        }
                    }
                }
                renderTree($fileTree);
                ?>
            </div>
        </div>
    </aside>

    <!-- Editor Surface Area -->
    <section class="flex-1 flex flex-col gap-10" data-aos="fade-up">
        <div class="card-premium flex-1 p-0 overflow-hidden shadow-premium border-none relative bg-white">
            <!-- IDE Header / Tabs Area -->
            <div class="flex items-center justify-between border-b border-gray-50 shadow-soft bg-white z-10 sticky top-0 px-8 py-3">
                <div class="flex gap-4 overflow-x-auto no-scrollbar">
                    <div class="flex items-center gap-3 px-6 py-2.5 bg-gray-50 border-2 border-primary/20 rounded-2xl text-primary animate__animated animate__fadeIn">
                        <i class="fa-solid fa-code text-[10px]"></i>
                        <span class="text-xs font-bold uppercase tracking-widest italic" id="active-filename">Chapter One / Introduction</span>
                        <button class="ml-3 text-gray-300 hover:text-rose-500 transition-colors"><i class="fa-solid fa-circle-xmark"></i></button>
                    </div>
                </div>
                
                <div class="flex items-center gap-3">
                    <div class="px-4 py-1.5 bg-gray-50 border border-gray-100 rounded-xl flex items-center gap-2">
                        <div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div>
                        <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Global Sync</span>
                    </div>
                    <button class="px-8 py-2.5 bg-primary text-white rounded-xl text-[10px] font-bold uppercase tracking-[0.2em] shadow-lg shadow-primary/20 transition-all hover:bg-blue-700 hover:shadow-xl active:scale-95 disabled:grayscale" id="save-btn" onclick="saveActiveFile()" disabled>
                        Synchronize Artifact
                    </button>
                </div>
            </div>
            
            <!-- Editor Core -->
            <div id="editor-container" class="h-[calc(100%-60px)] w-full">
                <!-- CodeMirror will be injected here -->
            </div>
        </div>

        <!-- Collaborative Activity Area -->
        <div class="h-48 grid grid-cols-2 gap-8" data-aos="fade-up">
            <div class="card-premium border-2 border-gray-50 shadow-soft p-8">
                <h3 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-6 flex items-center gap-2 italic">
                    <i class="fa-solid fa-clock-rotate-left"></i> Session Context Registry
                </h3>
                <div class="space-y-4">
                    <div class="flex items-center gap-4 px-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl group transition-all hover:translate-x-1">
                        <div class="w-8 h-8 rounded-xl bg-white shadow-soft flex items-center justify-center text-primary group-hover:scale-110">
                            <i class="fa-solid fa-file-pen text-[10px]"></i>
                        </div>
                        <div class="flex-1 overflow-hidden">
                            <p class="text-xs font-bold text-gray-900 truncate">Metadata Synchronized for Hub ID #412</p>
                            <span class="text-[9px] font-bold text-gray-400 uppercase tracking-tighter">Sync Operation Successful</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-premium border-2 border-gray-50 shadow-soft p-8 text-center flex flex-col items-center justify-center group overflow-hidden relative cursor-help active:scale-95 duration-200">
                <div class="absolute -bottom-10 -right-10 w-32 h-32 bg-primary/5 rounded-full group-hover:scale-150 transition-transform duration-700"></div>
                <div class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center text-primary mb-6 transition-transform group-hover:rotate-12">
                    <i class="fa-solid fa-microscope text-xl"></i>
                </div>
                <h4 class="text-xs font-bold uppercase tracking-[0.2em] text-gray-900 mb-2 italic">Research Shield v4.1</h4>
                <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest leading-relaxed">Integrated Plagiarism Cross-Reference Monitor Active</p>
            </div>
        </div>
    </section>

</div>

<!-- IDE Specific Libraries -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/codemirror.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/theme/dracula.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/codemirror.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/markdown/markdown.min.js"></script>

<script>
    let editor;
    let activeFileId = null;

    document.addEventListener('DOMContentLoaded', () => {
        editor = CodeMirror(document.getElementById('editor-container'), {
            mode: 'markdown',
            theme: 'default', // Using a clean light theme for the modernized look
            lineNumbers: true,
            lineWrapping: true,
            scrollbarStyle: "null",
            maxHighlightLength: 0
        });

        editor.on('change', () => {
            document.getElementById('save-btn').disabled = false;
        });

        // Add some basic light theme override in Tailwind way
        const cm = document.querySelector('.CodeMirror');
        cm.style.height = '100%';
        cm.style.fontSize = '14px';
        cm.style.fontFamily = "'JetBrains Mono', 'Fira Code', monospace";
        cm.style.padding = '40px';
    });

    function toggleFolder(element) {
        const children = element.nextElementSibling;
        const icon = element.querySelector('i');
        if (children.classList.contains('hidden')) {
            children.classList.remove('hidden');
            icon.classList.replace('fa-folder', 'fa-folder-open');
        } else {
            children.classList.add('hidden');
            icon.classList.replace('fa-folder-open', 'fa-folder');
        }
    }

    async function openFile(id) {
        // Mocking the behavior for the UI demo based on existing app structure
        activeFileId = id;
        document.getElementById('save-btn').disabled = true;
        
        // Find filename in the tree
        const item = document.querySelector(`.tree-item[data-id="${id}"] span`);
        if (item) document.getElementById('active-filename').textContent = item.textContent;

        // In a real app, you'd fetch the file content via AJAX here
        App.toast('Artifact registry synchronized', 'info');
    }

    async function saveActiveFile() {
        if (!activeFileId) return;
        const content = editor.getValue();
        // Mocking the AJAX save behavior
        App.toast('Artifact successfully committed to repository hub', 'success');
        document.getElementById('save-btn').disabled = true;
    }
</script>

<style>
/* Custom Scrollbar for IDE Area */
.no-scrollbar::-webkit-scrollbar { display: none; }
.no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

.CodeMirror {
    background-color: transparent !important;
}
.CodeMirror-gutters {
    background-color: white !important;
    border-right: 1px solid #f3f4f6 !important;
}
</style>

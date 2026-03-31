<div class="workspace-container animate__animated animate__fadeIn">
    <!-- Sidebar: File Explorer -->
    <div class="workspace-sidebar">
        <div class="sidebar-header">
            <h3 class="text-xs font-bold uppercase tracking-widest text-slate-500">Explorer</h3>
            <div class="flex gap-2">
                <button class="btn-icon" onclick="createNew('file')"><i class="fa-solid fa-file-circle-plus"></i></button>
                <button class="btn-icon" onclick="createNew('folder')"><i class="fa-solid fa-folder-plus"></i></button>
            </div>
        </div>
        <div class="file-tree" id="file-tree">
            <!-- Root Folder -->
            <div class="tree-item folder expanded" data-id="root">
                <div class="tree-label">
                    <i class="fa-solid fa-chevron-down mr-2 text-[10px]"></i>
                    <i class="fa-solid fa-folder-open mr-2 text-ocean-400"></i>
                    <span><?= htmlspecialchars($repository['title']) ?></span>
                </div>
                <div class="tree-children">
                    <?php 
                    function renderTree($items, $parentId = null) {
                        foreach ($items as $item) {
                            if ($item['parent_id'] == $parentId) {
                                $isFolder = $item['type'] == 'folder';
                                echo '<div class="tree-item ' . ($isFolder ? 'folder' : 'file') . '" data-id="' . $item['id'] . '">';
                                echo '<div class="tree-label" onclick="' . ($isFolder ? 'toggleFolder(this)' : 'openFile(' . $item['id'] . ')') . '">';
                                if ($isFolder) {
                                    echo '<i class="fa-solid fa-chevron-right mr-2 text-[10px]"></i>';
                                    echo '<i class="fa-solid fa-folder mr-2 text-amber-500"></i>';
                                } else {
                                    echo '<i class="fa-solid fa-file-lines mr-2 text-slate-400"></i>';
                                }
                                echo '<span>' . htmlspecialchars($item['name']) . '</span>';
                                echo '</div>';
                                if ($isFolder) {
                                    echo '<div class="tree-children hidden">';
                                    renderTree($items, $item['id']);
                                    echo '</div>';
                                }
                                echo '</div>';
                            }
                        }
                    }
                    renderTree($fileTree);
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content: Editor -->
    <div class="workspace-main">
        <div class="editor-tabs" id="editor-tabs">
            <!-- Tabs will appear here -->
        </div>
        <div class="editor-toolbar">
            <div class="file-info" id="active-file-info">Select a file to start editing</div>
            <div class="editor-actions">
                <button class="btn btn-primary btn-xs px-4" id="save-btn" onclick="saveActiveFile()" disabled>
                    <i class="fa-solid fa-floppy-disk mr-2"></i> Save Changes
                </button>
            </div>
        </div>
        <div class="editor-canvas" id="editor-canvas">
            <div class="editor-welcome">
                <i class="fa-solid fa-laptop-code text-6xl text-slate-800 mb-6 font-thin"></i>
                <h2 class="text-2xl font-bold text-slate-700">Project Workspace</h2>
                <p class="text-slate-600 mt-2">Collaborative environment for documentation and research.</p>
            </div>
            <textarea id="code-editor" style="display:none;"></textarea>
        </div>
    </div>

    <!-- Right Sidebar: Details & Tools -->
    <div class="workspace-tools">
        <div class="tools-tabs">
            <button class="tool-tab active" data-target="details">Details</button>
            <button class="tool-tab" data-target="comments">Comments</button>
            <button class="tool-tab" data-target="history">History</button>
        </div>
        <div class="tool-content active" id="tool-details">
            <div class="p-6">
                <h4 class="text-xs font-bold uppercase tracking-widest text-slate-500 mb-4">Project Members</h4>
                <div class="space-y-3">
                    <?php foreach ($members as $m): ?>
                        <div class="flex items-center gap-3">
                            <div class="avatar avatar-xs"><?= strtoupper(substr($m['first_name'], 0, 1)) ?></div>
                            <span class="text-xs text-slate-300"><?= htmlspecialchars($m['first_name'] . ' ' . $m['last_name']) ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <h4 class="text-xs font-bold uppercase tracking-widest text-slate-500 mt-8 mb-4">Shortcuts</h4>
                <div class="grid grid-cols-1 gap-2">
                    <a href="<?= APP_URL ?>/chat/<?= $repository['group_id'] ?>" class="btn btn-ghost btn-xs text-left justify-start">
                        <i class="fa-solid fa-message mr-2 text-ocean-400"></i> Group Chat
                    </a>
                    <a href="<?= APP_URL ?>/workspace/<?= $repository['id'] ?>/logbook" class="btn btn-ghost btn-xs text-left justify-start">
                        <i class="fa-solid fa-book mr-2 text-emerald-400"></i> Logbook
                    </a>
                    <a href="<?= APP_URL ?>/meetings/<?= $repository['id'] ?>" class="btn btn-ghost btn-xs text-left justify-start">
                        <i class="fa-solid fa-calendar mr-2 text-amber-400"></i> Meetings
                    </a>
                </div>
            </div>
        </div>
        <div class="tool-content" id="tool-comments">
            <div class="p-4 text-center text-slate-600">
                <p class="text-xs italic">Select a line in the editor to add a comment.</p>
            </div>
        </div>
    </div>
</div>

<!-- Scripts for IDE functionality -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/codemirror.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/theme/dracula.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/codemirror.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/mode/javascript/javascript.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/mode/xml/xml.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/mode/css/css.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/mode/markdown/markdown.min.js"></script>

<script>
let editor;
let activeFileId = null;
let repoId = <?= $repository['id'] ?>;

window.onload = function() {
    editor = CodeMirror.fromTextArea(document.getElementById("code-editor"), {
        lineNumbers: true,
        theme: "dracula",
        mode: "markdown",
        lineWrapping: true,
        viewportMargin: Infinity
    });
};

function toggleFolder(el) {
    const parent = el.closest('.folder');
    const children = parent.querySelector('.tree-children');
    const icon = el.querySelector('.fa-chevron-right, .fa-chevron-down');
    
    if (children.classList.contains('hidden')) {
        children.classList.remove('hidden');
        icon.classList.replace('fa-chevron-right', 'fa-chevron-down');
        parent.classList.add('expanded');
    } else {
        children.classList.add('hidden');
        icon.classList.replace('fa-chevron-down', 'fa-chevron-right');
        parent.classList.remove('expanded');
    }
}

async function openFile(id) {
    try {
        const response = await fetch(`<?= APP_URL ?>/workspace/${repoId}/file/${id}`);
        const data = await response.json();
        
        if (data.success) {
            activeFileId = id;
            document.querySelector('.editor-welcome').style.display = 'none';
            document.getElementById('code-editor').parentElement.style.display = 'block';
            
            editor.setValue(data.file.content || '');
            document.getElementById('active-file-info').textContent = data.file.name;
            document.getElementById('save-btn').disabled = false;
            
            // Set mode based on extension
            const ext = data.file.name.split('.').pop();
            setEditorMode(ext);
        }
    } catch (e) { console.error("File load error", e); }
}

function setEditorMode(ext) {
    const modes = { 'js': 'javascript', 'html': 'xml', 'css': 'css', 'md': 'markdown', 'txt': 'text' };
    editor.setOption("mode", modes[ext] || 'text');
}

async function saveActiveFile() {
    if (!activeFileId) return;
    
    const content = editor.getValue();
    const saveBtn = document.getElementById('save-btn');
    saveBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Saving...';
    
    try {
        const response = await fetch(`<?= APP_URL ?>/workspace/save-file`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `file_id=${activeFileId}&repo_id=${repoId}&content=${encodeURIComponent(content)}&csrf_token=<?= \App\Core\Session::getCsrfToken() ?>`
        });
        const data = await response.json();
        if (data.success) {
            saveBtn.innerHTML = '<i class="fa-solid fa-check mr-2"></i> Saved';
            setTimeout(() => { saveBtn.innerHTML = '<i class="fa-solid fa-floppy-disk mr-2"></i> Save Changes'; }, 2000);
        }
    } catch (e) { 
        console.error("Save error", e); 
        saveBtn.innerHTML = '<i class="fa-solid fa-triangle-exclamation mr-2"></i> Error';
    }
}

function createNew(type) {
    const name = prompt(`Enter ${type} name:`);
    if (!name) return;
    
    fetch(`<?= APP_URL ?>/workspace/create-file`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `repo_id=${repoId}&name=${name}&type=${type}&csrf_token=<?= \App\Core\Session::getCsrfToken() ?>`
    }).then(r => r.json()).then(data => {
        if (data.success) window.location.reload();
    });
}
</script>

<style>
.workspace-container { display: flex; height: calc(100vh - 120px); background: #1a1a1a; border-radius: 20px; overflow: hidden; border: 1px solid #333; }
.workspace-sidebar { width: 260px; border-right: 1px solid #333; display: flex; flex-direction: column; }
.sidebar-header { padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #333; }
.file-tree { flex: 1; overflow-y: auto; padding: 10px 0; }
.tree-item { cursor: pointer; }
.tree-label { padding: 8px 20px; font-size: 13px; color: #ccc; display: flex; align-items: center; }
.tree-label:hover { background: #2a2a2a; color: #fff; }
.tree-children { padding-left: 20px; }
.hidden { display: none; }

.workspace-main { flex: 1; display: flex; flex-direction: column; background: #282a36; }
.editor-toolbar { padding: 10px 20px; background: #21222c; border-bottom: 1px solid #333; display: flex; justify-content: space-between; align-items: center; }
.file-info { font-size: 12px; color: #999; font-family: monospace; }
.editor-canvas { flex: 1; position: relative; }
.editor-welcome { position: absolute; top: 0; left: 0; width: 100%; height: 100%; display: flex; flex-direction: column; items-center; justify-center; }

.workspace-tools { width: 280px; border-left: 1px solid #333; background: #1a1a1a; }
.tools-tabs { display: flex; border-bottom: 1px solid #333; }
.tool-tab { flex: 1; padding: 12px; font-size: 11px; font-weight: bold; text-transform: uppercase; color: #555; background: none; border: none; cursor: pointer; }
.tool-tab.active { color: #00d2ff; border-bottom: 2px solid #00d2ff; }
.tool-content { display: none; }
.tool-content.active { display: block; }

.CodeMirror { height: 100%; font-family: 'Fira Code', 'Courier New', monospace; font-size: 14px; }
.btn-icon { background: none; border: none; color: #555; cursor: pointer; font-size: 12px; }
.btn-icon:hover { color: #00d2ff; }
</style>

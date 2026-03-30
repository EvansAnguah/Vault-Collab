<div class="page-header animate-fade">
    <h1 class="page-title"><i class="fa-solid fa-comments mr-3 text-blue-600"></i> Project Discussions</h1>
    <span class="badge badge-success uppercase text-[10px]">Live Hub</span>
</div>

<div class="grid grid-cols-4 gap-8 h-[calc(100vh-220px)] animate-fade">
    <!-- Members Sidebar -->
    <div class="card flex flex-col h-full">
        <div class="card-header">
            <h3 class="card-title text-xs uppercase text-gray-500 tracking-widest leading-none">Collaborators</h3>
        </div>
        <div class="card-body p-4 flex-1 overflow-y-auto">
            <div class="space-y-4">
                <?php foreach ($members as $m): ?>
                    <div class="flex items-center gap-3 p-2 rounded hover:bg-gray-50 transition-all cursor-default">
                        <div class="user-avatar w-8 h-8 text-[10px]"><?= strtoupper(substr($m['first_name'], 0, 1)) ?></div>
                        <div class="flex-1">
                            <p class="text-xs font-bold text-gray-800"><?= htmlspecialchars($m['first_name'] . ' ' . $m['last_name']) ?></p>
                            <span class="text-[9px] text-green-600 font-bold uppercase tracking-tighter">Online</span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Chat Area -->
    <div class="col-span-3 card flex flex-col h-full bg-white shadow-xl shadow-gray-200/50">
        <div class="card-header flex justify-between items-center bg-gray-50/50">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-hashtag text-blue-600"></i>
                <h3 class="card-title text-sm">General channel</h3>
            </div>
            <a href="<?= APP_URL ?>/meetings/<?= $groupId ?>" class="btn btn-sm">
                <i class="fa-solid fa-video mr-2 text-purple-600"></i> Start Video Call
            </a>
        </div>
        
        <div class="card-body flex-1 overflow-y-auto p-8 flex flex-col gap-4" id="chat-messages">
            <?php if (empty($messages)): ?>
                <div class="flex flex-col items-center justify-center h-full text-gray-300">
                    <i class="fa-solid fa-message text-5xl mb-4 font-thin"></i>
                    <p class="text-xs">No messages yet. Start the conversation!</p>
                </div>
            <?php else: ?>
                <?php foreach ($messages as $msg): ?>
                    <?php $isMine = $msg['user_id'] == \App\Core\Auth::id(); ?>
                    <div class="flex flex-col <?= $isMine ? 'items-end' : 'items-start' ?>">
                        <span class="text-[9px] text-gray-400 mb-1 px-2 uppercase font-bold"><?= htmlspecialchars($isMine ? 'You' : $msg['first_name']) ?></span>
                        <div class="message <?= $isMine ? 'message-sent' : 'message-received' ?>">
                            <?= htmlspecialchars($msg['content']) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="p-6 border-t border-gray-100 bg-gray-50/50">
            <form id="chat-form" class="flex gap-4">
                <input type="text" id="chat-input" class="form-control p-3 bg-white border-2 border-gray-200 focus:border-blue-600 focus:shadow-none" placeholder="Write a research update or message..." autocomplete="off">
                <button type="submit" class="btn btn-blue px-8 font-bold">
                    <i class="fa-solid fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
const chatMessages = document.getElementById('chat-messages');
const chatForm = document.getElementById('chat-form');
const chatInput = document.getElementById('chat-input');
const groupId = <?= $groupId ?>;

chatMessages.scrollTop = chatMessages.scrollHeight;

chatForm.onsubmit = async (e) => {
    e.preventDefault();
    const content = chatInput.value.trim();
    if (!content) return;
    
    chatInput.value = '';
    try {
        const response = await fetch(`<?= APP_URL ?>/chat/send`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `group_id=${groupId}&content=${encodeURIComponent(content)}&csrf_token=<?= \App\Core\Session::getCsrfToken() ?>`
        });
        const data = await response.json();
        if (data.success) fetchMessages();
    } catch (e) { console.error("Chat Error", e); }
};

setInterval(fetchMessages, 3000);

async function fetchMessages() {
    try {
        const response = await fetch(`<?= APP_URL ?>/chat/${groupId}/api`);
        const data = await response.json();
        if (data.messages) {
            renderMessages(data.messages);
        }
    } catch (e) {}
}

function renderMessages(msgs) {
    const userId = <?= \App\Core\Auth::id() ?>;
    chatMessages.innerHTML = msgs.map(m => {
        const isMine = m.user_id == userId;
        return `
            <div class="flex flex-col ${isMine ? 'items-end' : 'items-start'}">
                <span class="text-[9px] text-gray-400 mb-1 px-2 uppercase font-bold">${isMine ? 'You' : m.first_name}</span>
                <div class="message ${isMine ? 'message-sent' : 'message-received'}">
                    ${escapeHtml(m.content)}
                </div>
            </div>
        `;
    }).join('');
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}
</script>

<style>
.message-sent { background-color: #0969da; color: white; border-bottom-right-radius: 4px; }
.message-received { background-color: #f1f3f5; color: #1f2328; border-bottom-left-radius: 4px; }
#chat-messages::-webkit-scrollbar { width: 4px; }
#chat-messages::-webkit-scrollbar-thumb { background: #d0d7de; border-radius: 10px; }
</style>

<div class="chat-wrapper animate__animated animate__fadeIn">
    <!-- Chat Sidebar: Members -->
    <div class="chat-sidebar">
        <div class="p-6 border-b border-white/5">
            <h3 class="text-xs font-bold uppercase tracking-widest text-slate-500 mb-6">Group Members</h3>
            <div class="space-y-4">
                <?php foreach ($members as $m): ?>
                    <div class="flex items-center gap-3">
                        <div class="avatar avatar-xs relative">
                            <?php if ($m['profile_photo']): ?>
                                <img src="<?= APP_URL ?>/<?= $m['profile_photo'] ?>" alt="Profile">
                            <?php else: ?>
                                <span class="text-[10px] font-bold text-ocean-400"><?= strtoupper(substr($m['first_name'], 0, 1)) ?></span>
                            <?php endif; ?>
                            <div class="status-indicator online"></div>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs font-bold text-slate-300"><?= htmlspecialchars($m['first_name'] . ' ' . $m['last_name']) ?></span>
                            <span class="text-[9px] text-slate-500 uppercase"><?= $m['role'] ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <div class="p-6">
            <a href="<?= APP_URL ?>/video-call/<?= $group['id'] ?>" class="btn btn-primary btn-sm w-full shadow-lg shadow-ocean-500/10">
                <i class="fa-solid fa-video mr-2"></i> Start Meeting
            </a>
        </div>
    </div>

    <!-- Chat Main Area -->
    <div class="chat-main">
        <div class="chat-header">
            <div class="flex items-center gap-4">
                <a href="<?= APP_URL ?>/dashboard" class="text-slate-500 hover:text-ocean-400 transition-colors">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <h2 class="text-base font-bold text-slate-100"><?= htmlspecialchars($group['name']) ?> Chat</h2>
            </div>
            <div class="flex gap-2">
                <button class="btn btn-ghost btn-xs text-slate-500"><i class="fa-solid fa-magnifying-glass"></i></button>
                <button class="btn btn-ghost btn-xs text-slate-500"><i class="fa-solid fa-ellipsis-vertical"></i></button>
            </div>
        </div>

        <div class="chat-messages" id="chat-messages">
            <?php foreach ($messages as $msg): ?>
                <?php $isMe = ($msg['sender_id'] == \App\Core\Auth::id()); ?>
                <div class="message-group <?= $isMe ? 'message-me' : 'message-them' ?>" data-id="<?= $msg['id'] ?>">
                    <?php if (!$isMe): ?>
                        <div class="message-avatar">
                            <?= strtoupper(substr($msg['first_name'], 0, 1)) ?>
                        </div>
                    <?php endif; ?>
                    <div class="message-content">
                        <?php if (!$isMe): ?>
                            <span class="sender-name"><?= htmlspecialchars($msg['first_name']) ?></span>
                        <?php endif; ?>
                        <div class="bubble">
                            <p><?= htmlspecialchars($msg['message']) ?></p>
                            <span class="time"><?= date('H:i', strtotime($msg['created_at'])) ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="chat-input-area">
            <form id="chat-form" class="flex gap-4">
                <button type="button" class="btn btn-ghost btn-icon text-slate-500"><i class="fa-solid fa-paperclip"></i></button>
                <div class="flex-1 relative">
                    <input type="text" id="chat-input" class="form-control chat-input-field" placeholder="Type your message here..." autocomplete="off">
                </div>
                <button type="submit" class="btn btn-primary btn-icon-round shadow-lg shadow-ocean-500/20">
                    <i class="fa-solid fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
const groupId = <?= $group['id'] ?>;
const myId = <?= \App\Core\Auth::id() ?>;
let lastMsgId = <?= !empty($messages) ? end($messages)['id'] : 0 ?>;

// Scroll to bottom on load
const msgContainer = document.getElementById('chat-messages');
msgContainer.scrollTop = msgContainer.scrollHeight;

// Send Message
document.getElementById('chat-form').onsubmit = async (e) => {
    e.preventDefault();
    const input = document.getElementById('chat-input');
    const msg = input.value.trim();
    if (!msg) return;

    input.value = '';
    
    try {
        const response = await fetch(`<?= APP_URL ?>/api/chat/send`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `group_id=${groupId}&message=${encodeURIComponent(msg)}&csrf_token=<?= \App\Core\Session::getCsrfToken() ?>`
        });
        const data = await response.json();
        if (data.success) {
            pollMessages(); // Instant poll after send
        }
    } catch (e) { console.error("Chat send error", e); }
};

// Polling
async function pollMessages() {
    try {
        const response = await fetch(`<?= APP_URL ?>/api/chat/messages?group_id=${groupId}&last_id=${lastMsgId}`);
        const data = await response.json();
        
        if (data.success && data.messages.length > 0) {
            data.messages.forEach(msg => {
                appendMessage(msg);
                lastMsgId = Math.max(lastMsgId, msg.id);
            });
            msgContainer.scrollTop = msgContainer.scrollHeight;
        }
    } catch (e) { console.error("Polling error", e); }
}

function appendMessage(msg) {
    const isMe = msg.sender_id == myId;
    const existing = document.querySelector(`.message-group[data-id="${msg.id}"]`);
    if (existing) return;

    const html = `
        <div class="message-group ${isMe ? 'message-me' : 'message-them'}" data-id="${msg.id}">
            ${!isMe ? `<div class="message-avatar">${msg.first_name[0].toUpperCase()}</div>` : ''}
            <div class="message-content">
                ${!isMe ? `<span class="sender-name">${msg.first_name}</span>` : ''}
                <div class="bubble">
                    <p>${escapeHtml(msg.message)}</p>
                    <span class="time">${new Date(msg.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</span>
                </div>
            </div>
        </div>
    `;
    msgContainer.insertAdjacentHTML('beforeend', html);
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Start Polling every 3 seconds
setInterval(pollMessages, 3000);
</script>

<style>
.chat-wrapper { display: flex; height: calc(100vh - 120px); background: #0f172a; border-radius: 24px; overflow: hidden; border: 1px solid #1e293b; }
.chat-sidebar { width: 300px; border-right: 1px solid #1e293b; background: rgba(0,0,0,0.2); }
.chat-main { flex: 1; display: flex; flex-direction: column; background: rgba(15, 23, 42, 0.4); }
.chat-header { padding: 20px 30px; border-bottom: 1px solid #1e293b; display: flex; justify-content: space-between; align-items: center; background: rgba(0,0,0,0.1); }
.chat-messages { flex: 1; overflow-y: auto; padding: 30px; display: flex; flex-direction: column; gap: 24px; scroll-behavior: smooth; }
.chat-input-area { padding: 24px 30px; border-top: 1px solid #1e293b; background: rgba(0,0,0,0.1); }

.message-group { display: flex; gap: 12px; max-width: 80%; }
.message-me { align-self: flex-end; flex-direction: row-reverse; }
.message-avatar { width: 32px; height: 32px; border-radius: 10px; background: #334155; display: flex; items-center; justify-center; font-weight: bold; font-size: 12px; color: #94a3b8; }
.message-content { display: flex; flex-direction: column; }
.message-me .message-content { align-items: flex-end; }
.sender-name { font-size: 10px; font-weight: bold; color: #64748b; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.05em; }
.bubble { padding: 12px 18px; border-radius: 18px; background: #1e293b; position: relative; }
.message-me .bubble { background: #00d2ff; color: #000; border-bottom-right-radius: 4px; }
.message-them .bubble { border-bottom-left-radius: 4px; border: 1px solid #334155; }
.bubble p { font-size: 14px; line-height: 1.5; margin: 0; }
.time { display: block; font-size: 9px; opacity: 0.5; margin-top: 4px; text-align: right; }

.chat-input-field { background: #0f172a !important; border: 1px solid #334155 !important; border-radius: 50px !important; padding: 12px 25px !important; color: #fff !important; }
.btn-icon-round { width: 45px; height: 45px; border-radius: 50%; display: flex; items-center; justify-center; padding: 0 !important; }

.status-indicator { position: absolute; bottom: -2px; right: -2px; width: 10px; height: 10px; border-radius: 50%; border: 2px solid #0f172a; }
.status-indicator.online { background: #22c55e; }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/codemirror.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/theme/material-ocean.min.css">

<style>
/* Playground specific styles to override default app padding if necessary */
.playground-wrapper {
    display: flex;
    flex-direction: column;
    height: calc(100vh - 80px); /* Adjust based on topbar */
    margin: -1.5rem; /* Negate the generic container padding */
    background: #0f172a;
    color: #fff;
}

.pg-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 20px;
    background: #1e293b;
    border-bottom: 1px solid #334155;
}

.pg-header h2 {
    margin: 0;
    font-size: 1.2rem;
    color: #38bdf8;
    display: flex;
    align-items: center;
    gap: 10px;
}

.pg-actions {
    display: flex;
    align-items: center;
    gap: 10px;
}

.pg-editors {
    display: flex;
    height: 40%;
    border-bottom: 4px solid #334155;
}

.editor-column {
    flex: 1;
    display: flex;
    flex-direction: column;
    border-right: 1px solid #334155;
    background: #1e293b;
}

.editor-column:last-child {
    border-right: none;
}

.editor-header {
    padding: 6px 15px;
    font-size: 0.85rem;
    font-weight: 600;
    letter-spacing: 1px;
    background: #0f172a;
    border-bottom: 1px solid #334155;
    color: #94a3b8;
    text-transform: uppercase;
    display: flex;
    align-items: center;
    gap: 8px;
}

.html-header { border-top: 3px solid #ef4444; }
.css-header { border-top: 3px solid #3b82f6; }
.js-header { border-top: 3px solid #eab308; }

.CodeMirror {
    flex: 1;
    height: 100% !important;
    font-family: 'Fira Code', 'Consolas', monospace;
    font-size: 14px;
}

.pg-preview {
    flex: 1;
    background: #fff;
    position: relative;
}

#preview-iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: none;
}

#save-status {
    font-size: 0.9rem;
    color: #10b981;
    opacity: 0;
    transition: opacity 0.3s ease;
}

#save-status.show {
    opacity: 1;
}
</style>

<div class="playground-wrapper">
    <div class="pg-header">
       <h2><i class="fa-solid fa-laptop-code"></i> Workspace Labs</h2>
       <div class="pg-actions">
           <span id="save-status"><i class="fa-solid fa-check"></i> Saved successfully</span>
           <button id="run-btn" class="btn btn-primary" style="padding: 0.5rem 1rem;"><i class="fa-solid fa-play"></i> Run Code</button>
           <button id="save-btn" class="btn btn-success" style="padding: 0.5rem 1rem;"><i class="fa-solid fa-floppy-disk"></i> Save Snippet</button>
       </div>
    </div>
    
    <div class="pg-editors">
        <div class="editor-column">
            <div class="editor-header html-header"><i class="fa-brands fa-html5"></i> HTML</div>
            <textarea id="html-editor"><?= htmlspecialchars($snippet['html_code'] ?? "<!-- Write your HTML here -->\n<h1>Hello World</h1>\n<p>Welcome to Workspace Labs.</p>") ?></textarea>
        </div>
        <div class="editor-column">
            <div class="editor-header css-header"><i class="fa-brands fa-css3-alt"></i> CSS</div>
            <textarea id="css-editor"><?= htmlspecialchars($snippet['css_code'] ?? "/* Write your CSS here */\nbody {\n  font-family: sans-serif;\n  color: #333;\n  text-align: center;\n  padding-top: 50px;\n}") ?></textarea>
        </div>
        <div class="editor-column">
            <div class="editor-header js-header"><i class="fa-brands fa-js"></i> JavaScript</div>
            <textarea id="js-editor"><?= htmlspecialchars($snippet['js_code'] ?? "// Write your JS here\nconsole.log('Labs initialized');") ?></textarea>
        </div>
    </div>
    
    <div class="pg-preview">
        <iframe id="preview-iframe" title="Code Preview"></iframe>
    </div>
</div>

<!-- CodeMirror Core and Modes -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/codemirror.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/mode/xml/xml.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/mode/css/css.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/mode/javascript/javascript.min.js"></script>
<!-- Emmet integration could go here -->

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Initialize standard options
    const editorConfig = {
        theme: 'material-ocean',
        lineNumbers: true,
        lineWrapping: true,
        smartIndent: true,
        autoCloseBrackets: true,
        matchBrackets: true
    };

    // Initialize HTML Editor
    const htmlEditor = CodeMirror.fromTextArea(document.getElementById('html-editor'), {
        ...editorConfig,
        mode: 'xml',
        htmlMode: true
    });

    // Initialize CSS Editor
    const cssEditor = CodeMirror.fromTextArea(document.getElementById('css-editor'), {
        ...editorConfig,
        mode: 'css'
    });

    // Initialize JS Editor
    const jsEditor = CodeMirror.fromTextArea(document.getElementById('js-editor'), {
        ...editorConfig,
        mode: 'javascript'
    });

    const iframe = document.getElementById('preview-iframe');
    const runBtn = document.getElementById('run-btn');
    const saveBtn = document.getElementById('save-btn');
    const saveStatus = document.getElementById('save-status');

    // Function to compile and update iframe
    function runCode() {
        const html = htmlEditor.getValue();
        const css = `<style>${cssEditor.getValue()}</style>`;
        const js = `<script>${jsEditor.getValue()}<\/script>`;

        const documentContent = `
            <!DOCTYPE html>
            <html>
                <head>
                    <meta charset="UTF-8">
                    <title>Preview</title>
                    ${css}
                </head>
                <body>
                    ${html}
                    ${js}
                </body>
            </html>
        `;

        const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
        iframeDoc.open();
        iframeDoc.write(documentContent);
        iframeDoc.close();
    }

    // Run automatically on load
    runCode();

    // Re-run on button click
    runBtn.addEventListener('click', runCode);

    // Save functionality
    saveBtn.addEventListener('click', () => {
        saveBtn.disabled = true;
        saveBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';

        const formData = new FormData();
        formData.append('html_code', htmlEditor.getValue());
        formData.append('css_code', cssEditor.getValue());
        formData.append('js_code', jsEditor.getValue());
        
        // Add CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
        formData.append('_csrf_token', csrfToken);

        fetch('<?= APP_URL ?>/playground/save', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            saveBtn.disabled = false;
            saveBtn.innerHTML = '<i class="fa-solid fa-floppy-disk"></i> Save Snippet';
            
            if (data.success) {
                saveStatus.classList.add('show');
                setTimeout(() => {
                    saveStatus.classList.remove('show');
                }, 3000);
            } else {
                alert(data.message || 'Error saving snippet.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            saveBtn.disabled = false;
            saveBtn.innerHTML = '<i class="fa-solid fa-floppy-disk"></i> Save Snippet';
            alert('A network error occurred.');
        });
    });

    // Optional: Auto-run code with a debounce when typing
    let typingTimer;
    const doneTypingInterval = 1000;

    function handleTyping() {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(runCode, doneTypingInterval);
    }

    htmlEditor.on('change', handleTyping);
    cssEditor.on('change', handleTyping);
    jsEditor.on('change', handleTyping);
});
</script>

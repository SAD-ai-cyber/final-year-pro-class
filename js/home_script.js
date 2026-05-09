

// Global: suppress noisy extension / external-CSP console errors that don't affect app behavior.
// Filters the two messages you reported so they don't appear as uncaught errors in DevTools.
window.addEventListener('unhandledrejection', function (event) {
    const msg = String(event?.reason || '');
    if (/Could not establish connection|Receiving end does not exist|Loading the script \'blob:/.test(msg)) {
        event.preventDefault(); // stop default logging
        console.warn('Suppressed benign error (extension/CSP):', msg);
    }
});
window.addEventListener('error', function (event) {
    const m = String(event?.message || '');
    if (/Could not establish connection|Receiving end does not exist|Loading the script \'blob:/.test(m)) {
        event.preventDefault();
        console.warn('Suppressed benign error (extension/CSP):', m);
    }
});

// Helper function.
function handleRedirect(select) {
    if (select.value === "Admin") {
        window.location.href = "admin_login.php";
    }
    else if (select.value === "Users") {
        window.location.href = "login.php";
    }
}

// Page load hone per dropdown reset hoga
window.addEventListener("load", resetDropdown);
window.addEventListener("pageshow", resetDropdown);
window.addEventListener("focus", resetDropdown);

// Helper function.
function resetDropdown() {
    const roleDropdown = document.getElementById("role");
    if (roleDropdown) {
        roleDropdown.selectedIndex = 0; // First option select karegaa
    }
}



// Initialize UI handlers on page load.
document.addEventListener('DOMContentLoaded', function () {
    const markAllReadBtn = document.getElementById('mark-all-read');
    const notificationBadge = document.querySelector('.notification-badge');

    if (markAllReadBtn && notificationBadge) {
        markAllReadBtn.addEventListener('click', function (event) {
            event.preventDefault(); // Prevents link from navigating
            notificationBadge.style.display = 'none';
        });
    }
});



// chatbot script start
// PHP se user ka naam seedha JavaScript variable mein daal dein
// userName is declared in index.php via a global <script> tag.




// Initialize UI handlers on page load.
document.addEventListener("DOMContentLoaded", function () {
    const chatbotContainer = document.getElementById("chatbot-container");
    const chatbotBody = document.getElementById("chatbot-body");
    const closeBtn = document.getElementById("close-btn");
    const sendBtn = document.getElementById("send-btn");
    const chatbotInput = document.getElementById("chatbot-input");
    const chatbotMessages = document.getElementById("chatbot-messages");
    const chatbotIcon = document.getElementById("chatbot-icon");
    const attachBtn = document.getElementById("attach-btn");
    const fileInput = document.getElementById("file-input");
    const filePreview = document.getElementById("file-preview");

    //  State variable to hold the uploaded file 
    let uploadedFile = null;

    //  Event Listeners for UI
    chatbotIcon.addEventListener("click", () => {
        chatbotContainer.classList.remove("hidden");
        chatbotIcon.style.display = "none";
    });
    closeBtn.addEventListener("click", () => {
        chatbotContainer.classList.add("hidden");
        chatbotIcon.style.display = "flex";
    });

    // Paste image from clipboard
    chatbotInput.addEventListener("paste", (event) => {
        const items = (event.clipboardData || window.clipboardData).items;
        for (const item of items) {
            if (item.type.startsWith("image/")) {
                event.preventDefault();
                const file = item.getAsFile();
                if (file) handleFile(file);
                return;
            }
        }
    });

    //  File upload to read the file 
    attachBtn.addEventListener('click', () => fileInput.click());
    fileInput.addEventListener('change', (event) => {
        if (event.target.files.length > 0) {
            handleFile(event.target.files[0]);
        }
    });

// Helper function.
    function handleFile(file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            uploadedFile = {
                name: file.name,
                type: file.type,
                data: e.target.result.split(',')[1],
                isImage: file.type.startsWith("image/")
            };
            displayFilePreview();
        };
        reader.readAsDataURL(file);
    }

// Helper function.
    function displayFilePreview() {
        if (!uploadedFile) {
            filePreview.style.display = "none";
            return;
        }
        let previewContent = uploadedFile.isImage
            ? `<img src="data:${uploadedFile.type};base64,${uploadedFile.data}" alt="preview">`
            : `<i class="fa-solid fa-file-lines"></i>`;

        filePreview.innerHTML = `${previewContent}
             <span>${uploadedFile.name}</span> <i class="fa-solid fa-times" id="remove-file-btn"></i>`;

        filePreview.style.display = "flex";
        document.getElementById("remove-file-btn").addEventListener("click", () => {
            uploadedFile = null; fileInput.value = ""; displayFilePreview();
        });
    }

    // --- Core Message Sending Logic ---
    sendBtn.addEventListener("click", sendMessage);
    chatbotInput.addEventListener("keypress", (e) => {
        if (e.key === "Enter" && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });
// Helper function.
    function sendMessage() {
        const userMessage = chatbotInput.innerText.trim();
        if (!userMessage && !uploadedFile) return;

        let messageHTML = userMessage.replace(/\n/g, '<br>');

        // Yeh logic ab image aur non-image files dono ko chat me dikhayega
        if (uploadedFile) {
            if (uploadedFile.isImage) {
                messageHTML += `<br><img src="data:${uploadedFile.type};base64,${uploadedFile.data}" alt="uploaded image">`;
            } else {
                // Non-image file ke liye naya display logic
                messageHTML += `<br><div class="uploaded-file-chip">
                                           <i class="fa-solid fa-file-lines"></i> 
                                           <span>${uploadedFile.name}</span>
                                       </div>`;
            }
        }

        // Yeh logic ensure karta hai ki sirf file bhejne par bhi message box bane
        if (messageHTML.trim() === "" && uploadedFile) {
            appendMessage("user", messageHTML);
        } else if (messageHTML.trim() !== "") {
            appendMessage("user", messageHTML);
        }

        getBotResponse(userMessage, uploadedFile);

        chatbotInput.innerText = "";
        uploadedFile = null;
        fileInput.value = "";
        displayFilePreview();
    }

// Helper function.
    function appendMessage(sender, html) {
        const messageElement = document.createElement("div");
        messageElement.classList.add("message", sender);
        if (sender === "bot") {
            messageElement.innerHTML = `<i class="fa-solid fa-robot bot-icon"></i><div class="message-text">${html}</div>`;
        } else {
            messageElement.innerHTML = html;
        }
        chatbotMessages.appendChild(messageElement);
        chatbotBody.scrollTop = chatbotBody.scrollHeight;
    }

    //  API call to handle images and text files 
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

// Async workflow handler.
    async function getBotResponse(userMessage, file) {
        
        // Show Typing Indicator
        appendMessage("bot", "<i>Thinking...</i>");

        try {
            // FIX: Pointing to the correct path 'includes/chatbot-proxy.php'
            const response = await fetch("includes/chatbot-proxy.php", { 
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ prompt: userMessage, csrf_token: csrfToken }),
            });

            const botMessageContainer = chatbotMessages.lastElementChild.querySelector(".message-text");

            if (!response.ok) {
                throw new Error("Network response was not ok");
            }

            const data = await response.json();

            // Display Bot Reply
            if (data.reply) {
                // Markdown formatting support (agar marked.js load hai to)
                if (typeof marked !== 'undefined') {
                     botMessageContainer.innerHTML = marked.parse(data.reply);
                } else {
                     botMessageContainer.textContent = data.reply;
                }
            } else {
                botMessageContainer.textContent = "Sorry, I received an empty response.";
            }

        } catch (error) {
            const botMessageContainer = chatbotMessages.lastElementChild.querySelector(".message-text");
            botMessageContainer.textContent = "⚠️ Server Error. Please check your connection.";
            console.error("Fetch Error:", error);
        }
    }
});
// chatbot script end


// Initialize UI handlers on page load.
document.addEventListener('DOMContentLoaded', () => {
    // --- Student Fee Auto-Calculation Logic (for iframe) ---
    function setupFeeAutoCalc() {
        // Try to find fee form elements in iframe or main document
        let doc = document;
        // If iframe exists, use its document
        const iframe = document.querySelector('iframe');
        if (iframe && iframe.contentDocument) doc = iframe.contentDocument;
        const coursePriceInput = doc.getElementById('course-price');
        const paidPriceInput = doc.getElementById('paid-price');
        const discountInput = doc.getElementById('discount');
        const remainingPriceInput = doc.getElementById('remaining-price');
        if (coursePriceInput && paidPriceInput && discountInput && remainingPriceInput) {
            function calculateRemaining() {
                const coursePrice = parseFloat(coursePriceInput.value) || 0;
                const paidPrice = parseFloat(paidPriceInput.value) || 0;
                const discount = parseFloat(discountInput.value) || 0;
                const remaining = (coursePrice - discount) - paidPrice;
                remainingPriceInput.value = remaining.toFixed(2);
            }
            coursePriceInput.addEventListener('input', calculateRemaining);
            coursePriceInput.addEventListener('change', calculateRemaining);
            paidPriceInput.addEventListener('input', calculateRemaining);
            paidPriceInput.addEventListener('change', calculateRemaining);
            discountInput.addEventListener('input', calculateRemaining);
            discountInput.addEventListener('change', calculateRemaining);
        }
    }
    // Run setupFeeAutoCalc after iframe loads
    const iframe = document.querySelector('iframe');
    if (iframe) {
        iframe.addEventListener('load', setupFeeAutoCalc);
    } else {
        setupFeeAutoCalc();
    }

    // --- 1. Sabhi zaroori elements select karo ---
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const overlay = document.getElementById('overlay');

    // Header elements
    const notificationBtn = document.getElementById('notificationBtn');
    const notificationDropdown = document.getElementById('notificationDropdown');
    const userBtn = document.getElementById('userBtn');
    const userDropdown = document.getElementById('userDropdown');

    // Chatbot elements
    const chatbotIcon = document.getElementById('chatbot-icon');
    const chatbotContainer = document.getElementById('chatbot-container');
    const closeChatbotBtn = document.getElementById('close-btn');
    const chatMessages = document.getElementById('chatbot-messages');
    const chatInput = document.getElementById('chatbot-input');
    const sendChatBtn = document.getElementById('send-btn');
    // File Upload Elements
    const attachBtn = document.getElementById('attach-btn');
    const fileInput = document.getElementById('file-input');
    const filePreview = document.getElementById('file-preview');
    // Use global csrfToken defined in window
    // const csrfMeta = document.querySelector('meta[name="csrf-token"]');
    // const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '';

    const initialMainContent = mainContent ? mainContent.innerHTML : '';
    const initialMainContentPadding = mainContent ? window.getComputedStyle(mainContent).padding : '2rem';

    let uploadedFile = null;

    // --- 2. Header ke Dropdowns ---
    if (notificationBtn && notificationDropdown) setupDropdown(notificationBtn, notificationDropdown);
    if (userBtn && userDropdown) setupDropdown(userBtn, userDropdown);

    // Helper function.
    function setupDropdown(button, dropdown) {
        button.addEventListener('click', (e) => {
            e.stopPropagation();
            if (button === notificationBtn && userDropdown) userDropdown.classList.remove('active');
            if (button === userBtn && notificationDropdown) notificationDropdown.classList.remove('active');
            dropdown.classList.toggle('active');
        });
    }

    window.addEventListener('click', (e) => {
        if (notificationDropdown && !notificationBtn.contains(e.target) && !notificationDropdown.contains(e.target))
            notificationDropdown.classList.remove('active');
        if (userDropdown && !userBtn.contains(e.target) && !userDropdown.contains(e.target))
            userDropdown.classList.remove('active');
    });

    // --- Activity Logging ---
    document.body.addEventListener('click', function (e) {
        let target = e.target.closest('a, button');

        // SECURITY: INTERCEPT ANY CLICKS WHILE EXAM IS ACTIVE
        if (window.examActive && target) {
            // Check if target is in the parent document (not inside exam iframe)
            const isInsideIframe = !!target.closest('iframe');
            
            // Allow clicks within the iframe (the exam itself)
            if (!isInsideIframe) {
                // If clicking logout or anything else in the parent
                e.preventDefault();
                e.stopPropagation();
                
                const iframe = document.querySelector('iframe');
                if (iframe && iframe.contentWindow && typeof iframe.contentWindow.handleViolation === 'function') {
                    iframe.contentWindow.handleViolation('tabSwitch', 'Attempted Navigation (Menu/Button Click)');
                } else {
                    alert("WARNING: All navigation is disabled during the exam!");
                }
                return;
            }
        }

        if (target) {
            const text = target.innerText || target.textContent || target.getAttribute('aria-label') || 'Icon-only Element';
            const action = target.tagName === 'A' ? 'navigation' : 'click';
            // Prefer the currently loaded AJAX page (set by loadContent) so SPA navigation logs correct page
            const url = window.currentPageUrl || window.location.href;

            // Send log to server (fire and forget)
            fetch('../includes/log_activity.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    page_url: url,
                    action_type: action,
                    element_text: text.trim().substring(0, 50) // Limit text length
                }),
                keepalive: true // Ensure request completes even if page navigates
            }).catch(err => console.error('Log error:', err));
        }
    });

    // --- 3. Sidebar Toggle ---
    if (menuToggle && sidebar && mainContent && overlay) {
        menuToggle.addEventListener('click', () => {
            sidebar.classList.toggle('active');
            if (window.innerWidth <= 768) overlay.classList.toggle('active');
            else mainContent.classList.toggle('shifted');
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
        });
    }

    window.addEventListener('resize', () => {
        if (!sidebar || !mainContent || !overlay) return;
        if (window.innerWidth > 768) {
            overlay.classList.remove('active');
            if (sidebar.classList.contains('active')) mainContent.classList.add('shifted');
        } else {
            mainContent.classList.remove('shifted');
            if (sidebar.classList.contains('active')) overlay.classList.add('active');
        }
    });

    // --- 4. Sidebar Accordion Menu ---
    document.querySelectorAll('.sidebar-main').forEach(item => {
        const menuName = item.getAttribute('data-menu');
        if (menuName === 'dashboard') {
            item.addEventListener('click', () => {
                // EXAM SECURITY CHECK
                if (window.examActive) {
                    const iframe = document.querySelector('iframe');
                    if (iframe && iframe.contentWindow && typeof iframe.contentWindow.handleViolation === 'function') {
                        iframe.contentWindow.handleViolation('tabSwitch', 'Internal Navigation (Dashboard Click)');
                    } else {
                        alert("WARNING: Sidebar navigation is disabled during the exam!");
                    }
                    return;
                }

                const path = (window.location && window.location.pathname) ? window.location.pathname : '';
                const isAdminDashboard = path.indexOf('/dashboard/dashboard.php') !== -1;
                if (!isAdminDashboard) {
                    window.location.reload();
                    return;
                }

                if (mainContent) {
                    mainContent.innerHTML = initialMainContent;
                    mainContent.style.padding = initialMainContentPadding;
                }
                // Set currentPageUrl explicitly for the Dashboard main view so activity logging is accurate
                window.currentPageUrl = 'dashboard/dashboard.php';

                if (typeof window.refreshAdminStats === 'function') {
                    window.refreshAdminStats(false);
                }
                if (typeof window.refreshStudentStats === 'function') {
                    window.refreshStudentStats(false);
                }
                attachQuickActionHandlers(mainContent);
                closeAllSubmenus();
                document.querySelectorAll('.submenu-item.active').forEach(i => i.classList.remove('active'));

                // Log a page view for Dashboard main
                sendPageView(window.currentPageUrl);
            });
            return;
        }

        item.addEventListener('click', () => {
            const submenu = item.nextElementSibling;
            const arrow = item.querySelector('.sidebar-arrow');
            if (!submenu || !submenu.classList.contains('sidebar-submenu')) return;
            const isOpen = submenu.classList.contains('active');
            closeAllSubmenus(submenu);
            if (isOpen) {
                submenu.classList.remove('active');
                if (arrow) arrow.classList.remove('rotated');
            } else {
                submenu.classList.add('active');
                if (arrow) arrow.classList.add('rotated');
            }
        });
    });

    // Helper function.
    function closeAllSubmenus(exceptThisOne = null) {
        document.querySelectorAll('.sidebar-submenu.active').forEach(submenu => {
            if (submenu !== exceptThisOne) {
                submenu.classList.remove('active');
                const prevArrow = submenu.previousElementSibling.querySelector('.sidebar-arrow');
                if (prevArrow) prevArrow.classList.remove('rotated');
            }
        });
    }

    // --- 5. AJAX Content Loading ---
    async function loadContent(pageName) {
        if (!mainContent) return;

        // ===== SECURITY: BLOCK NAVIGATION IF EXAM IS ACTIVE =====
        if (window.examActive) {
            const iframe = document.querySelector('iframe');
            if (iframe && iframe.contentWindow) {
                // If handleViolation is available, trigger it
                if (typeof iframe.contentWindow.handleViolation === 'function') {
                    iframe.contentWindow.handleViolation('tabSwitch', 'Internal Navigation (Menu Click)');
                    return; // Stop the loadContent execution
                } else {
                    // Fallback alert if iframe script not fully loaded or different
                    alert("WARNING: Internal navigation is disabled during the exam!");
                    return;
                }
            }
        }

        if (pageName === '#' || !pageName) {
            mainContent.innerHTML = '<div style="padding: 2rem; background: white; border-radius: 8px;"><h2>Page Not Implemented</h2><p>This feature is coming soon.</p></div>';
            return;
        }
        mainContent.innerHTML = '<div style="display:flex; justify-content:center; padding:5rem; font-size: 2rem; color: #333;"><i class="fas fa-spinner fa-spin"></i>&nbsp; Loading...</div>';
        mainContent.style.padding = '0';

        let cleanName = pageName.replace('.php', '');

        // 2. Folder Selection Logic
        let folderName = 'forms'; // Default setting

        // Explicit mappings for pages that live outside `forms/`
        if (cleanName === 'admin_logs') {
            // admin logs page is under logs/
            folderName = 'logs';
        } else if (cleanName.startsWith('show-')) {
            folderName = 'show-details';
        }

        // Remember the currently-loaded logical page so activity logging records correct page for SPA navigation
        // Store as `folder/page` (e.g. 'dashboard/view_attendance.php')
        window.currentPageUrl = folderName + '/' + pageName;
        // Log the page view (ensures visits are recorded even if user doesn't click anything)
        sendPageView(window.currentPageUrl);

        // 3. Exam Section Logic (NEW FIX)
        // Agar file inme se koi hai, toh folder 'exam-section' use karo
        const examFiles = ['teacher_create_exam', 'show_exams', 'student_take_exam', 'view_student_result'];

        // Check agar file ka naam examFiles list me hai YA naam me 'exam' shabd hai
        if (examFiles.includes(cleanName) || cleanName.includes('exam_')) {
            folderName = 'exam-section';
        }

        // 4. Attendance Section Logic (NEW)
        const attendanceFiles = ['mark_attendance', 'view_attendance', 'mark_attendance_page', 'admin_devices', 'kiosk_share'];
        if (attendanceFiles.includes(cleanName) || cleanName.includes('attendance')) {
            folderName = 'AI_Attendance';
        }

        let finalPath;
        const pathPhp = `../${folderName}/${cleanName}.php`;
        const pathHtml = `../${folderName}/${cleanName}.html`;

        // For AI_Attendance folder files, try alternate path
        let altPathPhp = `../AI_Attendance/${cleanName}.php`;
        let altPathHtml = `../AI_Attendance/${cleanName}.html`;

        try {
            let response = await fetch(pathPhp, { method: 'HEAD' });
            if (response.ok) finalPath = pathPhp;
            else {
                response = await fetch(pathHtml, { method: 'HEAD' });
                if (response.ok) finalPath = pathHtml;
                else {
                    // Try alternate path for attendance files
                    response = await fetch(altPathPhp, { method: 'HEAD' });
                    if (response.ok) finalPath = altPathPhp;
                    else {
                        response = await fetch(altPathHtml, { method: 'HEAD' });
                        if (response.ok) finalPath = altPathHtml;
                        else throw new Error(`File not found at ${pathPhp} OR ${pathHtml}`);
                    }
                }
            }

            const cacheBust = Date.now();
            const sep = finalPath.includes('?') ? '&' : '?';
            const iframeSrc = `${finalPath}${sep}_ts=${cacheBust}`;

            mainContent.innerHTML = '';
            const iframe = document.createElement('iframe');
            iframe.src = iframeSrc;
            // Adjusted height to match new margin-top: 50px
            iframe.setAttribute('frameborder', '0');
            iframe.setAttribute('scrolling', 'auto');
            iframe.style.width = '100%';
            iframe.style.height = '100%';
            iframe.style.background = '#fff';

            // --- Dynamic Layout Function ---
            function adjustIframeLayout() {
                const header = document.querySelector('.header');
                const headerHeight = header ? header.offsetHeight : 70; // Get exact height or fallback

                // Adjust Main Content Top Margin
                mainContent.style.marginTop = `${headerHeight}px`;

                // Adjust Iframe Height to fill remaining space exactly
                const remainingHeight = window.innerHeight - headerHeight;
                iframe.style.height = `${remainingHeight}px`;
            }

            // Run on load
            iframe.addEventListener('load', function () {
                adjustIframeLayout();
                try {
                    iframe.contentWindow.scrollTo(0, 0);
                } catch (e) { }
            });

            // Run on window resize to keep it perfect
            window.addEventListener('resize', adjustIframeLayout);

            mainContent.classList.add('no-padding'); // Force remove padding via class
            mainContent.appendChild(iframe);

            window.scrollTo(0, 0);
            mainContent.scrollTop = 0;
        } catch (error) {
            console.error('Error loading page:', error);
            mainContent.style.padding = initialMainContentPadding;
            mainContent.innerHTML = `<div style="padding: 2rem; background: #fffbe6; border: 1px solid #ffe58f; border-radius: 8px;">
                <h2><i class="fas fa-exclamation-triangle"></i> Page Load Error</h2>
                <p>Failed to load the page '${pageName}'.</p>
                <p><strong>Details:</strong> ${error.message}</p>
            </div>`;
        }
    }

    document.querySelectorAll('.submenu-item').forEach(item => {
        item.addEventListener('click', () => {
            const page = item.getAttribute('data-page');
            loadContent(page);
            document.querySelectorAll('.submenu-item.active').forEach(i => i.classList.remove('active'));
            item.classList.add('active');
            if (window.innerWidth <= 768 && sidebar && overlay) {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
            }
        });
    });

    // --- 6. Quick Action Button Handlers ---
    function attachQuickActionHandlers(container) {
        if (!container) return;
        container.querySelectorAll('.quick-action').forEach(action => {
            action.addEventListener('click', () => {
                const actionName = action.getAttribute('data-action');
                let pageName;
                switch (actionName) {
                    case 'add-student': pageName = 'student-add'; break;
                    case 'create-exam': pageName = 'examinationform'; break;
                    case 'manage-fees': pageName = 'student-fee-det'; break;
                    case 'view-reports': pageName = 'show-result'; break;
                    default: console.warn('Unknown quick action:', actionName); return;
                }
                const matchingSidebarItem = document.querySelector(`.submenu-item[data-page="${pageName}"]`);
                if (matchingSidebarItem) {
                    const parentSidebarMain = matchingSidebarItem.closest('.sidebar-item').querySelector('.sidebar-main');
                    const parentSubmenu = parentSidebarMain.nextElementSibling;
                    if (parentSidebarMain && parentSubmenu && !parentSubmenu.classList.contains('active')) parentSidebarMain.click();
                    matchingSidebarItem.click();
                } else {
                    loadContent(pageName);
                }
            });
        });
    }

    attachQuickActionHandlers(mainContent);

    // --- Page view logging helper ---
    function sendPageView(pageUrl) {
        if (!pageUrl) pageUrl = (window.location && window.location.pathname) ? window.location.pathname : '';
        try {
            fetch('../includes/log_activity.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ page_url: pageUrl, action_type: 'page_view', element_text: '' }),
                keepalive: true
            }).catch(e => {
                // don't spam console on failures
                console.debug('page_view log failed', e);
            });
        } catch (e) { }
    }

    // Log the initial page view for the dashboard shell on first load
    sendPageView(window.currentPageUrl || (window.location && window.location.pathname ? window.location.pathname : 'dashboard/dashboard.php'));

    // --- 7. Chatbot Toggle ---
    if (chatbotIcon && chatbotContainer && closeChatbotBtn) {
        chatbotIcon.addEventListener('click', () => {
            chatbotContainer.classList.remove('hidden');
            chatbotIcon.classList.add('hidden');
        });
        closeChatbotBtn.addEventListener('click', () => {
            chatbotContainer.classList.add('hidden');
            chatbotIcon.classList.remove('hidden');
        });
    }

    // --- 8. Chatbot Logic (Fixed Version with Proxy + File Upload) ---
    if (sendChatBtn && chatInput && chatMessages && attachBtn && fileInput && filePreview) {

        attachBtn.addEventListener('click', () => fileInput.click());

        fileInput.addEventListener('change', (e) => {
            if (e.target.files.length > 0) handleFile(e.target.files[0]);
        });

        chatInput.addEventListener('paste', (e) => {
            const items = (e.clipboardData || window.clipboardData).items;
            for (const item of items) {
                if (item.type.startsWith("image/")) {
                    e.preventDefault();
                    const file = item.getAsFile();
                    if (file) handleFile(file);
                    return;
                }
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

            filePreview.innerHTML = `
                ${previewContent}
                <span>${uploadedFile.name}</span>
                <i class="fa-solid fa-times" id="remove-file-btn"></i>
            `;
            filePreview.style.display = "flex";
            document.getElementById("remove-file-btn").addEventListener("click", () => {
                uploadedFile = null;
                fileInput.value = "";
                displayFilePreview();
            });
        }

        sendChatBtn.addEventListener('click', handleChatSend);
        chatInput.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                handleChatSend();
            }
        });

        // Async workflow handler.
        async function handleChatSend() {
            const messageText = chatInput.innerText.trim();
            if (messageText === '' && !uploadedFile) return;

            appendMessage(messageText, 'user', uploadedFile);
            chatInput.innerText = '';
            const fileToSend = uploadedFile;
            uploadedFile = null;
            fileInput.value = "";
            displayFilePreview();
            appendMessage("<i>Thinking...</i>", 'bot');

            try {
                const response = await fetch('../includes/chatbot-proxy.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ prompt: messageText, file: fileToSend, csrf_token: window.csrfToken })
                });

                if (!response.ok) throw new Error(`Server error: ${response.status}`);

                const data = await response.json();
                const botReply = data.reply || data.text || "Sorry, I received an empty response.";

                const botMessageContainer = chatMessages.lastElementChild.querySelector('.message-text');
                if (botMessageContainer) {
                    if (typeof marked === 'function') {
                        botMessageContainer.innerHTML = marked.parse(botReply);
                    } else {
                        botMessageContainer.innerText = botReply;
                    }
                }
            } catch (error) {
                console.error('Chatbot fetch error:', error);
                const botMessageContainer = chatMessages.lastElementChild.querySelector('.message-text');
                if (botMessageContainer) {
                    botMessageContainer.innerText = "Error: Could not connect to the proxy.";
                }
            }
        }

        // Helper function.
        function appendMessage(text, type, file = null) {
            const messageElement = document.createElement('div');
            messageElement.className = `message ${type}`;
            let messageHTML = '';

            if (type === 'bot') {
                messageHTML = `<span class="bot-icon"><i class="fa-solid fa-robot"></i></span> <span class="message-text">${text}</span>`;
            } else {
                const textNode = document.createElement('span');
                textNode.className = 'message-text';
                textNode.innerText = text;
                messageHTML = textNode.outerHTML;

                if (file) {
                    if (file.isImage) {
                        messageHTML += `<br><img src="data:${file.type};base64,${file.data}" alt="uploaded image" style="max-width:100%; border-radius: 8px; margin-top: 5px;">`;
                    } else {
                        messageHTML += `<br><div class="uploaded-file-chip">
                                           <i class="fa-solid fa-file-lines"></i> 
                                           <span>${file.name}</span>
                                       </div>`;
                    }
                }
            }

            messageElement.innerHTML = messageHTML;
            chatMessages.appendChild(messageElement);
            const chatBody = chatMessages.parentElement;
            if (chatBody) chatBody.scrollTop = chatBody.scrollHeight;
        }
    }
});




// Initialize UI handlers on page load.
document.addEventListener("DOMContentLoaded", () => {
    // Un sabhi elements ko dhundo jinki class 'count-anim' hai
    const counters = document.querySelectorAll('.count-anim');
    const speed = 100; // Speed of animation (jitna kam utna slow)

    counters.forEach(counter => {
        const updateCount = () => {
            // PHP se aayi hui value (data-target) ko number me convert karo
            const target = +counter.getAttribute('data-target');
            // Abhi screen par kya number hai usse lo
            const count = +counter.innerText;

            // Increment decide karo
            const inc = target / speed;

            // Agar current count target se kam hai, to badhao
            if (count < target) {
                counter.innerText = Math.ceil(count + inc);
                // Har 30ms baad dubara function call karo (Animation effect)
                setTimeout(updateCount, 30);
            } else {
                // Agar pahunch gaye to final number set kar do
                counter.innerText = target;
            }
        };
        // Function start karo
        updateCount();
    });


    document.querySelectorAll('.notif-link').forEach(link => {
        link.addEventListener('click', function () {

            const notifId = this.dataset.id;
            const badge = document.querySelector('.notification-badge');

            fetch('../includes/notification_read.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'id=' + notifId + '&csrf_token=' + encodeURIComponent(window.csrfToken)
            })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        badge.innerText = data.unread;
                    }
                });
        });
    });

    // --- Mark All Notifications as Read (AJAX) ---
    const markAllBtn = document.getElementById('markAllReadBtn');

    if (markAllBtn) {
        markAllBtn.addEventListener('click', function (e) {
            e.preventDefault(); // page jump roko

            fetch('../includes/notification_read.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'mark_all=1&csrf_token=' + encodeURIComponent(window.csrfToken)
            })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {

                        // badge update
                        const badge = document.querySelector('.notification-badge');
                        if (badge) badge.innerText = '0';

                        // UI se unread highlight hatao
                        document.querySelectorAll('.notif-link.unread')
                            .forEach(el => el.classList.remove('unread'));

                        document.querySelectorAll('.notification-dropdown-icon.new')
                            .forEach(el => el.classList.remove('new'));
                    }
                });
        });
    }
    window.registerFace = function () {
        const statusEl = document.getElementById("status");
        if (statusEl) statusEl.innerText = "Opening camera... Please wait";

        const formData = new FormData();
        formData.append("action", "register");
        formData.append("csrf_token", window.csrfToken);

        fetch("../AI_Attendance/ai_attendance.php", {
            method: "POST",
            body: formData
        })
            .then(res => res.json())
            .then(data => {
                if (data.status === "success") {
                    if (statusEl) statusEl.innerText =
                        data.message || "Face registered successfully!";
                    setTimeout(() => location.reload(), 1500);
                } else {
                    if (statusEl) statusEl.innerText =
                        data.message || "Face registration failed";
                }
            })
            .catch((err) => {
                console.error("Registration error:", err);
                if (statusEl) statusEl.innerText = "Error: " + (err.message || "Server connection failed");
            });
    };

});

# Block Diagrams — Mark Attendance, Admin Logs, Exam, Email

Sab diagrams aapke diye format mein: `layout: fixed`, `flowchart TB`, `["text"]` / `{"?"}` / `-- label -->`.

---

## 1. Mark Attendance

```mermaid
---
config:
  layout: fixed
---
flowchart TB
    Start(["Student visits"]) --> DeviceCheck{"Device allowed?"}
    DeviceCheck -- No --> Kiosk["kiosk_terminal.php"]
    Kiosk --> Start
    DeviceCheck -- Yes --> Page["mark_attendance_page.php"]
    Page --> LoadStatus["Load today's attendance status"]
    LoadStatus --> Show{"Status?"}
    Show -- No record --> BtnIn["Show Check In button"]
    Show -- Checked In, < 1 hr --> Wait["Show wait message"]
    Show -- Checked In, >= 1 hr --> BtnOut["Show Check Out button"]
    Show -- Check In + Check Out done --> Done["Show 'Attendance complete'"]
    BtnIn --> ClickIn["User clicks Check In"]
    BtnOut --> ClickOut["User clicks Check Out"]
    ClickIn --> API["mark_attendance.php\nattendance_type: in"]
    ClickOut --> API
    API --> Validate["Verify session, CSRF, time slot"]
    Validate -- Invalid --> Err["JSON error response"]
    Validate -- Valid --> DB["INSERT / UPDATE attendance_logs"]
    DB --> Success["JSON success"]
```

---

## 2. Admin Logs

```mermaid
---
config:
  layout: fixed
---
flowchart TB
    Start(["Admin opens Activity Logs"]) --> Open["admin_logs.php"]
    Open --> Filters["Filters: search, date range, page size"]
    Filters --> Fetch["fetch_logs_ajax.php"]
    Fetch --> Params["Params: page, per_page, search,\nstart_date, end_date"]
    Params --> Query["Query activity_logs table\n(join users for name)"]
    Query --> JSON["Return JSON logs"]
    JSON --> Table["Render table in admin_logs.php"]
    Open --> Export["User clicks Export CSV"]
    Export --> ExportAPI["export_logs_csv.php\n(same params)"]
    ExportAPI --> CSV["Download CSV file"]
    Write["User clicks / navigates\nin dashboard"] --> LogAPI["log_activity.php\nPOST: page_url, action_type, element_text"]
    LogAPI --> Insert["INSERT into activity_logs"]
    Insert --> Done["Log saved"]
```

---

## 3. Exam (MCQ)

```mermaid
---
config:
  layout: fixed
---
flowchart TB
    Start(["User role?"]) --> Role{"Who?"}
    Role -- Admin/Teacher --> Create["teacher_create_exam.php"]
    Create --> Form["Select student, course, subject,\ntopic, difficulty, date/time"]
    Form --> Generate["Generate exam\nGemini API / questions"]
    Generate --> Save["Save exam_questions\n& student_exams"]
    Save --> Notify["Send notification + email\nto student & parent"]
    Notify --> ShowExams["show_exams.php"]
    Role -- Student --> Take["student_take_exam.php"]
    Take --> LoadExam["Load exam by exam_id"]
    LoadExam --> Attempt["Student answers questions"]
    Attempt --> Submit["Submit form to submit_exam.php"]
    Submit --> Validate["Validate CSRF, exam_id"]
    Validate --> Score["Compare answers, calculate marks"]
    Score --> Update["UPDATE student_exams\nINSERT exam_answers_log"]
    Update --> Redirect["Redirect to show_exams.php"]
    ShowExams --> ViewReport["view_student_result.php?exam_id"]
    ShowExams --> Delete["delete_exam.php\n(Admin/Teacher only)"]
    Delete --> Back["Redirect show_exams.php"]
```

---

## 4. Email

```mermaid
---
config:
  layout: fixed
---
flowchart TB
    Start(["Trigger event"]) --> Trigger{"Which event?"}
    Trigger -- Add Student --> AddStd["includes/add_student.php"]
    AddStd --> CredStudent["sendStudentCredentialsEmail\nlogin + password"]
    Trigger -- Add Parent --> AddPar["includes/parent_add.php"]
    AddPar --> CredParent["sendParentCredentialsEmail\nlogin + password"]
    Trigger -- Result / Fee / Paper --> NotifyParent["notifyParentByEmail\nresult, fee, paper schedule"]
    Trigger -- Forgot Password --> OTP["sendOtpEmail\nOTP for reset"]
    Trigger -- Exam assigned --> ExamNotif["teacher_create_exam.php\nsendNotificationAndEmail\n+ notifyParentByStudentId"]
    CredStudent --> Helper["includes/email_helper.php"]
    CredParent --> Helper
    NotifyParent --> Helper
    OTP --> Helper
    ExamNotif --> Helper
    Helper --> Config{"SMTP config?"}
    Config -- Missing --> Err["Log error, skip send"]
    Config -- OK --> PHPMailer["PHPMailer\nSMTP send"]
    PHPMailer --> Sent["Email sent\nor log to email_debug.log"]
```

---

Yeh file **WORKFLOW_CHART.md** ke saath use kar sakte ho. Diagrams ko **Mermaid** support wale editor (VS Code + Mermaid extension, GitHub, mermaid.live) mein dekh sakte ho.

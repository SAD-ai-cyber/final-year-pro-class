<?php
require '../includes/security.php';
require '../includes/config.php';

start_secure_session();
require_role('admin');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">
<title>System Logs</title>
<link rel="stylesheet" href="../css/responsive-core.css?v=<?php echo time(); ?>">

<style>
body { background:#f4f6f9; font-family:Arial; }

.main-card {
    background:#fff;
    border-radius:10px;
    padding:20px;
    box-shadow:0 3px 12px rgba(0,0,0,0.08);
}

.page-title {
    font-size:22px;
    font-weight:600;
    margin-bottom:20px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.export-btn{
    background:#28a745;
    color:white;
    padding:6px 12px;
    border:none;
    border-radius:4px;
    cursor:pointer;
}

.filter-row {
    display:flex;
    gap:10px;
    flex-wrap:wrap;
    margin-bottom:15px;
}

.filter-row input {
    padding:8px 12px;
    border:1px solid #ddd;
    border-radius:6px;
}

.log-table { width:100%; border-collapse:collapse; }

.log-table th {
    background:#f9fafc;
    font-size:13px;
    padding:12px;
    text-transform:uppercase;
    border-bottom:1px solid #eee;
}

.log-table td {
    padding:12px;
    border-bottom:1px solid #eee;
}

.log-table tr:hover { background:#f1f3f7; }

/* Footer like highlighted image */
.footer-bar {
    margin-top:15px;
    background:#f1f1f1;
    padding:10px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    border-radius:4px;
}

.footer-controls {
    display:flex;
    align-items:center;
    gap:5px;
}

.footer-controls select,
.footer-controls input[type="number"],
.footer-controls button {
    padding:5px 8px;
    border:1px solid #ccc;
    background:white;
    cursor:pointer;
    border-radius:4px;
}

.footer-controls input[type="number"] {
    width:70px;
    text-align:center;
    font-size:14px;
}

.footer-controls input[type="number"]:focus {
    outline:none;
    border-color:#007bff;
    box-shadow:0 0 0 2px rgba(0,123,255,0.1);
}

.footer-controls button.active {
    background:#007bff;
    color:white;
        border-color:#007bff;
    }
}

@media (max-width: 768px) {
    .page-title {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
    .export-btn {
        width: 100%;
        text-align: center;
    }
    .filter-row {
        flex-direction: column;
        align-items: stretch;
    }
    .filter-row input {
        width: 100% !important;
    }
    .footer-bar {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }
    .footer-controls {
        flex-wrap: wrap;
        justify-content: center;
    }
    .main-padding {
        padding: 15px !important;
    }
}
</style>
</head>

<body>

<div class="main-padding" style="padding:30px;">
<div class="main-card">

<div class="page-title">
    System Logs
    <button class="export-btn" onclick="exportCSV()">Export CSV</button>
</div>

<div class="filter-row">
    <input type="text" id="searchInput" placeholder="Search by Role or Name">
    <input type="date" id="startDate">
    <input type="date" id="endDate">
</div>

<div class="table-responsive">
<table class="log-table">
<thead>
<tr>
    <th>#</th>
    <th>Role</th>
    <th>Full Name</th>
    <th>Batch</th>
    <th>Date</th>
    <th>Time</th>
    <th>Action</th>
    <th>Admin Page</th>
    <th>Developer</th>
</tr>
</thead>
<tbody id="logBody">
<tr><td colspan="9" style="text-align:center;">Loading...</td></tr>
</tbody>
</table>
</div>

<div class="footer-bar">
    <div id="pageInfo">Showing page 1 of 1</div>

    <div class="footer-controls">
        Page Size
        <input type="number" id="pageSize" placeholder="10" min="1" max="1000">

        <button id="firstBtn">First</button>
        <button id="prevBtn">Prev</button>
        <button class="active" id="currentPageBtn">1</button>
        <button id="nextBtn">Next</button>
        <button id="lastBtn">Last</button>
    </div>
</div>

</div>
</div>

<script>
let currentPage = 1;
let perPage = 10;
let totalPages = 1;

let searchValue = '';
let startDateValue = '';
let endDateValue = '';

function getDashboardName(url) {
    if (!url) return '-';
    const file = url.split('/').pop().replace('.php','');
    return file.replace(/_/g,' ').replace(/\b\w/g,l=>l.toUpperCase());
}

function loadData(page=1) {
    currentPage = page;

    const params = new URLSearchParams({
        page: currentPage,
        per_page: perPage,
        search: searchValue,
        start_date: startDateValue,
        end_date: endDateValue
    });

    fetch('fetch_logs_ajax.php?' + params.toString())
    .then(res => res.json())
    .then(data => {

        if(data.status !== 'ok') return;

        const logs = data.logs;
        const total = data.total;

        totalPages = Math.ceil(total / perPage) || 1;

        document.getElementById('pageInfo').innerText =
            `Showing page ${currentPage} of ${totalPages}`;

        document.getElementById('currentPageBtn').innerText = currentPage;

        document.getElementById('prevBtn').disabled = currentPage <= 1;
        document.getElementById('firstBtn').disabled = currentPage <= 1;
        document.getElementById('nextBtn').disabled = currentPage >= totalPages;
        document.getElementById('lastBtn').disabled = currentPage >= totalPages;

        const tbody = document.getElementById('logBody');

        if(!logs.length){
            tbody.innerHTML = `<tr><td colspan="9" align="center">No Data Found</td></tr>`;
            return;
        }

        tbody.innerHTML = logs.map((log, index)=>`
            <tr>
                <td>${(currentPage-1)*perPage + index + 1}</td>
                <td>${log.role}</td>
                <td>${log.full_name}</td>
                <td>${log.batch || '-'}</td>
                <td>${log.timestamp.split(' ')[0]}</td>
                <td>${log.timestamp.split(' ')[1]}</td>
                <td>${log.action_type}</td>
                <td>${getDashboardName(log.page_url)}</td>
                <td>${log.page_url}</td>
            </tr>
        `).join('');
    });
}

/* Auto search (debounce) */
let debounceTimer;
document.getElementById('searchInput').addEventListener('input', function(){
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(()=>{
        searchValue = this.value.trim();
        loadData(1);
    },300);
});

document.getElementById('startDate').addEventListener('change', function(){
    startDateValue = this.value;
    loadData(1);
});
document.getElementById('endDate').addEventListener('change', function(){
    endDateValue = this.value;
    loadData(1);
});

let pageSizeDebounce;
const pageSizeInput = document.getElementById('pageSize');

// Load saved page size from localStorage or use default 10
const savedPageSize = localStorage.getItem('logsPageSize') || '10';
pageSizeInput.value = savedPageSize;
perPage = parseInt(savedPageSize);

// Handle both change and input events for better UX
pageSizeInput.addEventListener('input', function(){
    clearTimeout(pageSizeDebounce);
    
    // Validate input
    let value = parseInt(this.value);
    
    // Wait for user to finish typing (500ms debounce)
    pageSizeDebounce = setTimeout(() => {
        // Only validate if user has entered something
        if (this.value.trim() === '') {
            return; // Don't do anything if empty
        }
        
        if (isNaN(value) || value < 1) {
            value = 1; // minimum
            this.value = 1;
        } else if (value > 1000) {
            value = 1000; // max limit
            this.value = 1000;
        }
        
        perPage = value;
        localStorage.setItem('logsPageSize', value); // Save to localStorage
        loadData(1);
    }, 500);
});

pageSizeInput.addEventListener('change', function(){
    clearTimeout(pageSizeDebounce);
    
    // If empty, use default 10
    if (this.value.trim() === '') {
        this.value = 10;
        perPage = 10;
        localStorage.setItem('logsPageSize', 10);
        loadData(1);
        return;
    }
    
    let value = parseInt(this.value);
    
    if (isNaN(value) || value < 1) {
        value = 1;
        this.value = 1;
    } else if (value > 1000) {
        value = 1000;
        this.value = 1000;
    }
    
    perPage = value;
    localStorage.setItem('logsPageSize', value); // Save to localStorage
    loadData(1);
});

document.getElementById('firstBtn').onclick = ()=> loadData(1);
document.getElementById('prevBtn').onclick = ()=> loadData(currentPage-1);
document.getElementById('nextBtn').onclick = ()=> loadData(currentPage+1);
document.getElementById('lastBtn').onclick = ()=> loadData(totalPages);

function exportCSV(){
    const params = new URLSearchParams({
        search: searchValue,
        start_date: startDateValue,
        end_date: endDateValue
    });
    window.location.href = 'export_logs_csv.php?' + params.toString();
}

loadData();
</script>

</body>
</html>

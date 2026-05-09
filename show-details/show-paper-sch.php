<?php
require '../includes/config.php';
require '../includes/security.php';
require '../includes/notification_helper.php';

start_secure_session();
apply_security_headers();
require_role(['admin', 'teacher', 'parent', 'student']);
$csrf_token = generate_csrf_token();

$hasPermission = false;
if(isset($_SESSION['role']) && ($_SESSION['role']=='admin' || $_SESSION['role']=='teacher')){
    $hasPermission = true;
}

/* DELETE */
if(isset($_GET['delete_id']) && $hasPermission){
    if(!verify_csrf_token($_GET['csrf_token'] ?? '')){
        die('Invalid CSRF');
    }
    $id=(int)$_GET['delete_id'];

    $stmt=mysqli_prepare($con,"DELETE FROM paper_schedule WHERE paper_sch_id=?");
    mysqli_stmt_bind_param($stmt,"i",$id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: show-paper-sch.php");
    exit;
}

/* UPDATE */
if(isset($_POST['save_btn']) && $hasPermission){
    if(!verify_csrf_token($_POST['csrf_token'] ?? '')){
        die('Invalid CSRF');
    }

    $id=(int)$_POST['id'];

    $update_query="UPDATE paper_schedule SET 
        schedule_name=?,course_name=?,week_of=?,
        monday_module=?,monday_time=?,monday_end_time=?,monday_lab=?,
        tuesday_module=?,tuesday_time=?,tuesday_end_time=?,tuesday_lab=?,
        wednesday_module=?,wednesday_time=?,wednesday_end_time=?,wednesday_lab=?,
        thursday_module=?,thursday_time=?,thursday_end_time=?,thursday_lab=?,
        friday_module=?,friday_time=?,friday_end_time=?,friday_lab=?,
        saturday_module=?,saturday_time=?,saturday_end_time=?,saturday_lab=?
        WHERE paper_sch_id=?";

    $stmt=mysqli_prepare($con,$update_query);

    mysqli_stmt_bind_param($stmt,"sssssssssssssssssssssssssssi",
        $_POST['sch_name'],$_POST['course'],$_POST['week'],
        $_POST['mon_mod'],$_POST['mon_time'],$_POST['mon_end'],$_POST['mon_lab'],
        $_POST['tue_mod'],$_POST['tue_time'],$_POST['tue_end'],$_POST['tue_lab'],
        $_POST['wed_mod'],$_POST['wed_time'],$_POST['wed_end'],$_POST['wed_lab'],
        $_POST['thu_mod'],$_POST['thu_time'],$_POST['thu_end'],$_POST['thu_lab'],
        $_POST['fri_mod'],$_POST['fri_time'],$_POST['fri_end'],$_POST['fri_lab'],
        $_POST['sat_mod'],$_POST['sat_time'],$_POST['sat_end'],$_POST['sat_lab'],
        $id
    );

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: show-paper-sch.php");
    exit;
}

/* FETCH */
if($hasPermission){
    $query="SELECT * FROM paper_schedule ORDER BY week_of ASC";
}else{
    $query="SELECT * FROM paper_schedule
            WHERE week_of>=CURDATE()
            AND week_of<=DATE_ADD(CURDATE(),INTERVAL 14 DAY)
            ORDER BY week_of ASC";
}

$data=mysqli_query($con,$query);
$total=mysqli_num_rows($data);
?>

<!DOCTYPE html>
<html>
<head>
<title>Paper Schedules</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<style>
body{
    font-family:Segoe UI,Tahoma,sans-serif;
    background:#f4f6fb;
    margin:0;
}

.wrapper{
    max-width:1100px;
    margin:auto;
    padding:20px;
}

.page-title{
    background:linear-gradient(135deg,#919ac1);
    color:#fff;
    padding:16px;
    border-radius:10px;
    text-align:center;
    font-size:22px;
    font-weight:600;
    margin-bottom:25px;
}

.schedule-card{
    background:#fff;
    border-radius:12px;
    padding:18px 20px;
    margin-bottom:20px;
    box-shadow:0 3px 10px rgba(0,0,0,0.08);
}

.sch-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    border-bottom:1px solid #eee;
    padding-bottom:10px;
    margin-bottom:12px;
}

.sch-title{
    font-size:18px;
    font-weight:600;
    color:#333;
}

.sch-sub{
    font-size:13px;
    color:#888;
}

.action-btns a{
    margin-left:8px;
    font-size:17px;
}

.btn-edit{color:#f39c12;}
.btn-delete{color:#e74c3c;}

.schedule-table{
    width:100%;
    border-collapse:collapse;
    border: 2px solid #333;   /* outer border */
}

.schedule-table th{
    text-align:center;
    padding:8px 6px;
    font-size:13px;
    color:#333;
    border-bottom:1px solid #eee;
    background-color: #919ac1;
}

.schedule-table th,
.schedule-table td {
    border: 1px solid #333;   /* cell borders */
    padding: 10px 8px;
}

.schedule-table td{
    padding:10px 6px;
    border-bottom:1px solid #f1f1f1;
    font-size:14px;
    text-align-last: center;
    border-bottom-color: black;
}

.day-label{
    font-weight:600;
    color:#667eea;
}

.time-text{
    font-weight:500;
    color:#444;
}

.lab-text{
    color:#555;
}

input.input-box{
    width:100%;
    padding:6px;
    border-radius:6px;
    border:1px solid #ddd;
}

.btn-save{
    background:#28c76f;
    border:none;
    color:#fff;
    padding:8px 16px;
    border-radius:6px;
    cursor:pointer;
}

.btn-cancel{
    background:#aaa;
    color:#fff;
    padding:8px 14px;
    border-radius:6px;
    text-decoration:none;
    margin-left:6px;
}

@media(max-width:768px){
    .sch-header{
        flex-direction:column;
        align-items:flex-start;
        gap:8px;
    }
}
</style>
</head>

<body>
<div class="wrapper">
<div class="page-title">Manage Paper Schedules</div>

<form method="POST">
<input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">

<?php
if($total>0){
while($row=mysqli_fetch_assoc($data)){

/* EDIT MODE */
if(isset($_GET['edit_id']) && $_GET['edit_id']==$row['paper_sch_id'] && $hasPermission){
?>
<div class="schedule-card" style="border:2px solid #667eea;">
<input type="hidden" name="id" value="<?php echo $row['paper_sch_id']; ?>">

<div class="sch-header">
<div>
<input type="text" name="sch_name" value="<?php echo $row['schedule_name']; ?>" class="input-box" style="width:160px;">
<input type="text" name="course" value="<?php echo $row['course_name']; ?>" class="input-box" style="width:140px;">
<input type="date" name="week" value="<?php echo $row['week_of']; ?>" class="input-box" style="width:130px;">
</div>
</div>

<table class="schedule-table">
<tr>
<th>Day</th>
<th>Module</th>
<th>Time</th>
<th>Lab</th>
</tr>

<?php
$days=[
"Monday"=>"mon",
"Tuesday"=>"tue",
"Wednesday"=>"wed",
"Thursday"=>"thu",
"Friday"=>"fri",
"Saturday"=>"sat"
];

foreach($days as $label=>$prefix){
?>
<tr>
<td class="day-label"><?php echo $label; ?></td>
<td><input class="input-box" name="<?php echo $prefix;?>_mod" value="<?php echo $row[strtolower($label)."_module"]; ?>"></td>
<td>
<input class="input-box" style="width:90px;" type="time" name="<?php echo $prefix;?>_time" value="<?php echo $row[strtolower($label)."_time"]; ?>">
 -
<input class="input-box" style="width:90px;" type="time" name="<?php echo $prefix;?>_end" value="<?php echo $row[strtolower($label)."_end_time"]; ?>">
</td>
<td><input class="input-box" name="<?php echo $prefix;?>_lab" value="<?php echo $row[strtolower($label)."_lab"]; ?>"></td>
</tr>
<?php } ?>
</table>

<div style="margin-top:15px;text-align:right;">
<button type="submit" name="save_btn" class="btn-save">Save</button>
<a href="show-paper-sch.php" class="btn-cancel">Cancel</a>
</div>
</div>
<?php
}else{
/* VIEW MODE */
?>
<div class="schedule-card">
<div class="sch-header">
<div>
<div class="sch-title"><?php echo $row['schedule_name']; ?></div>
<div class="sch-sub">Course: <?php echo $row['course_name']; ?> | Week: <?php echo $row['week_of']; ?></div>
</div>

<?php if($hasPermission){ ?>
<div class="action-btns">
<a href="?edit_id=<?php echo $row['paper_sch_id']; ?>" class="btn-edit">
<i class="fa-solid fa-pen-to-square"></i>
</a>
<a href="?delete_id=<?php echo $row['paper_sch_id']; ?>&csrf_token=<?php echo urlencode($csrf_token); ?>" class="btn-delete" onclick="return confirm('Delete schedule?')">
<i class="fa-solid fa-trash"></i>
</a>
</div>
<?php } ?>
</div>

<table class="schedule-table">
<tr><th>Day</th><th>Module</th><th>Time</th><th>Lab</th></tr>

<?php
$days=[
"Monday"=>"monday",
"Tuesday"=>"tuesday",
"Wednesday"=>"wednesday",
"Thursday"=>"thursday",
"Friday"=>"friday",
"Saturday"=>"saturday"
];

foreach($days as $label=>$col){
?>
<tr>
<td class="day-label"><?php echo $label; ?></td>
<td><?php echo $row[$col."_module"]; ?></td>
<td class="time-text">
<?php
echo date('h:i A',strtotime($row[$col."_time"])) .
" - " .
date('h:i A',strtotime($row[$col."_end_time"]));
?>
</td>
<td class="lab-text"><?php echo $row[$col."_lab"]; ?></td>
</tr>
<?php } ?>

</table>
</div>
<?php
}
}
}else{
echo "<div class='schedule-card'><h3>No Upcoming Schedules</h3></div>";
}
?>

</form>
</div>
</body>
</html>

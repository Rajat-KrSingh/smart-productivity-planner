<?php
session_start();

// Security Check: Kick out anyone who hasn't logged in
if(!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Logout mechanism
if(isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}

$conn = mysqli_connect("localhost","root","","todo_project");

if(!$conn)
{
    die("Database Connection Failed");
}

/* Add or Update Task */
if(isset($_POST['save']))
{
    $task_id = $_POST['task_id']; 
    $task = $_POST['task'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $priority = $_POST['priority'];

    if(empty($task_id)) {
        // NEW Task
        mysqli_query($conn,"INSERT INTO tasks(task_name,task_date,task_time,priority,status) VALUES('$task','$date','$time','$priority','Pending')");
    } else {
        // UPDATE Existing Task
        mysqli_query($conn,"UPDATE tasks SET task_name='$task', task_date='$date', task_time='$time', priority='$priority' WHERE id=$task_id");
    }
    
    header("Location: toodoo.php");
    exit();
}

/* Mark Done */
if(isset($_GET['done']))
{
    $id = $_GET['done'];
    mysqli_query($conn,"UPDATE tasks SET status='Completed' WHERE id=$id");
    header("Location: toodoo.php");
    exit();
}

/* Undo Task */
if(isset($_GET['undo']))
{
    $id = $_GET['undo'];
    mysqli_query($conn,"UPDATE tasks SET status='Pending' WHERE id=$id");
    header("Location: toodoo.php");
    exit();
}

/* Delete Task */
if(isset($_GET['delete']))
{
    $id = $_GET['delete'];
    mysqli_query($conn,"DELETE FROM tasks WHERE id=$id");
    header("Location: toodoo.php");
    exit();
}

/* Stats */
$total = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM tasks"));
$done = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM tasks WHERE status='Completed'"));
$pending = $total - $done;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Smart Productivity Planner</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">

<style>
    *{ margin:0; padding:0; box-sizing:border-box; font-family:'Poppins',sans-serif; }
    
    body{
        min-height:100vh; padding:30px;
        background:linear-gradient(-45deg,#0f172a,#1e3a8a,#f97316,#ffffff);
        background-size:400% 400%;
        animation:bgMove 12s ease infinite;
    }
    
    @keyframes bgMove{
        0%{background-position:0% 50%;}
        50%{background-position:100% 50%;}
        100%{background-position:0% 50%;}
    }
    
    .container{
        max-width:1050px; margin:auto; background:white;
        padding:30px; border-radius:25px; box-shadow:0 10px 35px rgba(0,0,0,0.2);
    }
    
    h1{ text-align:center; font-size:34px; margin-bottom:20px; color:#111827; }
    
    .form-box{
        display:grid; grid-template-columns:2fr 1fr 1fr 1fr auto; gap:10px; margin-bottom:15px;
    }
    
    input,select,button{
        padding:12px; border:none; border-radius:12px; font-size:15px;
    }
    
    input,select{ background:#f3f4f6; outline:none; }
    
    button{ background:#f97316; color:white; font-weight:bold; cursor:pointer; transition: 0.3s; }
    button:hover{ background:#ea580c; }
    
    .stats{ display:flex; gap:15px; margin:20px 0; }
    
    .box{
        flex:1; padding:16px; text-align:center; border-radius:18px; color:white;
        font-size:18px; font-weight:bold;
    }
    
    .total{background:#1e3a8a;}
    .done{background:#16a34a;}
    .pending{background:#dc2626;}
    
    .filter-box{ margin:15px 0; }
    
    table{ width:100%; border-collapse:collapse; margin-top:10px; }
    th,td{ padding:12px; text-align:center; border-bottom:1px solid #ddd; }
    th{ background:#1e3a8a; color:white; }
    
    .high{color:red;font-weight:bold;}
    .medium{color:orange;font-weight:bold;}
    .low{color:green;font-weight:bold;}
    
    .time-text { font-size: 12px; color: #555; display: block; margin-top: 3px; font-weight: 500;}
    
    a{
        text-decoration:none; padding:7px 12px; border-radius:8px;
        color:white; font-size:13px; margin:2px; display:inline-block; transition: 0.3s; cursor: pointer;
    }
    
    .donebtn{background:#16a34a;} .donebtn:hover{background:#15803d;}
    .delbtn{background:#dc2626;} .delbtn:hover{background:#b91c1c;}
    .editbtn{background:#2563eb;} .editbtn:hover{background:#1d4ed8;}
    .undobtn{background:#64748b;} .undobtn:hover{background:#475569;}
    
    footer{ text-align:center; margin-top:25px; font-size:13px; color:#666; }
</style>
</head>

<body>

<div class="container">
    
    <div style="text-align: right; margin-bottom: 10px;">
        <a href="?logout=true" style="background:#dc2626; color:white; padding:8px 15px; border-radius:8px; text-decoration:none; font-size:14px; font-weight:bold;">Logout</a>
    </div>

    <h1>Smart Productivity Planner</h1>

    <form method="post">
        <div class="form-box">
            <input type="hidden" name="task_id" id="formId">
            <input type="text" name="task" id="formTask" placeholder="Enter Task Title" required>
            <input type="date" name="date" id="formDate" min="<?php echo date('Y-m-d'); ?>" required>
            <input type="time" name="time" id="formTime" required> 
            <select name="priority" id="formPriority">
                <option value="High">High</option>
                <option value="Medium">Medium</option>
                <option value="Low">Low</option>
            </select>
            <button type="submit" name="save" id="formSubmitBtn">Add Task</button>
        </div>
    </form>

    <div class="stats">
        <div class="box total">Total<br><?php echo $total; ?></div>
        <div class="box done">Completed<br><?php echo $done; ?></div>
        <div class="box pending">Pending<br><?php echo $pending; ?></div>
    </div>

    <div class="filter-box">
        <select id="priorityFilter">
            <option value="All">All Priorities</option>
            <option value="High">High</option>
            <option value="Medium">Medium</option>
            <option value="Low">Low</option>
        </select>
    </div>

    <table>
        <thead>
            <tr>
                <th>Task</th>
                <th>Deadline</th>
                <th>Priority</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="taskTableBody">

        <?php
        $data = mysqli_query($conn,"SELECT * FROM tasks ORDER BY task_date ASC, task_time ASC");

        while($row = mysqli_fetch_assoc($data))
        {
            $p = strtolower($row['priority']);
            $formatted_time = date("h:i A", strtotime($row['task_time']));
            $safe_name = htmlspecialchars($row['task_name'], ENT_QUOTES);
            
            // Swap Done/Undo button dynamically
            $status_button = "";
            if ($row['status'] == 'Completed') {
                $status_button = "<a class='undobtn' href='?undo=".$row['id']."'>Undo</a>";
            } else {
                $status_button = "<a class='donebtn' href='?done=".$row['id']."'>Done</a>";
            }
            
            echo "<tr class='task-row' data-priority='".$row['priority']."'>
                <td>".$row['task_name']."</td>
                <td>
                    ".$row['task_date']."
                    <span class='time-text'>".$formatted_time."</span>
                </td>
                <td class='$p'>".$row['priority']."</td>
                <td>".$row['status']."</td>
                <td>
                    <a class='editbtn' onclick='editTask(".$row['id'].", \"".$safe_name."\", \"".$row['task_date']."\", \"".$row['task_time']."\", \"".$row['priority']."\")'>Edit</a>
                    ".$status_button."
                    <a class='delbtn' href='?delete=".$row['id']."'>Delete</a>
                </td>
            </tr>";
        }
        ?>
        
        </tbody>
    </table>

    <footer>Sarthak Srivastav & Rajat</footer>

</div>

<script>
    // --- 1. Filter Script ---
    const filterDropdown = document.getElementById('priorityFilter');
    filterDropdown.addEventListener('change', function() {
        const selectedPriority = this.value;
        const rows = document.querySelectorAll('.task-row');
        
        rows.forEach(row => {
            const rowPriority = row.getAttribute('data-priority');
            if(selectedPriority === 'All' || rowPriority === selectedPriority) {
                row.style.display = ''; 
            } else {
                row.style.display = 'none'; 
            }
        });
    });

    // --- 2. Edit Task Script ---
    function editTask(id, name, date, time, priority) {
        document.getElementById('formId').value = id;
        document.getElementById('formTask').value = name;
        document.getElementById('formDate').value = date;
        document.getElementById('formTime').value = time;
        document.getElementById('formPriority').value = priority;
        
        let btn = document.getElementById('formSubmitBtn');
        btn.innerHTML = "Update Task";
        btn.style.background = "#2563eb"; 
        
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
</script>

</body>
</html>
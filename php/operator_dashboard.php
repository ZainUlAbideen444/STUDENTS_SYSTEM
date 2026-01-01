<?php
session_start();
include "db.php";

if(!isset($_SESSION['role']) || $_SESSION['role']!=='operator'){
    header("Location: login.php"); exit;
}

/* ---------- ADD ACTIONS ---------- */
if(isset($_POST['add_student'])){
    mysqli_query($conn,"INSERT INTO students(name,email,phone,course_id)
    VALUES('$_POST[name]','$_POST[email]','$_POST[phone]','$_POST[course]')");
}
if(isset($_POST['add_course'])){
    mysqli_query($conn,"INSERT INTO courses(course_name,fee,duration)
    VALUES('$_POST[course_name]','$_POST[fee]','$_POST[duration]')");
}
if(isset($_POST['add_payment'])){
    mysqli_query($conn,"INSERT INTO payments(student_id,course_id,amount_paid,payment_method,payment_date)
    VALUES('$_POST[student]','$_POST[course]','$_POST[amount]','$_POST[method]','$_POST[date]')");
}



/* ---------- FETCH ---------- */
$students = mysqli_query($conn,"SELECT s.*,c.course_name FROM students s LEFT JOIN courses c ON s.course_id=c.id");
$courses  = mysqli_query($conn,"SELECT * FROM courses");
$payments = mysqli_query($conn,"SELECT p.*,s.name,c.course_name FROM payments p 
LEFT JOIN students s ON p.student_id=s.id
LEFT JOIN courses c ON p.course_id=c.id");

$tab = $_GET['tab'] ?? 'student';
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin Panel</title>
<link rel="stylesheet" href="../css/admin.css">
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
<h2>OPERATOR</h2>
<a href="?tab=student">Add Student</a>
<a href="?tab=course">Add Course</a>
<a href="?tab=payment">Add Payment</a>
<a href="?tab=show">Show Data</a>
<a href="logout.php" class="logout">Logout</a>
</div>

<div class="main">

<!-- ADD STUDENT -->
<?php if($tab=='student'){ ?>
<h1>Add Student</h1>
<form method="POST">
<input name="name" placeholder="Name" required>
<input name="email" placeholder="Email" required>
<input name="phone" placeholder="Phone" required>
<select name="course" required>
<option value="">Select Course</option>
<?php mysqli_data_seek($courses,0); while($c=mysqli_fetch_assoc($courses)){ ?>
<option value="<?= $c['id'] ?>"><?= $c['course_name'] ?></option>
<?php } ?>
</select>
<button name="add_student">Save</button>
</form>
<?php } ?>

<!-- ADD COURSE -->
<?php if($tab=='course'){ ?>
<h1>Add Course</h1>
<form method="POST">
<input name="course_name" placeholder="Course Name" required>
<input name="fee" placeholder="Fee" required>
<input name="duration" placeholder="Duration" required>
<button name="add_course">Save</button>
</form>
<?php } ?>

<!-- ADD PAYMENT -->
<?php if($tab=='payment'){ ?>
<h1>Add Payment</h1>
<form method="POST">
<select name="student" required>
<option value="">Student</option>
<?php mysqli_data_seek($students,0); while($s=mysqli_fetch_assoc($students)){ ?>
<option value="<?= $s['id'] ?>"><?= $s['name'] ?></option>
<?php } ?>
</select>

<select name="course" required>
<option value="">Course</option>
<?php mysqli_data_seek($courses,0); while($c=mysqli_fetch_assoc($courses)){ ?>
<option value="<?= $c['id'] ?>"><?= $c['course_name'] ?></option>
<?php } ?>
</select>

<input name="amount" placeholder="Amount" required>
<input name="method" placeholder="Method" required>
<input type="date" name="date" required>
<button name="add_payment">Save</button>
</form>
<?php } ?>

<!-- SHOW DATA -->
<?php if($tab=='show'){ ?>
<h1>All Records</h1>

<h3>Students</h3>
<table>
<tr><th>Name</th><th>Email</th><th>Phone</th><th>Course</th></tr>
<?php while($s=mysqli_fetch_assoc($students)){ ?>
<tr>
<td><?= $s['name'] ?></td>
<td><?= $s['email'] ?></td>
<td><?= $s['phone'] ?></td>
<td><?= $s['course_name'] ?></td>
</tr>
<?php } ?>
</table>

<h3>Courses</h3>
<table>
<tr><th>Name</th><th>Fee</th><th>Duration</th></tr>
<?php while($c=mysqli_fetch_assoc($courses)){ ?>
<tr>
<td><?= $c['course_name'] ?></td>
<td><?= $c['fee'] ?></td>
<td><?= $c['duration'] ?></td>
</tr>
<?php } ?>
</table>

<h3>Payments</h3>
<table>
<tr><th>Student</th><th>Course</th><th>Amount</th><th>Method</th><th>Date</th></tr>
<?php while($p=mysqli_fetch_assoc($payments)){ ?>
<tr>
<td><?= $p['name'] ?></td>
<td><?= $p['course_name'] ?></td>
<td><?= $p['amount_paid'] ?></td>
<td><?= $p['payment_method'] ?></td>
<td><?= $p['payment_date'] ?></td>
</tr>
<?php } ?>
</table>
<?php } ?>

</div>
</body>
</html>

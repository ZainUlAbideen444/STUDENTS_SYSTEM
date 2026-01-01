<?php
session_start();
include "db.php";

/* SECURITY */
if(!isset($_SESSION['role']) || $_SESSION['role']!=='user'){
    header("Location: login.php");
    exit;
}

/* FETCH DATA */
$students = mysqli_query($conn,"
    SELECT s.id,s.name,s.email,s.phone,c.course_name
    FROM students s
    LEFT JOIN courses c ON s.course_id=c.id
");

$courses = mysqli_query($conn,"SELECT * FROM courses");

$payments = mysqli_query($conn,"
    SELECT p.id,s.name AS student,c.course_name,p.amount_paid,p.payment_method,p.payment_date
    FROM payments p
    LEFT JOIN students s ON p.student_id=s.id
    LEFT JOIN courses c ON p.course_id=c.id
");

$tab = $_GET['tab'] ?? 'students';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>User Dashboard</title>
<link rel="stylesheet" href="../css/user.css">
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>User Panel</h2>
    <a href="?tab=students" class="<?= $tab=='students'?'active':'' ?>">Students</a>
    <a href="?tab=courses" class="<?= $tab=='courses'?'active':'' ?>">Courses</a>
    <a href="?tab=payments" class="<?= $tab=='payments'?'active':'' ?>">Payments</a>
    <a href="logout.php" class="logout">Logout</a>
</div>

<!-- MAIN -->
<div class="main">
<h1>View Data</h1>

<?php if($tab=='students'){ ?>
<h2>Students</h2>
<table>
<tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Course</th></tr>
<?php while($s=mysqli_fetch_assoc($students)){ ?>
<tr>
<td><?= $s['id'] ?></td>
<td><?= $s['name'] ?></td>
<td><?= $s['email'] ?></td>
<td><?= $s['phone'] ?></td>
<td><?= $s['course_name'] ?></td>
</tr>
<?php } ?>
</table>
<?php } ?>

<?php if($tab=='courses'){ ?>
<h2>Courses</h2>
<table>
<tr><th>ID</th><th>Course</th><th>Fee</th><th>Duration</th></tr>
<?php while($c=mysqli_fetch_assoc($courses)){ ?>
<tr>
<td><?= $c['id'] ?></td>
<td><?= $c['course_name'] ?></td>
<td><?= $c['fee'] ?></td>
<td><?= $c['duration'] ?></td>
</tr>
<?php } ?>
</table>
<?php } ?>

<?php if($tab=='payments'){ ?>
<h2>Payments</h2>
<table>
<tr><th>ID</th><th>Student</th><th>Course</th><th>Amount</th><th>Method</th><th>Date</th></tr>
<?php while($p=mysqli_fetch_assoc($payments)){ ?>
<tr>
<td><?= $p['id'] ?></td>
<td><?= $p['student'] ?></td>
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

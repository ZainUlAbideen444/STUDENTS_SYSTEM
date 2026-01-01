<?php
session_start();
include 'db.php';
if(!isset($_SESSION['role'])) { header("Location: login.php"); exit(); }

$students = mysqli_query($conn,"SELECT * FROM students");
$courses  = mysqli_query($conn,"SELECT * FROM courses");

if(isset($_POST['save_payment'])){
    $student_id = $_POST['student_id'];
    $course_id  = $_POST['course_id'];
    $amount     = $_POST['amount'];
    $method     = $_POST['method'];
    $date       = $_POST['date'];

    mysqli_query($conn,"INSERT INTO payments
        (student_id, course_id, amount_paid, payment_method, payment_date)
        VALUES ('$student_id','$course_id','$amount','$method','$date')");
    $msg = "Payment Added Successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Payment</title>
<link rel="stylesheet" href="styles.css">
</head>
<body>
<h2>Add Payment</h2>
<?php if(isset($msg)) echo "<p style='color:green;'>$msg</p>"; ?>
<form method="POST" class="modern-form">
    <select name="student_id" required>
        <option value="">Select Student</option>
        <?php while($s = mysqli_fetch_assoc($students)){ ?>
            <option value="<?= $s['id']; ?>"><?= $s['name']; ?></option>
        <?php } ?>
    </select><br>

    <select name="course_id" required>
        <option value="">Select Course</option>
        <?php while($c = mysqli_fetch_assoc($courses)){ ?>
            <option value="<?= $c['id']; ?>"><?= $c['course_name']; ?></option>
        <?php } ?>
    </select><br>

    <input type="number" name="amount" placeholder="Amount Paid" required><br>
    <input type="text" name="method" placeholder="Payment Method" required><br>
    <input type="date" name="date" required><br>

    <?php if($_SESSION['role'] != 'user'){ ?>
    <button type="submit" name="save_payment">Submit</button>
    <?php } ?>
</form>
</body>
</html>

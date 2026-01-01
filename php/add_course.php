<?php
session_start();
include 'db.php';
if(!isset($_SESSION['role'])) { header("Location: login.php"); exit(); }

if(isset($_POST['save_course'])){
    $course_name = $_POST['course_name'];
    $fee = $_POST['fee'];
    $duration = $_POST['duration'];

    mysqli_query($conn,"INSERT INTO courses (course_name,fee,duration)
                        VALUES ('$course_name','$fee','$duration')");
    $msg = "Course Added Successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Course</title>
<link rel="stylesheet" href="styles.css">
</head>
<body>
<h2>Add Course</h2>
<?php if(isset($msg)) echo "<p style='color:green;'>$msg</p>"; ?>
<form method="POST" class="modern-form">
    <input type="text" name="course_name" placeholder="Course Name" required><br>
    <input type="number" name="fee" placeholder="Fees" required><br>
    <input type="text" name="duration" placeholder="Duration" required><br>
    <?php if($_SESSION['role'] != 'user'){ ?>
    <button type="submit" name="save_course">Submit</button>
    <?php } ?>
</form>
</body>
</html>

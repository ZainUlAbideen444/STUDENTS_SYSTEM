<?php
session_start();
include 'db.php';
if(!isset($_SESSION['role'])) { header("Location: login.php"); exit(); }

if(isset($_POST['save_student'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $course_id = $_POST['course_id'];

    $query = "INSERT INTO students (name,email,phone,course_id)
              VALUES ('$name','$email','$phone','$course_id')";
    mysqli_query($conn,$query);
    $msg = "Student Added Successfully!";
}

$courses = mysqli_query($conn,"SELECT * FROM courses");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Student</title>
<link rel="stylesheet" href="styles.css">
</head>
<body>
<h2>Add Student</h2>
<?php if(isset($msg)) echo "<p style='color:green;'>$msg</p>"; ?>
<form method="POST" class="modern-form">
    <input type="text" name="name" placeholder="Student Name" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="text" name="phone" placeholder="Phone" required><br>
    <select name="course_id" required>
        <option value="">Select Course</option>
        <?php while($c = mysqli_fetch_assoc($courses)){ ?>
            <option value="<?= $c['id']; ?>"><?= $c['course_name']; ?></option>
        <?php } ?>
    </select><br>
    <?php if($_SESSION['role'] != 'user'){ ?>
    <button type="submit" name="save_student">Submit</button>
    <?php } ?>
</form>
</body>
</html>

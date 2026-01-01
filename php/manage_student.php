<?php
session_start();
include 'db.php';
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit();
}

$students = mysqli_query($conn, "SELECT s.id,s.name,s.email,s.phone,c.course_name
                                 FROM students s
                                 LEFT JOIN courses c ON s.course_id=c.id");
?>


<h2>Manage Students</h2>
<table border="1" cellpadding="8">
<tr>
    <th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Course</th><th>Actions</th>
</tr>
<?php while($row=mysqli_fetch_assoc($students)){ ?>
<tr>
    <td><?= $row['id']; ?></td>
    <td><?= $row['name']; ?></td>
    <td><?= $row['email']; ?></td>
    <td><?= $row['phone']; ?></td>
    <td><?= $row['course_name']; ?></td>
    <td>
        <a href="edit_student.php?id=<?= $row['id']; ?>">Edit</a> |
        <a href="delete_student.php?id=<?= $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
    </td>
</tr>
<?php } ?>
</table>

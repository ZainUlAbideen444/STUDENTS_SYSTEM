<?php
session_start();
include 'db.php';

if(isset($_POST['login'])){
    $username = mysqli_real_escape_string($conn,$_POST['username']);
    $password = md5($_POST['password']);

    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn,$query);

    if(mysqli_num_rows($result) == 1){
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['name'] = $user['name'];

        if($user['role'] == 'admin') header("Location: admin_dashboard.php");
        elseif($user['role'] == 'operator') header("Location: operator_dashboard.php");
        elseif($user['role'] == 'user') header("Location: user_dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login - Training System</title>
<link rel="stylesheet" href="../css/styles.css">
</head>
<body>
<div class="form-wrapper">
<form method="POST" class="modern-form">
    <h2>Login</h2>
    <?php if(isset($error)){ echo "<p style='color:red;'>$error</p>"; } ?>
    <div class="input-group">
        <input type="text" name="username" required>
        
    </div>
    <div class="input-group">
        <input type="password" name="password" required>
       
    </div>
    <button type="submit" name="login">Login</button>
</form>
</div>
</body>
</html>

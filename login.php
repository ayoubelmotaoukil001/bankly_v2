<?php

require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);
    
    if ($result->num_rows == 1) {
        $_SESSION['user'] = $username;
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Bankly V2</title>
     <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="all">
    <h2 class="head">Bankly V2 - Login</h2>
    
    <?php if (isset($error)) { echo "<p style='color:red'>$error</p>"; } ?>
    <div class="form">
      
        <form method="POST" action="">
            <div>
                <label>Username</label>
                <input type="text" name="username" required>
            </div>
            <div>
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <div class="buttonn">
                <button type="submit">Login</button>
            </div>
        
        </form>
    </div>
    </div>
</body>
</html>
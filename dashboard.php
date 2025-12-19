<?php

require_once 'config.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user_count = 0;
$account_count = 0;
$today_transactions = 0;

$sql1 = "SELECT COUNT(*) as count FROM clients";
$result1 = $conn->query($sql1);
if ($result1) {
    $row = $result1->fetch_assoc();
    $user_count = $row['count'];
}

$sql2 = "SELECT COUNT(*) as count FROM accounts";
$result2 = $conn->query($sql2);
if ($result2) {
    $row = $result2->fetch_assoc();
    $account_count = $row['count'];
}

$today = date('Y-m-d');
$sql3 = "SELECT COUNT(*) as count FROM transactions WHERE DATE(date) = '$today'";
$result3 = $conn->query($sql3);
if ($result3) {
    $row = $result3->fetch_assoc();
    $today_transactions = $row['count'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Bankly V2</title>
     <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <h2 class="headerr"> Dashboard</h2>
<div class="navv">
    <ul class="navbar">
        <li><a href="clients.php"> Clients</a></li>
        <li><a href="accounts.php"> Accounts</a></li>
        <li><a href="transactions.php"> Transactions</a></li>
        <li><a href="logout.php" class="logout">Logout</a></p></li>
    </ul>
</div>
    <p class="welcome">Welcome <?php echo $_SESSION['user']; ?> 
    
    <h3 class="quixk">Quick Statistics</h3>
 <div class="contain">
    <ul class="par">
        <li class="chi1">
             Clients: <?php echo $user_count; ?></li>
        <li class="chi2">
             Accounts: <?php echo $account_count; ?></li>
        <li class="chi3">gi
             Transactions: <?php echo $today_transactions; ?></li>
    </ul>
 </div>

    
  
</body>
</html>
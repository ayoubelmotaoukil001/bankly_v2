<?php

require_once 'config.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $client_id = $_POST['client_id'];
    $account_number = $_POST['account_number'];
    $account_type = $_POST['account_type'];
    $balance = $_POST['balance'];
    
    $sql = "INSERT INTO accounts (client_id, account_number, account_type, balance) 
            VALUES ($client_id, '$account_number', '$account_type', $balance)";
    $conn->query($sql);
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM accounts WHERE id = $id";
    $conn->query($sql);
}

$clients_result = $conn->query("SELECT id, name FROM clients");
$accounts_result = $conn->query("SELECT a.*, c.name as client_name FROM accounts a JOIN clients c ON a.client_id = c.id");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Accounts - Bankly V2</title>
    <link rel="stylesheet" href="account.css">
</head>
<body>

<h2 class="headerr">Manage Accounts</h2>
<p><a class="back" href="dashboard.php">Back to Dashboard</a></p>

<h3 class="quixk">Add New Account</h3>
<form method="POST" action="" class="client-form">
    <div class="form-group">
        <label>Client:</label>
        <select name="client_id" required>
            <option value="">Select Client</option>
            <?php while($client = $clients_result->fetch_assoc()) { ?>
            <option value="<?php echo $client['id']; ?>"><?php echo $client['name']; ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group">
        <label>Account Number:</label>
        <input type="text" name="account_number" required>
    </div>
    <div class="form-group">
        <label>Account Type:</label>
        <select name="account_type" required>
            <option value="current">Current</option>
            <option value="savings">Savings</option>
        </select>
    </div>
    <div class="form-group">
        <label>Initial Balance:</label>
        <input type="number" name="balance" step="0.01" required>
    </div>
    <div>
        <button type="submit" name="add" class="btn">Add Account</button>
    </div>
</form>

<h3 class="quixk">Accounts List</h3>
<table class="clients-table" border="1">
    <tr>
        <th>ID</th>
        <th>Account Number</th>
        <th>Client</th>
        <th>Type</th>
        <th>Balance</th>
        <th>Actions</th>
    </tr>
    <?php while($row = $accounts_result->fetch_assoc()) { ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['account_number']; ?></td>
        <td><?php echo $row['client_name']; ?></td>
        <td><?php echo $row['account_type']; ?></td>
        <td><?php echo $row['balance']; ?></td>
        <td>
            <a class="delete" href="?delete=<?php echo $row['id']; ?>">Delete</a>
        </td>
    </tr>
    <?php } ?>
</table>

</body>
</html>

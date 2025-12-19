<?php
// transactions.php
require_once 'config.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['make_transaction'])) {
    $account_id = $_POST['account_id'];
    $transaction_type = $_POST['transaction_type'];
    $amount = $_POST['amount'];
    $description = $_POST['description'];
    
    $sql = "INSERT INTO transactions (account_id, type, amount, description) 
            VALUES ($account_id, '$transaction_type', $amount, '$description')";
    
    if ($conn->query($sql)) {
        if ($transaction_type == 'deposit') {
            $update_sql = "UPDATE accounts SET balance = balance + $amount WHERE id = $account_id";
        } else {
            $update_sql = "UPDATE accounts SET balance = balance - $amount WHERE id = $account_id";
        }
        $conn->query($update_sql);
        $message = "Transaction completed successfully";
    } else {
        $error = "Error processing transaction";
    }
}

$accounts_result = $conn->query("SELECT a.*, c.name as client_name FROM accounts a JOIN clients c ON a.client_id = c.id");
$transactions_result = $conn->query("SELECT t.*, a.account_number FROM transactions t JOIN accounts a ON t.account_id = a.id ORDER BY t.date DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Transactions - Bankly V2</title>
    <link rel="stylesheet" href="tran.css">
</head>
<body>

<h2 class="headerr">Manage Transactions</h2>
<p><a class="back" href="dashboard.php">Back to Dashboard</a></p>

<?php if (isset($message)) { echo "<p class='message-success'>$message</p>"; } ?>
<?php if (isset($error)) { echo "<p class='message-error'>$error</p>"; } ?>

<h3 class="quixk">Make Transaction</h3>
<form method="POST" action="" class="client-form">
    <div class="form-group">
        <label>Account:</label>
        <select name="account_id" required>
            <option value="">Select Account</option>
            <?php while($account = $accounts_result->fetch_assoc()) { ?>
            <option value="<?php echo $account['id']; ?>">
                <?php echo $account['account_number'] . " - " . $account['client_name']; ?>
            </option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group">
        <label>Transaction Type:</label>
        <select name="transaction_type" required>
            <option value="deposit">Deposit</option>
            <option value="withdrawal">Withdrawal</option>
        </select>
    </div>
    <div class="form-group">
        <label>Amount:</label>
        <input type="number" name="amount" step="0.01" min="0" required>
    </div>
    <div class="form-group">
        <label>Description:</label>
        <input type="text" name="description">
    </div>
    <div>
        <button type="submit" name="make_transaction" class="btn">Process Transaction</button>
    </div>
</form>

<h3 class="quixk">Transactions History</h3>
<table class="clients-table" border="1">
    <tr>
        <th>ID</th>
        <th>Account Number</th>
        <th>Type</th>
        <th>Amount</th>
        <th>Description</th>
        <th>Date</th>
    </tr>
    <?php while($row = $transactions_result->fetch_assoc()) { ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['account_number']; ?></td>
        <td><?php echo $row['type']; ?></td>
        <td><?php echo $row['amount']; ?></td>
        <td><?php echo $row['description']; ?></td>
        <td><?php echo $row['date']; ?></td>
    </tr>
    <?php } ?>
</table>

</body>
</html>

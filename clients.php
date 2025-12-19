<?php

require_once 'config.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $cin = $_POST['cin'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    
    $sql = "INSERT INTO clients (name, email, cin, phone, address) 
            VALUES ('$name', '$email', '$cin', '$phone', '$address')";
    $conn->query($sql);
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM clients WHERE id = $id";
    $conn->query($sql);
}

$sql = "SELECT * FROM clients";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Clients - Bankly V2</title>
    <link rel="stylesheet" href="client.css">
</head>
<body>

<h2 class="headerr">Manage Clients</h2>
<p><a class="back" href="dashboard.php">Back to Dashboard</a></p>

<h3 class="quixk">Add New Client</h3>
<form method="POST" action="" class="client-form">
    <div class="form-group">
        <label>Full Name</label>
        <input type="text" name="name" required>
    </div>
    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" required>
    </div>
    <div class="form-group">
        <label>CIN</label>
        <input type="text" name="cin" required>
    </div>
    <div class="form-group">
        <label>Phone </label>
        <input type="text" name="phone">
    </div>
    <div class="form-group">
        <label>Address</label>
        <textarea name="address"></textarea>
    </div>
    <div>
        <button type="submit" name="add" class="btn">Add Client</button>
    </div>
</form>

<h3 class="quixk">Clients List</h3>
<table class="clients-table" border="1">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>ID Number</th>
        <th>Phone</th>
        <th>Actions</th>
    </tr>
    <?php while($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['name']; ?></td>
        <td><?php echo $row['email']; ?></td>
        <td><?php echo $row['cin']; ?></td>
        <td><?php echo $row['phone']; ?></td>
        <td>
            <a class="delete" href="?delete=<?php echo $row['id']; ?>">Delete</a>
        </td>
    </tr>
    <?php } ?>
</table>

</body>
</html>

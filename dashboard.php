<?php

if (!isset($_COOKIE['user_role'])) {
   header("Location: /access_denied.php");
   exit();
}

if ($_COOKIE['user_role'] !== 'other_user' && $_COOKIE['user_role'] !== 'admin') {
   header("Location: /access_denied.php");
   exit();
}

$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'broken_auth';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_COOKIE['user_id'];

$sql = "SELECT username, balance FROM users WHERE id = $user_id";
$result = $conn->query($sql);

if ($result && $row = $result->fetch_assoc()) {
    $username = $row['username'];
    $balance = $row['balance'];
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {
    font-family: Arial, Helvetica, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
}

.header {
    background-color: #333;
    color: white;
    padding: 20px;
    text-align: center;
}

.balance-container {
    background-color: #04AA6D;
    color: white;
    text-align: center;
    padding: 50px 20px;
    margin: 20px auto;
    border-radius: 10px;
    width: 80%;
    max-width: 600px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.balance-container h1 {
    font-size: 48px;
    margin: 0;
}

.balance-container p {
    font-size: 36px; 
    font-weight: bold;
    margin: 10px 0 0;
}

.navbar {
    overflow: hidden;
    background-color: #333;
}

.navbar a {
    float: left;
    display: block;
    color: #f2f2f2;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
    font-size: 17px;
    cursor: pointer;
}

.navbar a:hover {
    background-color: #ddd;
    color: black;
}

.container {
    padding: 20px;
    margin: 20px auto;
    width: 80%;
    max-width: 600px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    display: none; /* Initially hidden */
}

.container h2 {
    text-align: center;
    margin-bottom: 20px;
}

.container form {
    display: flex;
    flex-direction: column;
}

.container form label {
    margin-bottom: 10px;
    font-weight: bold;
}

.container form input {
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
}

.container form button {
    background-color: #04AA6D;
    color: white;
    padding: 10px;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
}

.container form button:hover {
    background-color: #039e5a;
}
</style>
<script>
function toggleSendMoneyForm() {
    const formContainer = document.querySelector('.container');
    if (formContainer.style.display === 'none' || formContainer.style.display === '') {
        formContainer.style.display = 'block';
    } else {
        formContainer.style.display = 'none';
    }
}
</script>
</head>
<body>

<div class="header">
    <h1>Welcome, <?php echo ucfirst($username); ?>!</h1>
</div>

<div class="balance-container">
    <h1>Your Balance</h1>
    <p>$<?php echo number_format($balance, 2); ?></p>
</div>

<div class="navbar">
    <a href="#details">Account Details</a>
    <a href="#transactions">Transactions</a>
    <a onclick="toggleSendMoneyForm()">Send Money</a>
    <a href="#credit">Apply For Credit</a>
    <a href="#loans">Auto Loans</a>
    <a href="#contact">Mortgage Loans</a>
    <a href="#contact">Contact</a>
</div>

<div class="container">
    <h2>Send Money</h2>
    <form action="transfer.php" method="POST">
        <label for="recipient"><b>Recipient Username</b></label>
        <input type="text" name="recipient" placeholder="Enter recipient's username" required>

        <label for="amount"><b>Amount</b></label>
        <input type="number" name="amount" placeholder="Enter amount to transfer" step="0.01" min="0.01" required>

        <button type="submit">Send Money</button>
    </form>
</div>

</body>
</html>

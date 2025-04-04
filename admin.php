<?php

if (!isset($_COOKIE['user_role']) || $_COOKIE['user_role'] !== 'admin') {
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

$users = [];
$sql = "SELECT * FROM users WHERE username NOT IN ('admin', 'root', 'dev')";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
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

.navbar {
    overflow: hidden;
    background-color: #333;
    display: flex;
    justify-content: center;
}

.navbar a {
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
    max-width: 800px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    display: none; /* Initially hidden */
}

.container h2 {
    text-align: center;
    margin-bottom: 20px;
}

.container table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

.container table th, .container table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

.container table th {
    background-color: #04AA6D;
    color: white;
}

.container pre {
    background-color: #f4f4f4;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    overflow-x: auto;
}
</style>
<script>
function toggleSection(sectionId) {
    const sections = document.querySelectorAll('.container');
    sections.forEach(section => {
        if (section.id === sectionId) {
            section.style.display = section.style.display === 'none' || section.style.display === '' ? 'block' : 'none';
        } else {
            section.style.display = 'none';
        }
    });
}
</script>
</head>
<body>

<div class="header">
    <h1>Admin Dashboard</h1>
</div>

<div class="navbar">
    <a onclick="toggleSection('users-section')">User Information</a>
    <a href="#keys">Developer Keys</a>
    <a href="#usermods">Modify Accounts</a>
    <a href="#direct">Employee Directory</a>
    <a href="#support">Support</a>

</div>

<div id="users-section" class="container">
    <h2>User Information</h2>
    <table>
        <thead>
            <tr>
                <th>Username</th>
                <th>Password</th>
                <th>Social Security Number</th>
                <th>Balance</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo htmlspecialchars($user['username']); ?></td>
                <td><?php echo htmlspecialchars($user['password']); ?></td>
                <td><?php echo htmlspecialchars($user['ssn']); ?></td>
                <td>$<?php echo number_format($user['balance'], 2); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>

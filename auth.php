<?php
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'broken_auth';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uname = $_POST['uname'];
    $psw = $_POST['psw'];

    $sql = "SELECT id, username, password, role, balance FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $uname);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $username, $db_password, $role, $balance);
        $stmt->fetch();

        if ($psw === $db_password) {

            setcookie("user_id", $id, time() + (86400 * 30), "/");
            setcookie("user_role", $role, time() + (86400 * 30), "/");

            if ($role === 'admin') {
                header("Location: /admin.php");
            } else {
                header("Location: /dashboard.php");
            }
            exit();
        } else {
            header("Location: /login.php?error=Invalid username or password");
            exit();
        }
    } else {
        header("Location: /login.php?error=Invalid username or password");
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>

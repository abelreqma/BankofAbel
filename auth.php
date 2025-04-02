<?php
session_start();

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

    $sql = "SELECT id, username, password, role FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $uname);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $username, $db_password, $role);
        $stmt->fetch();

        // Compare plaintext passwords directly
        if ($psw === $db_password) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['id'] = $id;

            if ($role === 'admin') {
                setcookie("user_role", "admin", time() + (86400 * 30), "/");
                header("Location: /dashboard.php");
            } else {
                setcookie("user_role", "other_user", time() + (86400 * 30), "/");
                header("Location: /access_denied.php");
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

<?php

if (!isset($_COOKIE['user_id']) || !isset($_COOKIE['user_role']) || $_COOKIE['user_role'] !== 'other_user') {
    header("Location: /login.php");
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

$sender_id = $_COOKIE['user_id'];
$recipient_username = $_POST['recipient'];
$amount = floatval($_POST['amount']);

if ($amount <= 0) {
    die("Invalid amount.");
}

$conn->begin_transaction();

try {
    $sql = "SELECT balance FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $sender_id);
    $stmt->execute();
    $stmt->bind_result($sender_balance);
    $stmt->fetch();
    $stmt->close();

    if ($sender_balance < $amount) {
        throw new Exception("Insufficient balance.");
    }

    $sql = "SELECT id, balance FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $recipient_username);
    $stmt->execute();
    $stmt->bind_result($recipient_id, $recipient_balance);
    if (!$stmt->fetch()) {
        throw new Exception("Recipient not found.");
    }
    $stmt->close();

    $new_sender_balance = $sender_balance - $amount;
    $sql = "UPDATE users SET balance = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("di", $new_sender_balance, $sender_id);
    $stmt->execute();
    $stmt->close();

    $new_recipient_balance = $recipient_balance + $amount;
    $sql = "UPDATE users SET balance = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("di", $new_recipient_balance, $recipient_id);
    $stmt->execute();
    $stmt->close();

    $conn->commit();

    echo "Transfer successful!";

} catch (Exception $e) {
    // Rollback the transaction on error
    $conn->rollback();
    echo "Error: " . $e->getMessage();
}

$conn->close();
?>

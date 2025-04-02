<?php
session_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $username = $_POST['username'] ?? '';
   $password = $_POST['password'] ?? '';

    // Simple hardcoded credentials for PoC
   if ($username === "admin" && $password === "password123") {
      setcookie("user_role", "admin", time() + 3600, "/"); // Set "admin" cookie
      #header("Location: dashboard.php");
      exit();
   } else {
      setcookie("user_role", "guest", time() + 3600, "/"); // Set "guest" cookie
      #header("Location: dashboard.php");
      exit();
   }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Link to the external CSS file -->
<link rel="stylesheet" type="text/css" href="styles.css">

</head>
<body>

<h2>Login Form</h2>

<form action="login.php" method="post">
   <div class="imgcontainer">
      <img src="img_avatar2.png" alt="Avatar" class="avatar">
   </div>

  <div class="container">
      <label for="uname"><b>Username</b></label>
      <input type="text" placeholder="Enter Username" name="uname" required>

      <label for="psw"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="psw" required>
        
      <button type="submit">Login</button>
      <label>
         <input type="checkbox" checked="checked" name="remember"> Remember me
      </label>
   </div>

   <div class="container" style="background-color:#f1f1f1">
      <button type="button" class="cancelbtn">Cancel</button>
      <span class="psw">Forgot <a href="#">password?</a></span>
   </div>
</form>

</body>
</html>
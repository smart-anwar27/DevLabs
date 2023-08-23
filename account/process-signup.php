<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart - Create Account</title>

    <link rel="stylesheet" href="../static/css/form.css">
    <link rel="shortcut icon" href="../static/img/id.png" type="image/x-icon">


</head>
<body>
    <form action="process-signup.php" method="post" align="middle">
        <br>
        <img src="../static/img/Smart.png" alt="Smart" width="100" height="100">
        <br>
        <h2>:( Something went wrong</h2>
        <p style="color: gray; font-size: small; margin-top: 10px;">
        
        <?php

if (empty($_POST["name"])) {
    die("Name is required");
}

if ( ! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    die("Valid email is required");
}

if (strlen($_POST["password"]) < 8) {
    die("Password must be at least 8 characters");
}

if ( ! preg_match("/[a-z]/i", $_POST["password"])) {
    die("Password must contain at least one letter");
}

if ( ! preg_match("/[0-9]/", $_POST["password"])) {
    die("Password must contain at least one number");
}

if ($_POST["password"] !== $_POST["password_confirmation"]) {
    die("Passwords must match");
}

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$mysqli = require __DIR__ . "/database.php";

$sql = "INSERT INTO user (name, email, password_hash)
        VALUES (?, ?, ?)";
        
$stmt = $mysqli->stmt_init();

if ( ! $stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}

$stmt->bind_param("sss",
                  $_POST["name"],
                  $_POST["email"],
                  $password_hash);
                  
if ($stmt->execute()) {

    header("Location: signup-success.html");
    exit;
    
} else {
    
    if ($mysqli->errno === 1062) {
        die("Email already exists...");
    } else {
        die($mysqli->error . " " . $mysqli->errno);
    }
}
?></p>
<br>
</form>
</body>
</html>










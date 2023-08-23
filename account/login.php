<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = sprintf("SELECT * FROM user
                    WHERE email = '%s'",
                   $mysqli->real_escape_string($_POST["email"]));
    
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
    
    if ($user) {
        
        if (password_verify($_POST["password"], $user["password_hash"])) {
            
            session_start();
            
            session_regenerate_id();
            
            $_SESSION["user_id"] = $user["id"];
            
            header("Location: ../editor.php");
            exit;
        }
    }
    
    $is_invalid = true;
}

?>
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
    <form action="" method="post" align="middle">
        <br>
        <img src="../static/img/Smart.png" alt="Smart" width="100" height="100">
        <br>
        <h2>Sign In <small style="font-weight: normal;">to DevLabs</small></h2>
        <p style="color: gray; font-size: small; margin-top: 10px;">with SmartID or <a href="signup.html">Sign Up.</a></p>
        <br>
        <?php if ($is_invalid): ?>
        <p style="color: red;">Wrong password or email.</p>
    <?php endif; ?>
        <br>
        <div class="input-cnt">
            <input type="email" placeholder="Email address" id="email" value="<?= htmlspecialchars($_POST["email"] ?? "") ?>" name="email" required>
        </div>
        <div class="input-cnt">
            <input type="password" placeholder="Password" id="password" name="password" required>
        </div>
        <div class="input-cnt" style="margin-top: 40px;">
              <button>Continue</button>
        </div>
        <br>
    </form>
    <br>
    <br>
    <p align="middle"><small>&copy Copyright Smart 2023 &nbsp &nbsp <a href="#">Help Center</a> &nbsp &nbsp <a href="#">Youtube</a></small></p>
</body>
</html>
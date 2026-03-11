<?php
require "auth.php";
require "demo_connect.php";

$msg = "";

if (isset($_POST["login"])) {
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($username == "" || $password == "") {
        $msg = "Vui lòng nhập đầy đủ thông tin.";
    } else {
        $stmt = mysqli_prepare($connect, "SELECT id, username, password, role FROM users WHERE username=? LIMIT 1");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $u = mysqli_fetch_assoc($res);
        mysqli_stmt_close($stmt);

        if ($u && password_verify($password, $u["password"])) {
            // Regenerate session ID to prevent session fixation attacks
            session_regenerate_id(true);
            // LƯU SESSION
            $_SESSION["user_id"] = $u["id"];
            $_SESSION["username"] = $u["username"];
            $_SESSION["role"] = $u["role"];

            mysqli_close($connect);

            if ($u["role"] === "admin") {
                header("Location: admin.php");
            } else {
                header("Location: index.php");
            }
            exit;
        } else {
            $msg = "Sai username hoặc password.";
        }
    }
}

mysqli_close($connect);
?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Đăng Nhập</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="card">
  <h2>Đăng Nhập</h2>

  <?php if ($msg != ""): ?>
    <div class="msg"><?php echo htmlspecialchars($msg); ?></div>
  <?php endif; ?>

  <form method="post">
    <label>Username</label>
    <input type="text" name="username" required>

    <label>Password</label>
    <input type="password" name="password" required>

    <button type="submit" name="login">Login</button>
  </form>

  <div class="link">
    Chưa có tài khoản? <a href="register.php">Đăng ký</a>
  </div>
</div>
</body>
</html>
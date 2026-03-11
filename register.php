<?php
require "demo_connect.php";

$msg = "";
$ok  = false;

if (isset($_POST["submit"])) {
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";
    $confirm  = $_POST["confirm"] ?? "";

    if ($username=="" || $password=="" || $confirm=="") {
        $msg = "Vui lòng nhập đầy đủ thông tin.";
    } elseif ($password !== $confirm) {
        $msg = "Mật khẩu nhập lại không khớp.";
    } else {
        $role = "user";
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = mysqli_prepare($connect, "INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sss", $username, $hash, $role);

        if (mysqli_stmt_execute($stmt)) {
            $ok = true;
            $msg = "Đăng ký thành công!";
            // Nếu muốn tự chuyển sang login:
            // header("Location: login.php"); exit;
        } else {
            $err = mysqli_stmt_error($stmt);
            $msg = (strpos($err, "Duplicate") !== false) ? "Username đã tồn tại." : "Lỗi: ".$err;
        }
        mysqli_stmt_close($stmt);
    }
}

mysqli_close($connect);
?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Đăng Ký</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="card">
  <h2>Đăng Ký</h2>

  <?php if ($msg!=""): ?>
    <div class="msg <?php echo $ok?'ok':''; ?>"><?php echo htmlspecialchars($msg); ?></div>
  <?php endif; ?>

  <form method="post">
    <label>Username</label>
    <input type="text" name="username" required>

    <label>Password</label>
    <input type="password" name="password" required>

    <label>Confirm Password</label>
    <input type="password" name="confirm" required>

    <button type="submit" name="submit">Submit</button>
  </form>

  <div class="link">
    Đã có tài khoản? <a href="login.php">Đăng nhập</a>
  </div>
</div>
</body>
</html>
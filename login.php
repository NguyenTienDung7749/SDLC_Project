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
  <title>Đăng Nhập – SDLC Project</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="auth-page">
<div class="card">

  <div class="brand">
    <div class="brand-icon">🛍️</div>
    <div class="brand-name">SDLC Project</div>
  </div>

  <h2>Chào mừng trở lại</h2>
  <p class="subtitle">Đăng nhập để tiếp tục</p>

  <?php if ($msg != ""): ?>
    <div class="msg" id="alert-msg">
      <?php echo htmlspecialchars($msg); ?>
      <button type="button" class="msg-close" onclick="this.parentElement.remove()" title="Đóng">×</button>
    </div>
  <?php endif; ?>

  <form method="post">
    <div class="form-group">
      <label for="username">Username</label>
      <input type="text" id="username" name="username" placeholder="Nhập username của bạn" required autocomplete="username">
    </div>

    <div class="form-group">
      <label for="password">Password</label>
      <div class="pw-wrap">
        <input type="password" id="password" name="password" placeholder="Nhập mật khẩu" required autocomplete="current-password">
        <button type="button" class="pw-toggle" onclick="togglePw('password', this)" title="Hiện mật khẩu">
          <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
        </button>
      </div>
    </div>

    <button type="submit" name="login">Đăng nhập →</button>
  </form>

  <div class="link">
    Chưa có tài khoản? <a href="register.php">Đăng ký ngay</a>
  </div>
</div>
<script src="app.js"></script>
</body>
</html>
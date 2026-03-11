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
            $msg = "Đăng ký thành công! Bạn có thể đăng nhập ngay.";
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
  <title>Đăng Ký – SDLC Project</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="auth-page">
<div class="card">

  <div class="brand">
    <div class="brand-icon">🛍️</div>
    <div class="brand-name">SDLC Project</div>
  </div>

  <h2>Tạo tài khoản mới</h2>
  <p class="subtitle">Điền thông tin để bắt đầu</p>

  <?php if ($msg != ""): ?>
    <div class="msg <?php echo $ok ? 'ok' : ''; ?>" id="alert-msg">
      <?php echo htmlspecialchars($msg); ?>
      <button type="button" class="msg-close" onclick="this.parentElement.remove()" title="Đóng">×</button>
    </div>
  <?php endif; ?>

  <form method="post">
    <div class="form-group">
      <label for="username">Username</label>
      <input type="text" id="username" name="username" placeholder="Chọn username" required autocomplete="username">
    </div>

    <div class="form-group">
      <label for="password">Password</label>
      <div class="pw-wrap">
        <input type="password" id="password" name="password" placeholder="Tạo mật khẩu" required autocomplete="new-password"
               oninput="checkPwStrength(this.value)">
        <button type="button" class="pw-toggle" onclick="togglePw('password', this)" title="Hiện mật khẩu">
          <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
        </button>
      </div>
      <div class="pw-strength">
        <div class="pw-strength-bar"></div>
        <div class="pw-strength-bar"></div>
        <div class="pw-strength-bar"></div>
        <div class="pw-strength-bar"></div>
        <span class="pw-strength-label"></span>
      </div>
    </div>

    <div class="form-group">
      <label for="confirm">Xác nhận Password</label>
      <div class="pw-wrap">
        <input type="password" id="confirm" name="confirm" placeholder="Nhập lại mật khẩu" required autocomplete="new-password"
               oninput="checkConfirm()">
        <button type="button" class="pw-toggle" onclick="togglePw('confirm', this)" title="Hiện mật khẩu">
          <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
        </button>
      </div>
      <span id="confirm-hint" class="field-hint"></span>
    </div>

    <button type="submit" name="submit">Tạo tài khoản →</button>
  </form>

  <div class="link">
    Đã có tài khoản? <a href="login.php">Đăng nhập ngay</a>
  </div>
</div>
<script src="app.js"></script>
</body>
</html>
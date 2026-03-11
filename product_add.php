<?php
require "auth.php";
require_admin();
require "demo_connect.php";

$msg=""; $ok=false;

if(isset($_POST["save"])){
  $name=trim($_POST["name"]);
  $price=trim($_POST["price"]);
  if($name==""||$price=="") $msg="Nhập đủ thông tin.";
  elseif(!ctype_digit($price)) $msg="Giá phải là số nguyên không âm.";
  else{
    $stmt=mysqli_prepare($connect,"INSERT INTO products(name,price) VALUES(?,?)");
    mysqli_stmt_bind_param($stmt,"si",$name,$price);
    if(mysqli_stmt_execute($stmt)){ $ok=true; $msg="Thêm sản phẩm thành công!"; }
    else $msg="Lỗi: ".mysqli_stmt_error($stmt);
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
  <title>Thêm sản phẩm – SDLC Project</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="app-page">
<div class="card">

  <!-- Navigation -->
  <div class="nav">
    <span class="spacer"></span>
    <a href="admin.php">← Quay lại Admin</a>
    <a href="logout.php" class="nav-logout">Đăng xuất</a>
  </div>

  <h2>➕ Thêm sản phẩm</h2>
  <p class="subtitle">Điền thông tin sản phẩm mới</p>

  <?php if($msg!=""): ?>
    <div class="msg <?php echo $ok?'ok':''; ?>" id="alert-msg">
      <?php echo htmlspecialchars($msg); ?>
      <button type="button" class="msg-close" onclick="this.parentElement.remove()" title="Đóng">×</button>
    </div>
  <?php endif; ?>

  <form method="post">
    <div class="form-group">
      <label for="name">Tên sản phẩm</label>
      <input type="text" id="name" name="name" placeholder="VD: Áo thun cotton" required
             value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
    </div>

    <div class="form-group">
      <label for="price">Giá (VNĐ, số nguyên)</label>
      <input type="number" id="price" name="price" placeholder="VD: 150000" min="0" required
             value="<?php echo isset($_POST['price']) ? htmlspecialchars($_POST['price']) : ''; ?>">
    </div>

    <button type="submit" name="save">💾 Lưu sản phẩm</button>
  </form>

</div>
<script src="app.js"></script>
</body>
</html>
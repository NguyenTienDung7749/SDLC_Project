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
    if(mysqli_stmt_execute($stmt)){ $ok=true; $msg="Thêm thành công!"; }
    else $msg="Lỗi: ".mysqli_stmt_error($stmt);
    mysqli_stmt_close($stmt);
  }
}
mysqli_close($connect);
?>
<!doctype html>
<html lang="vi"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Thêm sản phẩm</title><link rel="stylesheet" href="style.css">
</head><body>
<div class="card">
<h2>Thêm sản phẩm</h2>

<div class="nav">
  <span class="spacer"></span>
  <a href="admin.php">← Quay lại Admin</a>
  <a href="logout.php">Đăng xuất</a>
</div>

<?php if($msg!=""): ?><div class="msg <?php echo $ok?'ok':'';?>"><?php echo htmlspecialchars($msg);?></div><?php endif; ?>
<form method="post">
<label>Tên sản phẩm</label><input name="name" required>
<label>Giá (VNĐ, số nguyên)</label><input name="price" type="number" min="0" required>
<button name="save">Lưu sản phẩm</button>
</form>
</div></body></html>
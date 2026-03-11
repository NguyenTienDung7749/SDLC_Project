<?php
require "auth.php";
require_admin();
require "demo_connect.php";

$id = $_GET["id"] ?? "";
if(!ctype_digit($id)) die("ID không hợp lệ");

$msg=""; $ok=false;

// lấy sản phẩm
$stmt=mysqli_prepare($connect,"SELECT id,name,price FROM products WHERE id=?");
mysqli_stmt_bind_param($stmt,"i",$id);
mysqli_stmt_execute($stmt);
$res=mysqli_stmt_get_result($stmt);
$p=mysqli_fetch_assoc($res);
mysqli_stmt_close($stmt);
if(!$p) die("Không tìm thấy sản phẩm");

if(isset($_POST["save"])){
  $name=trim($_POST["name"]);
  $price=trim($_POST["price"]);
  if($name==""||$price=="") $msg="Nhập đủ thông tin.";
  elseif(!ctype_digit($price)) $msg="Giá phải là số nguyên không âm.";
  else{
    $stmt2=mysqli_prepare($connect,"UPDATE products SET name=?, price=? WHERE id=?");
    mysqli_stmt_bind_param($stmt2,"sii",$name,$price,$id);
    if(mysqli_stmt_execute($stmt2)){ $ok=true; $msg="Sửa thành công!"; $p["name"]=$name; $p["price"]=$price; }
    else $msg="Lỗi: ".mysqli_stmt_error($stmt2);
    mysqli_stmt_close($stmt2);
  }
}
mysqli_close($connect);
?>
<!doctype html>
<html lang="vi"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Sửa sản phẩm</title><link rel="stylesheet" href="style.css">
</head><body>
<div class="card">
<h2>Sửa sản phẩm</h2>

<div class="nav">
  <span class="spacer"></span>
  <a href="admin.php">← Quay lại Admin</a>
  <a href="logout.php">Đăng xuất</a>
</div>

<?php if($msg!=""): ?><div class="msg <?php echo $ok?'ok':'';?>"><?php echo htmlspecialchars($msg);?></div><?php endif; ?>
<form method="post">
<label>Tên sản phẩm</label><input name="name" value="<?php echo htmlspecialchars($p["name"]);?>" required>
<label>Giá (VNĐ, số nguyên)</label><input name="price" type="number" min="0" value="<?php echo htmlspecialchars($p["price"]);?>" required>
<button name="save">Cập nhật</button>
</form>
</div></body></html>
<?php
require "auth.php";
require_admin();
require "demo_connect.php";

$rows = [];
$q = mysqli_query($connect, "SELECT id,name,price,created_at FROM products ORDER BY id DESC");
if ($q) {
    while ($r = mysqli_fetch_assoc($q)) {
        $rows[] = $r;
    }
}
mysqli_close($connect);
?>
<!doctype html>
<html lang="vi"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin – Quản lý sản phẩm</title><link rel="stylesheet" href="style.css">
</head><body>
<div class="card wide">
<h2>Trang Admin – Sản phẩm</h2>

<div class="nav">
  Xin chào <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>
  <span class="badge admin">admin</span>
  <span class="spacer"></span>
  <a href="admin_users.php">Quản lý User</a>
  <a href="index.php">Trang Chủ</a>
  <a href="logout.php">Đăng xuất</a>
</div>

<a class="btn compact" href="product_add.php">+ Thêm sản phẩm</a>

<table>
<tr><th>ID</th><th>Tên sản phẩm</th><th>Giá (VNĐ)</th><th>Ngày tạo</th><th>Hành động</th></tr>
<?php foreach($rows as $p): ?>
<tr>
  <td><?php echo $p["id"];?></td>
  <td><?php echo htmlspecialchars($p["name"]);?></td>
  <td><?php echo number_format($p["price"]);?></td>
  <td><?php echo htmlspecialchars($p["created_at"]);?></td>
  <td class="actions">
    <a href="product_edit.php?id=<?php echo $p["id"];?>">Sửa</a>
    <a class="danger" href="product_delete.php?id=<?php echo $p["id"];?>" onclick="return confirm('Xóa sản phẩm này?')">Xóa</a>
  </td>
</tr>
<?php endforeach; ?>
<?php if(empty($rows)): ?>
<tr><td colspan="5" style="text-align:center;color:#9ca3af;">Chưa có sản phẩm nào.</td></tr>
<?php endif; ?>
</table>

</div></body></html>
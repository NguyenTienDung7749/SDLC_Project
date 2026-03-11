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
<title>Admin</title><link rel="stylesheet" href="style.css">
</head><body>
<div class="card">
<h2>Trang Admin (CRUD)</h2>

<div class="link" style="text-align:left">
  Xin chào Admin: <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>
  · <a href="logout.php">Đăng xuất</a>
</div>

<a class="btn" href="product_add.php">+ Thêm sản phẩm</a>
<a class="btn secondary" href="admin_users.php">Quản lý User</a>
<a class="btn secondary" href="index.php">Về Trang Chủ</a>

<table>
<tr><th>ID</th><th>Tên</th><th>Giá</th><th>Hành động</th></tr>
<?php foreach($rows as $p): ?>
<tr>
  <td><?php echo $p["id"];?></td>
  <td><?php echo htmlspecialchars($p["name"]);?></td>
  <td><?php echo number_format($p["price"]);?></td>
  <td class="actions">
    <a href="product_edit.php?id=<?php echo $p["id"];?>">Sửa</a>
    <a href="product_delete.php?id=<?php echo $p["id"];?>" onclick="return confirm('Xóa sản phẩm này?')">Xóa</a>
  </td>
</tr>
<?php endforeach; ?>
</table>

</div></body></html>
<?php
require "auth.php";
require "demo_connect.php";

$rows = [];
$q = mysqli_query($connect, "SELECT id, name, price, created_at FROM products ORDER BY id DESC");
if ($q) {
    while ($r = mysqli_fetch_assoc($q)) {
        $rows[] = $r;
    }
}
mysqli_close($connect);
?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Trang Chủ</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="card">
  <h2>Trang Chủ</h2>

  <div class="link" style="text-align:left">
    <?php if (is_login()): ?>
      Xin chào <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>
      (<?php echo htmlspecialchars($_SESSION["role"]); ?>)
      · <a href="logout.php">Đăng xuất</a>
      <?php if ($_SESSION["role"] === "admin"): ?>
        · <a href="admin.php">Trang Admin</a>
      <?php endif; ?>
    <?php else: ?>
      Bạn chưa đăng nhập · <a href="login.php">Đăng nhập</a> · <a href="register.php">Đăng ký</a>
    <?php endif; ?>
  </div>

  <h3 style="margin:14px 0 0">Danh sách sản phẩm</h3>
  <table>
    <tr><th>ID</th><th>Tên</th><th>Giá</th><th>Ngày</th></tr>
    <?php foreach ($rows as $p): ?>
      <tr>
        <td><?php echo $p["id"]; ?></td>
        <td><?php echo htmlspecialchars($p["name"]); ?></td>
        <td><?php echo number_format($p["price"]); ?></td>
        <td><?php echo $p["created_at"]; ?></td>
      </tr>
    <?php endforeach; ?>
  </table>
</div>
</body>
</html>
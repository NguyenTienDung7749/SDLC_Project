<?php
require "auth.php";
require_login();
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
<div class="card wide">
  <h2>Trang Chủ – Danh sách sản phẩm</h2>

  <div class="nav">
    Xin chào <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>
    <span class="badge <?php echo $_SESSION['role'] === 'admin' ? 'admin' : 'user'; ?>">
      <?php echo htmlspecialchars($_SESSION["role"]); ?>
    </span>
    <span class="spacer"></span>
    <?php if ($_SESSION["role"] === "admin"): ?>
      <a href="admin.php">Trang Admin</a>
    <?php endif; ?>
    <a href="logout.php">Đăng xuất</a>
  </div>

  <table>
    <tr><th>ID</th><th>Tên sản phẩm</th><th>Giá (VNĐ)</th><th>Ngày tạo</th></tr>
    <?php foreach ($rows as $p): ?>
      <tr>
        <td><?php echo $p["id"]; ?></td>
        <td><?php echo htmlspecialchars($p["name"]); ?></td>
        <td><?php echo number_format($p["price"]); ?></td>
        <td><?php echo htmlspecialchars($p["created_at"]); ?></td>
      </tr>
    <?php endforeach; ?>
    <?php if (empty($rows)): ?>
      <tr><td colspan="4" style="text-align:center;color:#9ca3af;">Chưa có sản phẩm nào.</td></tr>
    <?php endif; ?>
  </table>
</div>
</body>
</html>
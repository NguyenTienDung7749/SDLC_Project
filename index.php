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
  <title>Trang Chủ – SDLC Project</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="app-page">
<div class="card wide">

  <!-- Navigation -->
  <div class="nav">
    <span class="nav-brand">
      <span class="nav-brand-dot">🛍️</span>
      SDLC Project
    </span>
    <span class="spacer"></span>
    <div class="nav-user">
      Xin chào, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>
      <span class="badge <?php echo $_SESSION['role'] === 'admin' ? 'admin' : 'user'; ?>">
        <?php echo htmlspecialchars($_SESSION["role"]); ?>
      </span>
    </div>
    <?php if ($_SESSION["role"] === "admin"): ?>
      <a href="admin.php">⚙️ Trang Admin</a>
    <?php endif; ?>
    <a href="logout.php" class="nav-logout">Đăng xuất</a>
  </div>

  <!-- Page header -->
  <div class="page-header">
    <div>
      <div class="page-title">🛒 Danh sách sản phẩm</div>
      <div class="page-subtitle"><?php echo count($rows); ?> sản phẩm hiện có</div>
    </div>
  </div>

  <!-- Product grid -->
  <?php if (!empty($rows)): ?>
    <div class="product-grid">
      <?php foreach ($rows as $p): ?>
        <div class="product-card">
          <div class="product-card-icon">📦</div>
          <div class="product-card-name"><?php echo htmlspecialchars($p["name"]); ?></div>
          <div class="product-card-price"><?php echo number_format($p["price"]); ?> VNĐ</div>
          <div class="product-card-date">🕐 <?php echo htmlspecialchars(substr($p["created_at"], 0, 10)); ?></div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <div class="empty-state">
      <span class="empty-state-icon">📭</span>
      <div class="empty-state-text">Chưa có sản phẩm nào</div>
      <div class="empty-state-sub">Hãy quay lại sau nhé!</div>
    </div>
  <?php endif; ?>

</div>
<script src="app.js"></script>
</body>
</html>
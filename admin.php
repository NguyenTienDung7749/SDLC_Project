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
$product_count = count($rows);
mysqli_close($connect);
?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin – Quản lý sản phẩm</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="app-page">
<div class="card wide">

  <!-- Navigation -->
  <div class="nav">
    <span class="nav-brand">
      <span class="nav-brand-dot">⚙️</span>
      SDLC Admin
    </span>
    <span class="spacer"></span>
    <div class="nav-user">
      <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>
      <span class="badge admin">admin</span>
    </div>
    <a href="admin.php" class="active">🛒 Sản phẩm</a>
    <a href="admin_users.php">👥 Users</a>
    <a href="index.php">🏠 Trang Chủ</a>
    <a href="logout.php" class="nav-logout">Đăng xuất</a>
  </div>

  <!-- Stats -->
  <div class="stats-row">
    <div class="stat-card">
      <div class="stat-number"><?php echo $product_count; ?></div>
      <div class="stat-label">Tổng sản phẩm</div>
    </div>
  </div>

  <!-- Page header -->
  <div class="page-header">
    <div>
      <div class="page-title">🛒 Quản lý sản phẩm</div>
      <div class="page-subtitle">Thêm, sửa, xóa sản phẩm trong hệ thống</div>
    </div>
    <a class="btn compact" href="product_add.php">+ Thêm sản phẩm</a>
  </div>

  <!-- Products table -->
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Tên sản phẩm</th>
          <th>Giá (VNĐ)</th>
          <th>Ngày tạo</th>
          <th>Hành động</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($rows as $p): ?>
        <tr>
          <td><b>#<?php echo $p["id"]; ?></b></td>
          <td><?php echo htmlspecialchars($p["name"]); ?></td>
          <td><b><?php echo number_format($p["price"]); ?></b> VNĐ</td>
          <td><?php echo htmlspecialchars(substr($p["created_at"], 0, 10)); ?></td>
          <td class="actions">
            <a class="action-btn edit" href="product_edit.php?id=<?php echo $p["id"]; ?>">✏️ Sửa</a>
            <a class="action-btn delete"
               href="product_delete.php?id=<?php echo $p["id"]; ?>"
               data-title="Xóa sản phẩm"
               data-msg="<?php echo htmlspecialchars('Xóa «'.$p["name"].'»? Hành động này không thể hoàn tác.'); ?>"
               onclick="return confirmAction(this.href, this.dataset.title, this.dataset.msg)">🗑 Xóa</a>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php if(empty($rows)): ?>
        <tr>
          <td colspan="5">
            <div class="empty-state">
              <span class="empty-state-icon">📭</span>
              <div class="empty-state-text">Chưa có sản phẩm nào</div>
              <div class="empty-state-sub">Nhấn "+ Thêm sản phẩm" để bắt đầu</div>
            </div>
          </td>
        </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

</div>

<!-- Confirm delete modal -->
<div id="confirm-modal" class="modal-overlay">
  <div class="modal-box">
    <div class="modal-icon">🗑️</div>
    <div class="modal-title" id="confirm-title">Xác nhận xóa</div>
    <p class="modal-msg" id="confirm-msg">Bạn có chắc muốn xóa sản phẩm này?</p>
    <div class="modal-actions">
      <button type="button" class="outline" onclick="closeModal()">Hủy</button>
      <a id="confirm-ok" href="#" class="btn danger">Xóa</a>
    </div>
  </div>
</div>

<script src="app.js"></script>
</body>
</html>
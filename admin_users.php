<?php
require "auth.php";
require_admin();
require "demo_connect.php";

$users = [];
$q = mysqli_query($connect, "SELECT id, username, role FROM users ORDER BY id ASC");
if ($q) {
    while ($r = mysqli_fetch_assoc($q)) {
        $users[] = $r;
    }
}
$user_count = count($users);
mysqli_close($connect);

$me_id = $_SESSION["user_id"];
?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Quản lý User – SDLC Project</title>
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
    <a href="admin.php">🛒 Sản phẩm</a>
    <a href="admin_users.php" class="active">👥 Users</a>
    <a href="index.php">🏠 Trang Chủ</a>
    <a href="logout.php" class="nav-logout">Đăng xuất</a>
  </div>

  <!-- Stats -->
  <div class="stats-row">
    <div class="stat-card alt">
      <div class="stat-number"><?php echo $user_count; ?></div>
      <div class="stat-label">Tổng người dùng</div>
    </div>
  </div>

  <!-- Page header -->
  <div class="page-header">
    <div>
      <div class="page-title">👥 Quản lý User</div>
      <div class="page-subtitle">Phân quyền và quản lý tài khoản người dùng</div>
    </div>
  </div>

  <!-- Users table -->
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Username</th>
          <th>Role</th>
          <th>Hành động</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($users as $u): ?>
        <tr>
          <td><b>#<?php echo $u["id"]; ?></b></td>
          <td><?php echo htmlspecialchars($u["username"]); ?></td>
          <td>
            <span class="badge <?php echo $u['role'] === 'admin' ? 'admin' : 'user'; ?>">
              <?php echo htmlspecialchars($u["role"]); ?>
            </span>
          </td>
          <td class="actions">
            <?php if ($u["id"] != $me_id): ?>
              <?php if ($u["role"] === "user"): ?>
                <a class="action-btn promote"
                   href="user_role.php?id=<?php echo $u["id"]; ?>&role=admin"
                   data-title="Nâng quyền Admin"
                   data-msg="<?php echo htmlspecialchars('Đặt «'.$u["username"].'» làm admin?'); ?>"
                   onclick="return confirmAction(this.href, this.dataset.title, this.dataset.msg)">⬆️ Set Admin</a>
              <?php else: ?>
                <a class="action-btn demote"
                   href="user_role.php?id=<?php echo $u["id"]; ?>&role=user"
                   data-title="Hạ quyền User"
                   data-msg="<?php echo htmlspecialchars('Đặt «'.$u["username"].'» về user thường?'); ?>"
                   onclick="return confirmAction(this.href, this.dataset.title, this.dataset.msg)">⬇️ Set User</a>
              <?php endif; ?>
              <a class="action-btn delete"
                 href="user_delete.php?id=<?php echo $u["id"]; ?>"
                 data-title="Xóa tài khoản"
                 data-msg="<?php echo htmlspecialchars('Xóa tài khoản «'.$u["username"].'»? Hành động này không thể hoàn tác.'); ?>"
                 onclick="return confirmAction(this.href, this.dataset.title, this.dataset.msg)">🗑 Xóa</a>
            <?php else: ?>
              <span class="self-label">👋 Bạn</span>
            <?php endif; ?>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php if(empty($users)): ?>
        <tr>
          <td colspan="4">
            <div class="empty-state">
              <span class="empty-state-icon">👤</span>
              <div class="empty-state-text">Không có user nào</div>
            </div>
          </td>
        </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

</div>

<!-- Confirm action modal -->
<div id="confirm-modal" class="modal-overlay">
  <div class="modal-box">
    <div class="modal-icon">⚠️</div>
    <div class="modal-title" id="confirm-title">Xác nhận</div>
    <p class="modal-msg" id="confirm-msg">Bạn có chắc chắn không?</p>
    <div class="modal-actions">
      <button type="button" class="outline" onclick="closeModal()">Hủy</button>
      <a id="confirm-ok" href="#" class="btn danger">Xác nhận</a>
    </div>
  </div>
</div>

<script src="app.js"></script>
</body>
</html>
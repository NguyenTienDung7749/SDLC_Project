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
mysqli_close($connect);

$me_id = $_SESSION["user_id"];
?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Quản lý User</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="card wide">
  <h2>Quản lý User</h2>

  <div class="nav">
    Xin chào <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>
    <span class="badge admin">admin</span>
    <span class="spacer"></span>
    <a href="admin.php">Sản phẩm</a>
    <a href="index.php">Trang Chủ</a>
    <a href="logout.php">Đăng xuất</a>
  </div>

  <table>
    <tr>
      <th>ID</th><th>Username</th><th>Role</th><th>Hành động</th>
    </tr>
    <?php foreach($users as $u): ?>
      <tr>
        <td><?php echo $u["id"]; ?></td>
        <td><?php echo htmlspecialchars($u["username"]); ?></td>
        <td>
          <span class="badge <?php echo $u['role'] === 'admin' ? 'admin' : 'user'; ?>">
            <?php echo htmlspecialchars($u["role"]); ?>
          </span>
        </td>
        <td class="actions">
          <?php if ($u["id"] != $me_id): ?>
            <?php if ($u["role"] === "user"): ?>
              <a href="user_role.php?id=<?php echo $u["id"]; ?>&role=admin"
                 onclick="return confirm('Đổi user này thành admin?')">Set Admin</a>
            <?php else: ?>
              <a href="user_role.php?id=<?php echo $u["id"]; ?>&role=user"
                 onclick="return confirm('Đổi admin này thành user?')">Set User</a>
            <?php endif; ?>
            <a class="danger" href="user_delete.php?id=<?php echo $u["id"]; ?>"
               onclick="return confirm('Xóa user này?')">Xóa</a>
          <?php else: ?>
            <span style="color:#9ca3af;font-size:13px;">(Bạn)</span>
          <?php endif; ?>
        </td>
      </tr>
    <?php endforeach; ?>
    <?php if(empty($users)): ?>
    <tr><td colspan="4" style="text-align:center;color:#9ca3af;">Không có user nào.</td></tr>
    <?php endif; ?>
  </table>
</div>
</body>
</html>
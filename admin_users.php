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
<div class="card">
  <h2>Quản lý User</h2>

  <div class="link" style="text-align:left">
    Xin chào <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>
    · <a href="admin.php">Về Admin</a>
    · <a href="logout.php">Đăng xuất</a>
  </div>

  <table>
    <tr>
      <th>ID</th><th>Username</th><th>Role</th><th>Hành động</th>
    </tr>
    <?php foreach($users as $u): ?>
      <tr>
        <td><?php echo $u["id"]; ?></td>
        <td><?php echo htmlspecialchars($u["username"]); ?></td>
        <td><?php echo htmlspecialchars($u["role"]); ?></td>
        <td class="actions">
          <?php if ($u["id"] != $me_id): ?>
            <?php if ($u["role"] === "user"): ?>
              <a href="user_role.php?id=<?php echo $u["id"]; ?>&role=admin"
                 onclick="return confirm('Đổi user này thành admin?')">Set Admin</a>
            <?php else: ?>
              <a href="user_role.php?id=<?php echo $u["id"]; ?>&role=user"
                 onclick="return confirm('Đổi admin này thành user?')">Set User</a>
            <?php endif; ?>

            <a href="user_delete.php?id=<?php echo $u["id"]; ?>"
               onclick="return confirm('Xóa user này?')">Xóa</a>
          <?php else: ?>
            (Bạn)
          <?php endif; ?>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
</div>
</body>
</html>
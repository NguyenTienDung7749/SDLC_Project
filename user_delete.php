<?php
require "auth.php";
require_admin();
require "demo_connect.php";

$id = $_GET["id"] ?? "";
if (!ctype_digit($id)) die("ID không hợp lệ");

$me_id = $_SESSION["user_id"];
if ((int)$id === (int)$me_id) die("Không được tự xóa chính mình.");

$stmt = mysqli_prepare($connect, "DELETE FROM users WHERE id=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

mysqli_close($connect);
header("Location: admin_users.php");
exit;
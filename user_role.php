<?php
require "auth.php";
require_admin();
require "demo_connect.php";

$id = $_GET["id"] ?? "";
$role = $_GET["role"] ?? "";

if (!ctype_digit($id)) die("ID không hợp lệ");
if ($role !== "admin" && $role !== "user") die("Role không hợp lệ");

$me_id = $_SESSION["user_id"];
if ((int)$id === (int)$me_id) die("Không được tự đổi quyền của chính mình.");

$stmt = mysqli_prepare($connect, "UPDATE users SET role=? WHERE id=?");
mysqli_stmt_bind_param($stmt, "si", $role, $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

mysqli_close($connect);
header("Location: admin_users.php");
exit;   
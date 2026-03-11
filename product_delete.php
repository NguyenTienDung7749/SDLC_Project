<?php
require "auth.php";
require_admin();
require "demo_connect.php";

$id = $_GET["id"] ?? "";
if(!ctype_digit($id)) die("ID không hợp lệ");

$stmt=mysqli_prepare($connect,"DELETE FROM products WHERE id=?");
mysqli_stmt_bind_param($stmt,"i",$id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

mysqli_close($connect);
header("Location: admin.php");
exit;
<?php
$connect = mysqli_connect("localhost", "root", "", "SE08102_SDLC");
if (!$connect) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}
mysqli_set_charset($connect, "utf8mb4");
?>
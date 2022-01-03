<?php
session_start();
include "./connectDB.php";
$conn = connectDB();
$user_id = $_SESSION['user_id'];

//dùng hàm trim() để bỏ khoảng trắng 2 bên của 1 chuỗi string
$content_search = trim($_GET['content_search']);

//thêm vào lịch sử tìm kiếm trên database
$sql_insert_search_history = "insert into search_history(content_search,user_id) values ('$content_search','$user_id')";
$result = mysqli_query($conn,$sql_insert_search_history);

//thêm thành công thì chuyển sang trang search, lỗi thì chuyển về home
if($result==true){
    header("Location: ../search.php?content_search=$content_search");
}
else{
    header('Location: ../home.php');
}


mysqli_close($conn);
?>
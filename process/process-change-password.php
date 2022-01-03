<?php
include './connectDB.php';
include '../send-email/sendEmail.php';
session_start();

$conn = connectDB();
$user_id = $_SESSION['user_id'];
$new_password = trim($_POST['new_password']);
$new_password_2 = trim($_POST['new_password_2']);

//nếu 2 mật khẩu nhập trùng nhau
if($new_password == $new_password_2){
    //mã hóa mật khẩu rồi lưu lên database
    $passwd_hash = password_hash($new_password, PASSWORD_DEFAULT);
    $sql_change_pass = "update user set password='$passwd_hash' where user_id='$user_id'";
    if(mysqli_query($conn, $sql_change_pass) == true){
        // tạo session gửi thông báo cho người dùng
        $_SESSION['message_password'] = 'Thay đổi mật khẩu thành công';
    }
    else{
        $_SESSION['message_password'] = 'Lỗi server, vui lòng quay lại sau';
    }
}
else{
    $_SESSION['message_password'] = 'Mật khẩu nhập không trùng nhau';
}
header('Location: ../change-password.php');


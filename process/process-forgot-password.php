<?php
include './connectDB.php';
include '../send-email/sendEmail.php';
session_start();
if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $conn = connectDB();
    //kiểm tra email này có tồn tại trên database không
    $sql_check_email = "select * from user where email='$email'";
    $result = mysqli_query($conn, $sql_check_email);
    $count = mysqli_num_rows($result);
    if ($count == 1) {
        //tạo 1 mật khẩu ngẫu nhiên bằng 1 số có 6 chữ số
        $passwd_random = (string)rand(0, 999999);
        //mã hóa mật khẩu rồi lưu lên database
        $passwd_hash = password_hash($passwd_random, PASSWORD_DEFAULT);
        $sql_change_pass = "update user set password='$passwd_hash' where email='$email'";
        //nếu thay đổi thành công thì gửi mật khẩu mới về mail cho người dùng
        if (mysqli_query($conn, $sql_change_pass) == true) {
            $title = 'Thay đổi mật khẩu';
            $content = "Facebook - Mật khẩu tài khoản $email của bạn đã được đổi thành $passwd_random";
            if (sendEmail($email, $title, $content)) {
                $_SESSION['message_change_password'] = 'Mật khẩu của bạn đã được thay đổi thành công, vui lòng kiểm tra hòm thư';
                header('Location: ../forgot-password.php');
            } else {
                $_SESSION['message_change_password'] = 'Lỗi, vui lòng thử lại sau.';
                header('Location: ../forgot-password.php');
            }
        } else {
            $_SESSION['message_change_password'] = 'Mật khẩu của bạn thay đổi thất bại, vui lòng thử lại.';
            header('Location: ../forgot-password.php');
        }
    }else{
        $_SESSION['message_change_password'] = 'Tài khoản này không tồn tại';
        header('Location: ../forgot-password.php');
    }
} else {
    $_SESSION['message_change_password'] = 'Chưa nhập email';
    header('Location: ../index.php');
}

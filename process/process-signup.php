<?php
session_start();
// Đăng ký tài khoản
include './connectDB.php';
include '../send-email/sendEmail.php';

// Khi dang ky , trong db neu chua co email nay thi them vao voi status_auth = false 
// gui email xac nhap nguoi dung , nguoi dung xac nhan thì status_auth = true
$conn = connectDB();


if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['fullname']) && isset($_POST['birthday']) && isset($_POST['sex'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $fullname = $_POST['fullname'];
    $birthday = $_POST['birthday'];
    $sex = $_POST['sex'];

    $sql = "select * from user where email = '$email'";

    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);

    // nếu số hàng trả về nhỏ hơn 0 thì tạo tài khoản cho người dùng 
    if ($count <= 0) {
        $status_auth = '0';


        // Ma hoa mat khau truoc khi luu len db
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Tao 1 key_auth de lam link kich hoat tai khoan
        $key = (string)rand(0, 1000);

        $key_auth = password_hash($key, PASSWORD_DEFAULT);

        //tao 1 tai khoan voi status_auth = false , key_auth de kich hoat duoc ma hoa , key luu tren db , key_auth gui ve client
        $sql2 = "insert into user (email,password,fullname,sex,birthday,status_auth,key_auth) values ('$email','$password_hash', '$fullname' , '$sex' ,'$birthday' ,'$status_auth','$key')";
        $result2 = mysqli_query($conn, $sql2);
        // nếu $result2 thực hiện thành công thì gửi email kích hoạt cho client
        if ($result2 == true) {
            $title = '[Kích hoạt tài khoản]';
            $bodyContent = "<a style='font-size:20px;' href='http://localhost/BaiTapLon/process/process-authentication.php/?email=$email&key_auth=$key_auth'>Click vào đây để xác nhận tài khoản $email của bạn</a>";

            if (sendEmail($email, $title, $bodyContent)) {
                $response = array('status'=>'success','response' => 'Đã gửi link xác thực tài khoản về email của bạn.');
                echo json_encode($response);
            }
        } else {
            $response = array('status'=>'error','response' => '"Lỗi hệ thống, đăng ký không thành công."');
            echo json_encode($response);
        }
    } else {
        $response = array('status'=>'error','response' => 'Tài khoản này đã tồn tại.');
        echo json_encode($response);
    }
} else {
    $response = array('status'=>'error','response' => 'Bạn điền thiếu thông tin đăng ký.');
    echo json_encode($response);
}
mysqli_close($conn);

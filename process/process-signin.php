<?php
    session_start();

    // Đăng nhập
    include './connectDB.php';
    include '../send-email/sendEmail.php';

    //Kiểm tra xem có email và password được gửi lên từ client không
    if(isset($_POST['email']) && isset($_POST['password'])){
        $email = $_POST['email'];
        $password = $_POST['password'];
        //Kết nốt tới cơ sở dữ liệu , tạo câu truy vấn tìm password của email được gửi lên
        $conn = connectDB();       
        $sql = "select password from user where email = '$email'";

        $result = mysqli_query($conn,$sql);

        // Lấy số hàng trả về của câu truy vấn
        $count = mysqli_num_rows($result);

        // Nếu tìm thấy , số hàng Database trả về là 1
        if($count == 1){

            // tạo 1 mảng row từ dữ liệu database trả về , (hằng số MYSQLI_NUM để biến mảng này thành mảng truy cập index)
            $row = mysqli_fetch_array($result,MYSQLI_NUM);

            //câu truy vấn bên trên chỉ tìm password nên mảng trả về chỉ có 1 phần tử là row[0]
            $password_hash = $row[0];

            //Lấy mật khẩu đã bị mã hóa trên Database về verify, so sánh với mật khẩu người dùng nhập
            if(password_verify($password,$password_hash)){
                // Kiểm tra status_auth của tài khoản này trên Database
                // Nếu false thì bắn xác thực, nếu true thì chuyển hướng sang home
                $sql2 = "select status_auth , key_auth from user where email = '$email'";
                $result2 = mysqli_query($conn,$sql2);
                $row2 = mysqli_fetch_array($result2,MYSQLI_NUM);
                $status_auth = $row2[0];
                $key_auth = password_hash($row2[1],PASSWORD_DEFAULT);

                //1 là true , 0 là false
                //nếu status_auth = true thì hủy biến session notify (biến này dùng để thông báo về client cho người dùng)
                if($status_auth==1){
                    if(isset($_SESSION['notify_signin'])){
                        unset($_SESSION['notify_signin']);
                    }

                    //tạo 2 biến session là id và họ tên
                    $sql3 = "select user_id,fullname,avatar from user where email = '$email'";
                    $result3 = mysqli_query($conn,$sql3);
                    $row3 = mysqli_fetch_array($result3,MYSQLI_NUM);
                    $_SESSION['user_id'] = $row3[0];
                    $_SESSION['fullname'] = $row3[1];
                    $_SESSION['avatar'] = $row3[2];
                    header('Location: ../home.php');
                }
                else{ // nếu status_auth = false thì gửi lại email bắt xác thực tài khoản
                    $title = '[Kích hoạt tài khoản]';
                    $bodyContent = "<a 
                    style='font-size:20px;'
                    href = 'http://localhost/BaiTapLon/process/process-authentication.php/?email=$email&key_auth=$key_auth' >
                    Click vào đây để xác nhận tài khoản $email của bạn</a>";

                    sendEmail($email,$title,$bodyContent);
                    $_SESSION['notify_signin'] = 'Tài khoản chưa được kích hoạt, bạn hãy kiểm tra hộp thư cửa mình.';
                    header('Location: ../index.php');
                }
            }
            else{
                //Nếu password verify = false
                $_SESSION['notify_signin'] = 'Sai tài khoản hoặc mật khẩu';
                header('Location: ../index.php');
            }
        }
        else{
            // Nếu không tìm thấy tài khoản email này trên DataBase
            $_SESSION['notify_signin']='Tài khoản này không tồn tại';
            header('Location: ../index.php');

        }
        mysqli_close($conn);
    }
?>
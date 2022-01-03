<?php
    session_start();
    // Xac thuc tai khoan
    include './connectDB.php';
    if(isset($_GET['email']) && isset($_GET['key_auth'])){
        $conn = connectDB();

        // lay email , key duoc truyen tu URL
        $email = $_GET['email'];
        $key_url = $_GET['key_auth'];

        $sql = "select key_auth from user where email = '$email'";

        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_array($result,MYSQLI_NUM);

        $key_db = $row[0];

        // kiem tra key o url va trong db trung nhau thi se set status_auth = true
        // status_auth = true thi user co the dang nhap tai khoan
        if(password_verify($key_db,$key_url)){
            $status_auth = '1';
            // 2 key verify thành công thì update lại status_auth = true 
            $sql2 = "UPDATE user SET status_auth =  $status_auth WHERE email = '$email'";
            $result2 = mysqli_query($conn,$sql2);
            if($result2){
                $_SESSION['notify_signin'] = 'Kích hoạt thành công, mời bạn đăng nhập.';
                //Điều hướng người dùng từ email về trang đăng nhập
                
                header('Location: http://localhost/BaiTapLon');
            }
            else{
                echo'Kich hoạt không thành công';
            }
        }
        else{
            echo'Kich hoạt không thành công';
        }
        mysqli_close($conn);
    }else{
        die('<h1>Truy cap that bai, duong dan nay khong ton tai</h1>');
    }
?>
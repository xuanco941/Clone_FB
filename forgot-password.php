<?php 
    session_start();
    if (isset($_SESSION['user_id'])) {
        header('Location: ./home.php');
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="./assets/img/favicon.ico">
    <link rel="stylesheet" href="./assets/css/all.css">
    <link rel="stylesheet" href="./assets/css/forgot_password.css">
    <title>Quên mật khẩu?</title>

</head>

<body>
    <div class="container">
        <div class="main">
            <a href="./index.php">
                <img src="./assets/img/fb_logo.svg" alt="logo" srcset="">
            </a>
            <form action="./process/process-forgot-password.php" method="post">
                <label for="email"></label>
                <input type="text" name="email" id="email" autocomplete="off" placeholder="Nhập tài khoản email của bạn">
                <?php if(isset($_SESSION['message_change_password'])){
                    echo '<p style="width:100%;text-align:center;">'. $_SESSION['message_change_password'] .'</p>';
                } ?>
                <button type="submit">Lấy lại mật khẩu</button>
                <a href="./index.php">Quay lại</a>
            </form>
        </div>
    </div>

</body>

</html>
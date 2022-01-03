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
    <title>Facebook - Đăng nhập hoặc đăng ký</title>
    <link rel="stylesheet" href="./assets/css/all.css">
    <link rel="stylesheet" href="./assets/css/index.css">
    <link rel="stylesheet" href="./assets/css/modal.css">
    <link rel="stylesheet" href="./assets/css/toast.css">

</head>

<body>
    <?php
    require './partials/toast.php';
    ?>
    <div class="container">
        <div class="box_main">

            <div class="box_1">
                <img src="./assets/img/fb_logo.svg" alt="logo" srcset="">
                <span class="slogan">Facebook giúp bạn kết nối và chia sẻ với mọi người trong cuộc sống của bạn.</span>
            </div>
            <div class="box_2">
                <div class="box_2_main">
                    <form class="form" action="./process/process-signin.php" method="post">
                        <input type="email" minlength="1" placeholder="Email" name="email">
                        <input type="password" minlength="1" placeholder="Mật khẩu" name="password">
                        <span style="margin-bottom: 5px;">
                            <?php
                            if (isset($_SESSION['notify_signin'])) {
                                echo $_SESSION['notify_signin'];
                            }
                            ?></span>
                        <button type="submit">Đăng nhập</button>
                        <a href="./forgot-password.php">Quên mật khẩu?</a>
                    </form>
                    <button class="new_acc" id="toogle_modal" type="button">Tạo tài khoản mới</button>
                </div>

            </div>
        </div>

        <?php
        include './partials/modal-signup.php';
        ?>
    </div>

    <div id="blocked"></div>

    <script src="./javascript/modal.js"></script>
    <script src="./javascript/fetch_signup.js"></script>
</body>

</html>
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ./index.php');
}
?>
<?php
include './process/connectDB.php';
$conn = connectDB();
$user_id = $_SESSION['user_id'];
$sql_myself = "select * from user where user_id = '$user_id'";
$result_myself = mysqli_query($conn, $sql_myself);
$row_myself = mysqli_fetch_array($result_myself, MYSQLI_NUM);
$avatar = $row_myself[6];
$fullname = $row_myself[3];
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
    <link rel="stylesheet" href="./assets/css/header.css">
    <title>Thay đổi mật khẩu</title>

</head>

<body>
    <?php include "./partials/header.php" ?>
    <div class="container">
        <div class="main">
            <a href="./index.php">
                <img src="./assets/img/fb_logo.svg" alt="logo" srcset="">
            </a>
            <form action="./process/process-change-password.php" method="post">
                <label for="email"></label>
                <input type="password" name="new_password" id="email" autocomplete="off" placeholder="Nhập mật khẩu mới">
                <input style="margin-top: 10px;" type="password" name="new_password_2" id="email" autocomplete="off" placeholder="Nhập lại mật khẩu mới">
                <?php if (isset($_SESSION['message_password'])) {
                    echo '<p style="width:100%;text-align:center;">' . $_SESSION['message_password'] . '</p>';
                } ?>
                <button type="submit">Đổi mật khẩu</button>
                <a href="./home.php">Về trang chủ</a>
            </form>
        </div>
    </div>

</body>

</html>
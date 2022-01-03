<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ./index.php');
}
?>
<?php
include "./process/connectDB.php";
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
    <title>Trang cá nhân</title>
    <link rel="stylesheet" href="./assets/css/all.css">
    <link rel="stylesheet" href="./assets/css/modal.css">
    <link rel="stylesheet" href="./assets/css/header.css">
    <link rel="stylesheet" href="./assets/css/home.css">
    <link rel="stylesheet" href="./assets/css/user.css">
</head>

<body>
    <?php
    include './partials/header.php';
    ?>
    <div class="container">
        <div class="component1">
            <a href="./user.php" class="item_component1">
                <img id="avatar_main" <?php echo "src='$avatar'" ?> alt="avatar">
                <span id="name_main"><?php echo $fullname; ?></span>
            </a>
            <a href="./chat.php" class="item_component1">
                <img class="hobby_img" src="./assets/img/chat.png" alt="chat">
                <span>Chat</span>
            </a>
        </div>

        <?php

        if (isset($_GET['user_id'])) {
            $user_id_profile = $_GET['user_id'];
        } else {
            $user_id_profile = $_SESSION['user_id'];
        }
        $sql_get_user = "select * from user where user_id = '$user_id_profile'";
        ?>

        <div class="component2 component_avatar">

            <?php
            $result_get_user = mysqli_query($conn, $sql_get_user);
            $count_result = mysqli_num_rows($result_get_user);
            if ($count_result > 0) {
                $row_user = mysqli_fetch_array($result_get_user, MYSQLI_NUM);
            ?>
                <div class="box_avatar">
                    <img <?php echo "src='$row_user[6]'"; ?> alt="">
                </div>
                <div class="box_info">
                    <?php
                         if (!(empty($_GET['user_id']) || $_GET['user_id'] == $user_id)) {
                            echo '<a href="./chat.php?chatwithid='.$row_user[0].'" class=" item_info " 
                            style="padding: 0; text-align:center; margin-bottom:30px; background-color:#fff;text-decoration:none; font-size:22px; color:#1877f2; font-weight:600"> Nhắn tin</a>';
                        }
                    ?>
                    
                    <div class=" item_info "> <span>Tên đầy đủ: </span><?php echo $row_user[3] ?></div>
                    <div class=" item_info "> <span>Email: </span> <?php echo $row_user[1] ?></div>
                    <div class=" item_info "> <span>Giới Tính: </span>
                        <?php
                        if ((string)$row_user[4] == '1') {
                            echo "Nam";
                        } else {
                            echo "Nữ";
                        }

                        ?></div>
                    <div class=" item_info "> <span>Ngày sinh: </span> <?php echo $row_user[5] ?></div>
                </div>

            <?php
                if (empty($_GET['user_id']) || $_GET['user_id'] == $user_id) {
                    echo "<div id='toogle_modal'>
                    Sửa thông tin
                    </div>";
                }
            } else {
                echo "<h2 style='text-align:center;'> Người dùng này không tồn tại </h2>";
            }
            ?>
        </div>


        <div class="component3">


            <div class="component3_title item_component1 item_component3">Danh sách người dùng</div>

            <?php
            //lay danh sach tat ca nguoi dung, ngoai ban
            $sql_get_all_user = "select * from user where user_id != '$user_id' ";
            $result6 = mysqli_query($conn, $sql_get_all_user);
            while ($row_all_user = mysqli_fetch_array($result6, MYSQLI_NUM)) {
                $user_id_all = $row_all_user[0];
                $user_fullname_all = $row_all_user[3];
                $user_avatar_all = $row_all_user[6];

            ?>

                <a <?php echo "href='./user.php?user_id=$user_id_all'" ?> class="item_component1 item_component3 online">
                    <img <?php echo "src='$user_avatar_all'"; ?> alt="avatar">
                    <span><?php echo $user_fullname_all; ?></span>
                </a>

            <?php } ?>
        </div>
    </div>


    <!-- Modal post -->

    <div class="modal" id="modal">
        <div class="box_modal" id="box_modal">
            <div class="title_modal">
                <div class="tt1">
                    <span class="title_1">Sửa thông tin</span>
                    <span style="color: #1877f2;" class="des"><?php echo $row_user[3] ?></span>
                </div>
                <button class="tt2" id="close_modal">X</button>
            </div>
            <form class="form_modal" action="./process/process-change-info.php" enctype="multipart/form-data" method="post" id="form_change_info">
                <div class="item_modal">
                    <label id="label_avatar" class="label_avatar" for="avatar_change">
                        <img <?php echo "src='$row_user[6]'"; ?> alt="">
                    </label>
                    <input id="avatar_change" type="file" name="avatar_change">
                </div>
                <div class="item_modal">
                    <input id="fullname" <?php echo "value='$row_user[3]'"; ?> type="text" minlength="1" placeholder="Họ Tên" name="fullname">
                </div>
                <div class="item_modal">
                    <input id="email" <?php echo "value='$row_user[1]'"; ?> type="text" minlength="1" placeholder="Email" name="email">
                </div>
                <div class="item_modal">
                    <input id="birthday" <?php echo "value='$row_user[5]'"; ?> type="date" name="birthday" id="birthday">
                </div>

                <button id="submit_signup" type="submit">Cập nhật</button>

            </form>
        </div>
    </div>



    <script src="./javascript/user.js"></script>
</body>

</html>
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ./index.php');
}
include "./process/connectDB.php";
$conn = connectDB();
?>
<?php 
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
    <title>Tìm kiếm bạn bè</title>
    <link rel="stylesheet" href="./assets/css/all.css">
    <link rel="stylesheet" href="./assets/css/header.css">
    <link rel="stylesheet" href="./assets/css/home.css">
    <link rel="stylesheet" href="./assets/css/friendly.css">
    <link rel="stylesheet" href="./assets/css/search.css">
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


        <div class="component2 component2_search">
            <form class="form_search_f" action="./process/process-search.php" method="GET">
                <input name="content_search" id="input_search_name" autocomplete="off" type="text" class="input_search_name" placeholder="Nhập tên bạn cần tìm">
                <button id="btn_search_name" type="submit" class="btn_search_name">Tìm</button>
            </form>
            <a class="delete_all" id="delete_all" href="./process/process-delete-history.php">Lịch sử</a>
            <div class="history_box" id="history_box">
                <?php $sql_get_history = "select * from search_history where user_id = '$user_id'";
                $result_get_history = mysqli_query($conn, $sql_get_history);
                $num = 0;
                while ($row_get_history = mysqli_fetch_array($result_get_history, MYSQLI_NUM)) {
                    $num++;
                    echo "<div class='history_text'><span style='font-size:13px; margin-right:10px;color:red;'>$num. </span> " . '  ' . "$row_get_history[1]</div>";
                }
                ?>
            </div>


            <?php
            if (isset($_GET['content_search'])) {
                $content_search = trim($_GET['content_search']);
                $sql_result_search = "select * from user where fullname like '%$content_search%'";
                $result_search = mysqli_query($conn, $sql_result_search);
                while ($row_result_search = mysqli_fetch_array($result_search, MYSQLI_NUM)) {

            ?>
                    <a class="a_people" style="margin-top: 20px;" <?php echo "href='./user.php?user_id=$row_result_search[0]'"; ?>>
                        <img <?php echo "src='$row_result_search[6]'"; ?> alt="">
                        <div class="info_a_people">
                            <div style="margin-top: 0px;" class="a_people_fullname"><?php echo $row_result_search[3]; ?></div>
                            <div style="font-size: 11px;" class="a_people_fullname date_a_people">Sinh nhật: <?php echo $row_result_search[5]; ?></div>
                            <?php
                            if ((string)$row_result_search[4] == '1') {
                                $sex = 'Nam';
                            } else {
                                $sex = 'Nữ';
                            }
                            ?>
                            <div style="font-size: 11px;" class="a_people_fullname sex_a_people">Giới tính: <?php echo $sex; ?></div>
                        </div>
                    </a>

            <?php
                }
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

</body>

</html>

<script src="./javascript/search.js"></script>
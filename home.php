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
    <title>Facebook</title>
    <link rel="stylesheet" href="./assets/css/all.css">
    <link rel="stylesheet" href="./assets/css/modal.css">
    <link rel="stylesheet" href="./assets/css/header.css">
    <link rel="stylesheet" href="./assets/css/home.css">
    <link rel="stylesheet" href="./assets/css/post.css">
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
        <div class="component2">
            <div class="component2_title">
                <div class="box_component2_img">
                    <img <?php echo "src='$avatar'" ?> alt="avatar">
                </div>
                <input id="toogle_modal" type="text" <?php echo "placeholder = '$fullname ơi, bạn đang nghĩ gì thế?'" ?>>
            </div>




            <?php

            $sql_get_all = 'select * from post';
            $result1 = mysqli_query($conn, $sql_get_all);
            while ($row_post = mysqli_fetch_array($result1, MYSQLI_NUM)) {

                //lấy ra tên của người đăng bài 
                $sql_get_name_user = "select fullname,avatar from user where user_id = '$row_post[3]'";
                $result2 = mysqli_query($conn, $sql_get_name_user);
                //user_id chỉ có 1
                $row_user = mysqli_fetch_array($result2, MYSQLI_NUM);

            ?>


                <div class="post" <?php echo "id='post_$row_post[0]'" ?>>
                    <div class="header_post">
                        <img <?php echo "src='$row_user[1]'"; ?> alt="avatar">
                        <div class="name_and_time">
                            <a <?php echo "href='./user.php?user_id=$row_post[0]'"; ?> class="fullname"><?php echo $row_user[0]; ?></a>
                            <div class="createAt"><?php echo $row_post[4] ?></div>
                        </div>
                    </div>
                    <div class="content_post">
                        <div class="text_content"><?php echo $row_post[1] ?></div>
                        <div class="box_img_content">
                            <?php
                            if ($row_post[2]) {
                                echo "<img src='./uploads/$row_post[2]' alt='img post' >";
                            }
                            ?>
                        </div>
                    </div>
                    <div class="react_post">
                        <img src="./assets/img/like_react.svg" alt="react" srcset="">
                        <?php $sql_count_react = " select count(*) from react where post_id='$row_post[0]'";
                        $result7 = mysqli_query($conn, $sql_count_react);
                        $count = mysqli_fetch_array($result7, MYSQLI_NUM)[0];
                        ?>
                        <span <?php echo "id='count_react_$row_post[0]'" ?>><?php echo "$count"; ?></span>
                    </div>
                    <div class="action_post">
                        <div class="button_action btn_separate btn_react" <?php echo "id='react_$row_post[0]_$user_id'" ?>>
                            <?php
                            $sql_get_liked = "select * from react where user_id =" . $_SESSION['user_id'] . " and post_id = '$row_post[0]'";
                            $result5 = mysqli_query($conn, $sql_get_liked);
                            $count = mysqli_num_rows($result5);
                            if ($count < 1) {
                                echo "<img id='unlike_$row_post[0]' alt='unliked' src='./assets/img/unlike.png'>";
                            } else {
                                echo "<img id='like_$row_post[0]' class='liked_icon' alt='liked' src='./assets/img/liked.png'>";
                            }
                            ?>
                            Thích
                        </div>
                        <div class="button_action btn_action_comment" <?php echo "id='btn_$row_post[0]'"; ?>>
                            <img class="img_comment" src="./assets/img/comment_button.png" alt="comment">
                            Bình Luận
                        </div>
                    </div>
                    <div class="comment_post" <?php echo "id='cmt_$row_post[0]'"; ?>>

                        <?php
                        $sql_get_comment = "select * from comment where post_id = '$row_post[0]'";
                        $result4 = mysqli_query($conn, $sql_get_comment);
                        while ($row_comment = mysqli_fetch_array($result4, MYSQLI_NUM)) {
                        ?>

                            <div class="box_comment_post">
                                <?php
                                $sql_get_user_comment = "select * from user where user_id = '$row_comment[2]' ";
                                $result8 = mysqli_query($conn, $sql_get_user_comment);
                                $row_user_comment = mysqli_fetch_array($result8, MYSQLI_NUM);
                                ?>
                                <img <?php echo "src='$row_user_comment[6]'" ?> alt="">
                                <div class="name_and_time name_comment">
                                    <a <?php echo "href='./user.php?user_id=$row_user_comment[0]'" ?> class="fullname"><?php echo "$row_user_comment[3]" ?></a>
                                    <div class="text_comment"><?php echo "$row_comment[1]" ?></div>
                                </div>
                            </div>

                        <?php } ?>


                        <div class="box_input_comment" <?php echo "id='input_$row_post[0]'" ?>>
                            <img <?php echo "src='$avatar'" ?> alt="">
                            <textarea placeholder="Viết bình luận..." name="text_content" cols="30" rows="10" class="text_class" <?php echo "id='text_$row_post[0]'" ?>></textarea>
                            <button class="submit_class" <?php echo "id='submit_$row_post[0]_$user_id'" ?> type="submit">Đăng</button>
                        </div>

                    </div>
                </div>



            <?php
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
    <div id="modal">
        <div id="box_modal">
            <form action="./process/process-post.php" method="post" enctype="multipart/form-data" id="post_post">
                <div class="head_modal">
                    <textarea placeholder="Nội dung ..." name="text_content_post" id="text_content_post" cols="30" rows="30"></textarea>
                    <div id="close_modal">X</div>
                </div>
                <div class="content_modal">
                    <label class="content_image" for="content_image" id="label_img">
                        Chọn ảnh
                    </label>
                    <input type="file" id="content_image" name="content_image">
                </div>
                <div class="footer_form">
                    <button id="btn_submit_post" type="submit">Đăng</button>
                </div>
            </form>
        </div>
    </div>


    <script src="./javascript/modal.js"></script>
    <script src="./javascript/library/autosize.min.js"></script>
    <script>
        autosize(document.querySelectorAll('textarea'));
    </script>
    <script src="./javascript/upload_post.js"></script>

    <script src="./javascript/comment_post.js"></script>
    <script src="./javascript/like_post.js"></script>


</body>

</html>
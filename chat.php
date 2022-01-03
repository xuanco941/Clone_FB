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
    <title>Chat</title>
    <link rel="stylesheet" href="./assets/css/all.css">
    <link rel="stylesheet" href="./assets/css/header.css">
    <link rel="stylesheet" href="./assets/css/home.css">
    <link rel="stylesheet" href="./assets/css/chat.css">

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
            <div class="boxchat">
                <div class="chathistory">
                    <?php
                    if (isset($_GET['chatwithid'])) {
                        $chatwithid = $_GET['chatwithid'];
                    }
                    $sql_chathistory = "select distinct sender_userid,reciever_userid from chat where sender_userid = '$user_id' or reciever_userid = '$user_id'";
                    //chọn ra người gửi hoặc người nhận có userid = $_SESSION['user_id'] , lấy kết quả không trùng nhau
                    $result_chathistory = mysqli_query($conn, $sql_chathistory);
                    $arr_users = [];
                    while ($row_chathistory = mysqli_fetch_array($result_chathistory, MYSQLI_NUM)) {
                        //kiểm tra userid nào là người chat cùng mình
                        if ($row_chathistory[0] == $user_id) {
                            $user_friend = $row_chathistory[1];
                        } else {
                            $user_friend = $row_chathistory[0];
                        }
                        //thêm vào 1 mảng users
                        array_push($arr_users, $user_friend);
                    }
                    //loại các giá trị giống nhau trong mảng
                    $arr_users_friend = array_unique($arr_users);
                    // lấy thông tin của từng user chat cùng mình từ mảng arr_users_friend
                    foreach ($arr_users_friend as $a_user) {
                        $sql_user_friend = "select * from user where user_id = '$a_user'";
                        $result_user_friend = mysqli_query($conn, $sql_user_friend);
                        $row_user_friend = mysqli_fetch_array($result_user_friend, MYSQLI_NUM);
                    ?>
                        <a class="user" <?php if (isset($chatwithid) && $chatwithid == $row_user_friend[0]) {
                                            echo "style='background-color: #fff;'";
                                        } ?> <?php echo "href='./chat.php?chatwithid=$row_user_friend[0]'" ?>>
                            <img <?php echo "src='$row_user_friend[6]'" ?> alt="avatar">
                            <div class="name_and_notify">
                                <div class="fullname"><?php echo "$row_user_friend[3]" ?></div>
                                <!-- <div class="notify"></div> -->
                            </div>
                        </a>
                    <?php
                    }
                    ?>

                </div>
                <div class="chatmain">
                    <?php
                    if (isset($chatwithid)) {
                        $sql_user_chat = "select * from user where user_id='$chatwithid'";
                        $result_user_chat = mysqli_query($conn, $sql_user_chat);
                        $row_user_chat = mysqli_fetch_array($result_user_chat, MYSQLI_NUM);
                        echo ' <a id="reciever_' . $row_user_chat[0] . '" class="name_user user_reciever" href="./user.php?user_id=' . $row_user_chat[0] . '">' . $row_user_chat[3] . '</a>';
                    }
                    ?>

                    <div class="chat" id="chat">
                        <?php
                        if (isset($chatwithid)) {
                            $sql_user_chat = "select * from chat where sender_userid = '$chatwithid' and reciever_userid = '$user_id' or
                        sender_userid = '$user_id' and reciever_userid = '$chatwithid' ";
                            $result_user_chat = mysqli_query($conn, $sql_user_chat);
                            while ($row_chat = mysqli_fetch_array($result_user_chat)) {
                                if ($row_chat[1] == $user_id) {
                                    echo '<div class="my_mess a_mess">
                                <div class="my_text">' . $row_chat[3] . ' </div>
                                <img src="' . $avatar . '" alt="">
                            </div>';
                                } else {
                                    echo '<div class="your_mess a_mess">
                                <img src="' . $row_user_chat[6] . '" alt="">
                                <div class="your_text">' . $row_chat[3] . '</div>
                            </div>';
                                }
                            }
                        }
                        ?>
                    </div>
                    <?php
                    if (isset($chatwithid)) {
                        echo '<form id="form_mess" action="post" method="post">
                            <input autocomplete="off" id="message" type="text" placeholder="chat..." class="input_chat"></input>
                            <button id=sender_' . $user_id . ' class="user_sender" type="submit">Gửi</button>
                        </form>';
                    }
                    ?>


                </div>
            </div>

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





    <script src="./javascript/chat.js"></script>

</body>

</html>
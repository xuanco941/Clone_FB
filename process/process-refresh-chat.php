<?php
include './connectDB.php';
$conn = connectDB();
$sender_userid = $_POST['sender_userid'];
$reciever_userid = $_POST['reciever_userid'];

//lấy link avatar người gửi
$sql_user_sender = "select * from user where user_id = '$sender_userid'";
$result_sender = mysqli_query($conn,$sql_user_sender);
$row_sender = mysqli_fetch_array($result_sender,MYSQLI_NUM);

$avatar_sender = $row_sender[6];

//lấy link avatar người nhận
$sql_user_reciever = "select * from user where user_id = '$reciever_userid'";
$result_reciever = mysqli_query($conn,$sql_user_reciever);
$row_reciever = mysqli_fetch_array($result_reciever,MYSQLI_NUM);

$avatar_reciever = $row_reciever[6];

//lấy tất cả tin nhắn của 2 người
$sql_user_chat = "select * from chat where sender_userid = '$reciever_userid' and reciever_userid = '$sender_userid' or
sender_userid = '$sender_userid' and reciever_userid = '$reciever_userid' ";

//đưa tất cả tin nhắn vào 1 mảng
$result_get_all_message = mysqli_query($conn,$sql_user_chat);
$arr_chat = [];
while($row = mysqli_fetch_array($result_get_all_message)){
    array_push($arr_chat,$row);
}

//đưa 2 avatar vào 1 mảng
$avatar = [$avatar_sender,$avatar_reciever];

//trả dữ liệu là avatar của 2 người và đoạn chat của họ
$data = array('avatar'=>$avatar,'arr_chat'=>$arr_chat);
echo json_encode($data);
?>
<?php
include './connectDB.php';
$conn = connectDB();
$sender_id = $_POST['sender_id'];
$reciever_id = $_POST['reciever_id'];
$content = $_POST['content'];

$sql_user_sender = "select * from user where user_id = '$sender_id'";
$result_sender = mysqli_query($conn,$sql_user_sender);
$row_sender = mysqli_fetch_array($result_sender,MYSQLI_NUM);


$avatar_sender = $row_sender[6];

$sql_chat = "insert into chat (sender_userid,reciever_userid,content) values ('$sender_id','$reciever_id','$content')";
$result_chat = mysqli_query($conn,$sql_chat);
if($result_chat==true){
    echo json_encode('success');
}
else{
    echo json_encode('error');
}


mysqli_close($conn);
?>
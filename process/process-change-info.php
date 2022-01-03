<?php
session_start();

include "./connectDB.php";
include "./uploadImg.php";
$conn = connectDB();
$user_id = $_SESSION['user_id'];

$email = $_POST['email'];
$fullname = $_POST['fullname'];
$birthday = $_POST['birthday'];
$file = $_FILES['avatar_change'];
$avatar = $_FILES['avatar_change']['name'];
if(strlen($avatar)>0){
    $sql_update_info = "update user set email = '$email', fullname = '$fullname' , birthday='$birthday' , avatar = './uploads/$avatar' where user_id='$user_id'";
    if(upImg($file)==true){
        $result = mysqli_query($conn,$sql_update_info);
    }
}
else{
    $sql_update_info = "update user set email = '$email', fullname = '$fullname' , birthday='$birthday' where user_id='$user_id'";
    $result = mysqli_query($conn,$sql_update_info);
    if($result==true){
        mysqli_query($conn,$sql_update_info);
    }
}
header('Location: ../user.php');





?>
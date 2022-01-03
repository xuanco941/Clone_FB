<?php

include "./connectDB.php";
$conn = connectDB();
$user_id = $_POST['user_id'];
$post_id = $_POST['post_id'];
$content_text = $_POST['content_text'];

//neu them comment thanh cong thi tra ve du lieu json success , loi thi tra ve error
$sql_add_comment = "insert into comment (content_text,user_id,post_id) values ('$content_text','$user_id','$post_id')";

if(mysqli_query($conn,$sql_add_comment)==true){
    echo json_encode("success");
}
else{
    echo json_encode("error");
}

mysqli_close($conn);
?>
<?php
session_start();
include "./connectDB.php";
$conn = connectDB();
$user_id = $_SESSION['user_id'];


//neu them comment thanh cong thi tra ve du lieu json success , loi thi tra ve error
$sql_delete_history = "delete from search_history where user_id = '$user_id'";

$result = mysqli_query($conn,$sql_delete_history);
if($result==true){
    if(isset($_POST['content_search'])){
        $content_search = $_POST['content_search'];
        header("Location: ../search.php?content_search=$content_search");
    }
    else{
        header('Location: ../search.php');
    }
}
else{
    header('Location: ../search.php');
}

mysqli_close($conn);

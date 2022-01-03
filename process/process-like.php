<?php
include "./connectDB.php";
$conn = connectDB();

$post_id = $_POST['post_id'];
$user_id = $_POST['user_id'];
$action = $_POST['action'];

//ham nay de lay so luong like cua 1 post
function countReact($conn,$post_id) {
    $sql_count_react_post = "select count(*) from react where post_id = '$post_id'";
    $result=mysqli_query($conn,$sql_count_react_post);
    $count = mysqli_fetch_array($result,MYSQLI_NUM)[0];
    return $count;
}

if($action=='like'){
    $sql_like = "insert into react (user_id,post_id) values ('$user_id','$post_id')";
    if(mysqli_query($conn,$sql_like) == true){
        $count = countReact($conn,$post_id);
        $response = array('status'=>'like','count_like'=>$count);
        echo json_encode($response);
    }
}
else{
    $sql_unlike = "delete from react where user_id='$user_id' and post_id='$post_id'";
    if(mysqli_query($conn,$sql_unlike) == true){
        $count = countReact($conn,$post_id);
        $response = array('status'=>'unlike','count_like'=>$count);
        echo json_encode($response);
    }
}

mysqli_close($conn);
?>
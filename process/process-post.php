<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
}
include './connectDB.php';
include './uploadImg.php';

$conn = connectDB();

$title = $_POST['text_content_post'];
$image = $_FILES['content_image'];
$user_id = $_SESSION['user_id'];

echo "insert into post (title,image,user_id) values ('$title',".$image['name'].",'$user_id')";

//up lên database , chuyển hướng về home
if (isset($title) && isset($image)) {
    $sql_up_posts = "insert into post (title,image,user_id) values ('$title','".$image['name']."','$user_id')";
    if (upImg($image) == true) {
        mysqli_query($conn, $sql_up_posts);
    }
    header('Location: ../home.php');
} else {
    if (isset($title) && !isset($image)) {
        $sql_up_posts = "insert into post (title,user_id) values ('$title','$user_id')";
        mysqli_query($conn, $sql_up_posts);
        header('Location: ../home.php');
    }
    if (!isset($title) && isset($image)) {
        $sql_up_posts = "insert into post (image,user_id) values ('".$image['name']."','$user_id')";
        if (upImg($image) == true) {
            mysqli_query($conn, $sql_up_posts);
        }
        header('Location: ../home.php');
    }
}

mysqli_close($conn);

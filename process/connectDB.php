<?php
    function connectDB(){
        $conn = mysqli_connect('localhost','root','','facebook');
        if($conn){
            return $conn;
        }
        else{
            die('Không thể kết nối tới Database');
        }
    }

?>
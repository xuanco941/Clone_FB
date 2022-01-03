<header class="header">
    <div class="box1" >
        <a class="box1_logo" href="./home.php">
            <img src="./assets/img/logo.png" alt="logo">
        </a>
        <a <?php echo "href='./search.php?user_id=" . $_SESSION['user_id'] . "'"; ?> class="box1_search_mb">
            <img src="./assets/img/icon_tim_kiem.svg" alt="" srcset="">
        </a>
        <div class="box1_search">
            <label for="search_pc"><img src="./assets/img/icon_tim_kiem.svg" alt="icon_tim_kiem" srcset=""></label>
            <input id="search" type="text" autocomplete="off" placeholder="Tìm bạn trên Facebook">
        </div>
    </div>
    <div class="box2">
        <a class="box2_logo" href="./home.php">
            <img src="./assets/img/fb_logo.svg" alt="logo" srcset="">
        </a>
    </div>
    <div class="box3">
        <a class="box3_user" href='./user.php'>
            <img <?php echo "src='$avatar'"; ?> alt="">
            <span> <?php echo $fullname; ?></span>
        </a>
        <a class="box3_signout text_signout_header" href="./change-password.php">Đổi mật khẩu</a>
        <a class="box3_signout text_signout_header" href="./process/process-signout.php">Đăng xuất</a>
        <div class="menu_mb">
            <div class="menu_mb_item"></div>
            <div class="menu_mb_item"></div>
            <div class="menu_mb_item"></div>

            <div class="menu_mb_tab">
                <a href="./search.php">Tìm bạn</a>
                <a href="./chat.php">Chat</a>
                <a href="./change-password.php">Đổi mật khẩu</a>
                <a href="./process/process-signout.php">Đăng xuất</a>
            </div>
        </div>
    </div>
</header>



<script src="./javascript/search_header.js"></script>
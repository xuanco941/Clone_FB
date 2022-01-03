<div class="modal" id="modal">
    <div class="box_modal" id="box_modal">
        <div class="title_modal">
            <div class="tt1">
                <span class="title_1">Đăng ký</span>
                <span class="des">Nhanh chóng và dễ dàng</span>
            </div>
            <button class="tt2" id="close_modal">X</button>
        </div>
        <form class="form_modal" action="./process/process-signup.php" method="post" id="form_signup">
            <div class="item_modal">
                <input id="fullname" type="text" minlength="1" placeholder="Họ Tên" name="fullname">
            </div>
            <div class="item_modal">
                <input id="email" type="text" minlength="1" placeholder="Email" name="email">
            </div>
            <div class="item_modal">
                <input id="password" type="password" minlength="1" placeholder="Mật khẩu mới" name="password">
            </div>
            <div class="item_modal">
                <input id="birthday" type="date" name="birthday" id="birthday">
            </div>
            <div class="item_modal">
                <span class="radio_sex">
                    <label for="radio_male">Nam</label>
                    <input type="radio" name="sex" id="radio_male">
                </span>
                <span class="radio_sex">
                    <label for="radio_male">Nữ</label>
                    <input type="radio" name="sex" id="radio_female">
                </span>

            </div>
            <button id="submit_signup" type="submit">Đăng ký</button>

        </form>
    </div>
</div>

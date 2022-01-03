
const form_signup = document.querySelector('#form_signup');
const fullname = document.querySelector('#fullname');
const email = document.querySelector('#email');
const password = document.querySelector('#password');
const birthday = document.querySelector('#birthday');
const radio_male = document.querySelector('#radio_male');
const radio_female = document.querySelector('#radio_female');
const toast = document.querySelector('#toast');
const submit_signup = document.querySelector('submit_signup');
const blocked = document.querySelector('#blocked');

// Khi form được gửi thì sẽ ngăn hành động mặc định và gửi biểu mẫu bằng js
form_signup.onsubmit = (e) => {
    e.preventDefault();
    // khi form đang gửi thì bật thẻ blocked để ngăn người dùng ấn phần tử khác
    blocked.style.display = 'block';
    let sex = '0';
    //nếu check radio nam thì sex=1 , nữ thì sex=0
    if (radio_male.checked == true) {
        sex = '1';
    }
    if (radio_female.checked == true) {
        sex = '0';
    }

    //tạo formdata để gửi dữ liệu
    let formData = new FormData();
    formData.append('fullname', fullname.value);
    formData.append('email', email.value);
    formData.append('password', password.value);
    formData.append('birthday', birthday.value);
    formData.append('sex', sex);

    // kiểm tra người dùng nhập đủ dữ liệu chưa
    // nếu đã nhập đủ, sẽ dùng fetch để gửi
    if (fullname.value && email.value && password.value && birthday.value && (radio_male.checked==true || radio_female.checked==true)) {
        fetch('http://localhost/BaiTapLon/process/process-signup.php', {
            method: 'POST',
            body: formData
        }).then(res => res.json())
            .then((data) => {
                if (data) {
                    if (data.status == 'success') {
                        modal.style.display = 'none';
                    }
                    toast.style.display = 'block';
                    blocked.style.display = 'none';
                    toast.textContent = data.response;
                    setTimeout(() => {
                        toast.style.display = 'none';
                    }, 5000)
                }
            })
    } else {
        //nếu chưa nhập đủ sẽ thông báo
        blocked.style.display = 'none';
        toast.style.display = 'block';
        toast.textContent = 'Chưa điền đủ thông tin';
        setTimeout(() => {
            toast.style.display = 'none';
        }, 4800)
    }

}
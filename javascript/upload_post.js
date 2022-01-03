//khi lớp modal xuất hiện , ngăn focus ô input
toogle_modal.onfocus = (e) => {
    toogle_modal.blur();
}

//mỗi nút bình luận khi ấn sẽ hiện ra 1 lịch sử comment khác nhau
const btn_action_comment = Array.from(document.querySelectorAll('.btn_action_comment'));
btn_action_comment.forEach(e => {
    e.onclick = () => {
        const idPost = e.id.split('_')[1];
        let elm = document.querySelector(`#cmt_${idPost}`);
        elm.style.display == 'block' ? elm.style.display = 'none' : elm.style.display = 'block';
    }
});


// ngăn gửi đi khi chưa chọn ảnh
const post_post = document.querySelector('#post_post');
const content_image = document.querySelector('#content_image');
const label_img = document.querySelector('#label_img');

//hàm kiểm tra có phải ảnh hay không
function isFileImage(file) {
    return file && file['type'].split('/')[0] === 'image';
}

//mỗi khi chọn ảnh thì tạo ra 1 link chứa ảnh tạm , và push ra ảnh để xem trước
content_image.onchange = (e) => {
    const files = Array.from(e.target.files).filter(f => isFileImage(f) === true);
    if (files[0]) {
        const preview = URL.createObjectURL(files[0]);
        label_img.innerHTML = `<img src='${preview}' alt='img'/>`;
    }
}

//ngăn gửi đi nếu chưa có ảnh và tiêu đề
post_post.onsubmit = (e) => {
    const files = Array.from(content_image.files).filter(f => isFileImage(f) === true);
    if (!files[0] && !text_content_post.value) {
        e.preventDefault();
    }

}
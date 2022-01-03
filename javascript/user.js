//modal
const toogle_modal = document.querySelector('#toogle_modal');
const modal = document.querySelector('#modal');
const close_modal = document.querySelector('#close_modal');
const box_modal = document.querySelector('#box_modal');
const avatar_change = document.querySelector('#avatar_change');
const label_avatar = document.querySelector('#label_avatar');
// bật tắt lớp modal
toogle_modal.onclick = () => {
    modal.style.display = 'flex';
}
close_modal.onclick = (e) => {
    modal.style.display = 'none';
}
modal.onclick = (e) => {
    modal.style.display = 'none';
}
//ngăn thì ấn vào form thì xuấy hiện hành động nổi bọt của modal sẽ bị tác động
box_modal.onclick = (e) => {
    e.stopPropagation();
}


//hàm kiểm tra có phải ảnh hay không
function isFileImage(file) {
    return file && file['type'].split('/')[0] === 'image';
}

//mỗi khi chọn ảnh thì tạo ra 1 link chứa ảnh tạm , và push ra ảnh để xem trước
avatar_change.onchange = (e) => {
    const files = Array.from(e.target.files).filter(f => isFileImage(f) === true);
    if (files[0]) {
        const preview = URL.createObjectURL(files[0]);
        label_avatar.innerHTML = `<img src='${preview}' alt='img'/>`;
    }
}


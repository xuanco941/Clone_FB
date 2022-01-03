const modal = document.querySelector('#modal');
const close_modal = document.querySelector('#close_modal');
const box_modal = document.querySelector('#box_modal');
const toogle_modal = document.querySelector('#toogle_modal');

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

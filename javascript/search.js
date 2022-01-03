const delete_all = document.querySelector('#delete_all');
const a_people = Array.from(document.querySelectorAll('.a_people'));
const history_box = document.querySelector('#history_box');

delete_all.onmousemove = () => {
    if (a_people.length > 0) {
        a_people.forEach(e => {
            e.style.display = 'none';
        })
    }
    delete_all.textContent = 'Xóa tất cả lịch sử';
    delete_all.style.backgroundColor = '#dc3545';
}
delete_all.onmouseout = () => {
    if (a_people.length > 0) {
        a_people.forEach(e => {
            e.style.display = 'flex';
        })
    }
    delete_all.textContent = 'Lịch sử';
    delete_all.style.backgroundColor = '#1877f2';
}

history_box.onmousemove = () => {
    if (a_people.length > 0) {
        a_people.forEach(e => {
            e.style.display = 'none';
        })
    }
    delete_all.textContent = 'Xóa tất cả lịch sử';
    delete_all.style.backgroundColor = '#dc3545';
}
history_box.onmouseout = () => {
    if (a_people.length > 0) {
        a_people.forEach(e => {
            e.style.display = 'flex';
        })
    }
    delete_all.textContent = 'Lịch sử';
    delete_all.style.backgroundColor = '#1877f2';
}
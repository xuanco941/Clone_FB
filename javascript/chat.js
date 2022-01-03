const user_reciever = Array.from(document.querySelectorAll('.user_reciever'))[0];
const user_sender = Array.from(document.querySelectorAll('.user_sender'))[0];
const sender_id = user_sender.id.split('_')[1];
const reciever_id = user_reciever.id.split('_')[1];
const form_mess = document.querySelector('#form_mess');
const message = document.querySelector('#message');
const chat = document.querySelector('#chat');
chat.scrollTop = chat.scrollHeight - chat.clientHeight;

// load lại hộp tin
function refresh_chat() {
    let formData = new FormData();
    formData.append('sender_userid', sender_id);
    formData.append('reciever_userid', reciever_id);
    fetch('./process/process-refresh-chat.php', {
        method: 'POST',
        body: formData
    }).then(res => res.json())
        .then(data => {
            chat.innerHTML = '';
            data.arr_chat.forEach((e) => {
                if (sender_id == e.sender_userid) {
                    chat.insertAdjacentHTML('beforeend', `<div class="my_mess a_mess"><div class="my_text">${e.content}</div><img src="${data.avatar[0]}" alt="avatar"></div>`);
                } else {
                    chat.insertAdjacentHTML('beforeend', `<div class="your_mess a_mess">
                                <img src="${data.avatar[1]}" alt="">
                                <div class="your_text">${e.content}</div>
                            </div>`);
                }
            })
        })
}


let count_a_mess = Array.from(document.querySelectorAll('.a_mess')).length;


// sau 800ms sẽ tải lại hộp tin
setInterval(() => {
    refresh_chat();
}, 800);

//sau 1000ms số lượng tin nhắn tăng lên thì sẽ tự động đưa thanh scroll xuống cuối để xem tin mới nhất
setInterval(() => {
    let a_mess = Array.from(document.querySelectorAll('.a_mess'));
    if (count_a_mess < a_mess.length) {
        chat.scrollTop = chat.scrollHeight - chat.clientHeight;
        count_a_mess = a_mess.length;
    }
}, 1000);



// thêm tin nhắn
form_mess.onsubmit = (e) => {
    e.preventDefault();
    if (message.value) {
        let content = message.value;
        let formData = new FormData();
        formData.append('sender_id', sender_id);
        formData.append('reciever_id', reciever_id);
        formData.append('content', content);

        fetch('./process/process-chat.php', {
            method: 'POST',
            body: formData
        }).then(res => res.json())
            .then(data => {
                message.value = '';
                message.focus();
            })
    }

}
const submit_class = Array.from(document.querySelectorAll('.submit_class'));
submit_class.forEach((elm) => {
    elm.onclick = () => {
        let post_id = elm.id.split('_')[1];
        let user_id = elm.id.split('_')[2];
        let content_text = document.querySelector(`#text_${post_id}`).value;
        let formData = new FormData();
        let input_post = document.querySelector(`#input_${post_id}`);
        let avatar_main = document.querySelector('#avatar_main').src;
        let name_main = document.querySelector('#name_main').textContent;
        formData.append('post_id', post_id);
        formData.append('user_id', user_id);
        formData.append('content_text', content_text);

        fetch('./process/process-comment.php', {
            method: "POST",
            body: formData
        })
            .then(res => res.json())
            .then(data => {
                if (data == 'success') {
                    input_post.insertAdjacentHTML('beforebegin', ` 
                <div class="box_comment_post">
                <img src="${avatar_main}" alt="avatar">
                <div class="name_and_time name_comment">
                    <a href="./user.php?user_id=${user_id}" class="fullname">${name_main}</a>
                    <div class="text_comment">${content_text}</div>
                </div>
                     </div>
                 `);
                    document.querySelector(`#text_${post_id}`).value = '';
                }
            })

    }
})

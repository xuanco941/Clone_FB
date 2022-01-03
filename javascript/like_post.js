const btn_react = Array.from(document.querySelectorAll('.btn_react'));
btn_react.forEach(elm => {
    elm.onclick = () => {
        post_id = elm.id.split('_')[1];
        user_id = elm.id.split('_')[2]
        let unlike = document.querySelector(`#unlike_${post_id}`);
        let action = unlike ? 'like' : 'unlike';
        let formData = new FormData();
        let count_react = document.querySelector(`#count_react_${post_id}`);
        formData.append('post_id', post_id);
        formData.append('user_id', user_id);
        formData.append('action', action);

        fetch('./process/process-like.php', {
            method: "POST",
            body: formData
        }).then(res => res.json())
            .then(data => {
                if (data.status == 'like') {
                    elm.innerHTML = `<img id='like_${post_id}' class='liked_icon' alt='liked' src='./assets/img/liked.png'>`;
                }
                else {
                    elm.innerHTML = `<img id='unlike_${post_id}' alt='unliked' src='./assets/img/unlike.png'>`;
                }
                count_react.textContent = data.count_like;
            });
    }
})
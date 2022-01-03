
//khi ấn enter ở thanh tìm kiếm ở header thì chuyển sang trang tìm kiếm
const search = document.querySelector('#search');
search.addEventListener("keyup", function (event) {
    if (event.keyCode === 13) {
        window.location = `./process/process-search.php?content_search=${search.value}`;
    }
});
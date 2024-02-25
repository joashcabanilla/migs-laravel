const postAjax = (url, data = {}) => {
    return $.ajax({
        type:"POST",
        url:url,
        data: data
    });
};
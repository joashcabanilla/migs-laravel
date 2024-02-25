$("#loginForm").submit((e) => {
    e.preventDefault();
    let data = $(e.currentTarget).serializeArray();
    let login = postAjax("Login", data);

    login.done((res) => {
        if(res.status == "success"){
            location.reload();
        }else{
            $(".error-text").text(res.message).removeClass("d-none");
            setTimeout(() => {
                $(".error-text").addClass("d-none");
            },3000);
        }
    });
});

$("#showPassword").change((e)  => {
    if($(e.currentTarget).is(":checked")){
        $("#password").attr("type", "text");
    }else{
        $("#password").attr("type", "password");
    }
});
$("#verifierForm").submit((e) => {
    e.preventDefault();
    let data = $(e.currentTarget).serializeArray();
    let verifymember = postAjax("Verifymember", data);

    verifymember.done((res) => {
        !$(".norecord-verifier").hasClass("d-none") ? $(".norecord-verifier").addClass("d-none") : "";
        $(".search-container-verifier").empty();
        if (res.status == "success") {
            res.data.forEach((data) => {
                let migs = {
                    status: "M I G S!",
                    color: "green",
                    canVote: true,
                };
                let membercard = $(".memcard-verifier").clone();

                membercard.removeClass("memcard-verifier").removeClass("d-none");
                membercard.find(".memberName").text(data.name);
                membercard.find(".pbno").text(data.pbno).css("color", data.pbno == "No Data" ? "gray" : "green");
                membercard.find(".memberID").text(data.memid).css("color", data.memid == "No Data" ? "gray" : "green");

                if (data.status != "MIGS") {
                    migs.status = "N O N - M I G S!";
                    migs.color = "red";
                    migs.canVote = false;
                }

                membercard.find(".status").text(migs.status).css("color", migs.color);

                if (migs.canVote) {
                    membercard.find(".voteBtn").removeClass("d-none").css("color", "purple");
                } else {
                    membercard.find(".nonMigs").parent().removeClass("d-none").addClass("d-flex").children().first().css("color", "purple").next().css("color", "blue");
                }

                if (res.electionStatus == "closed" && res.f2felectionStatus == "closed") {
                    membercard.find(".voteBtn").remove();
                }

                membercard.find(".nonMigs").click((e) => {
                    $("#nonMigsForm").find(".nonmigs-membername").text(data.name);
                    $("#nonMigsForm").find("input[name='Id']").val(data.id);
                    $("#nonMigsModal").modal("show");
                });

                membercard.find(".voteBtn").click((e) => {
                    $.ajax({
                        type: "POST",
                        url: "SetVoterId",
                        data: { id: data.id },
                        success: (res) => {
                            window.location.href = "/voter";
                        }
                    });
                });

                $(".search-container-verifier").append(membercard);
            });

        } else {
            $(".norecord-verifier").removeClass("d-none");
        }
    });
});

$('#nonMigsModal').on('shown.bs.modal', function (e) {
    $("#nonMigsForm").trigger("reset");
    $("#nonmigs-contact").focus();
});

$("#nonmigs-contact").on('input', function (e) {
    $(this).val($(this).val().replace(/[^0-9]/g, ''));
});

$("#nonMigsForm").submit((e) => {
    e.preventDefault();
    let data = $(e.currentTarget).serializeArray();
    let nonmigs = postAjax("Nonmigschangestatus", data);
    nonmigs.done((res) => {
        if (res.status == "success") {
            Swal.fire({
                title: "REQUEST FOR MIGS STATUS VERIFICATION",
                text: res.message,
                icon: "success",
                confirmButtonText: "OK",
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then((result) => {
                $("#nonMigsModal").modal("hide");
            });
        } else {
            Swal.fire({
                title: "REQUEST FOR MIGS STATUS VERIFICATION",
                text: res.message,
                icon: "warning",
                confirmButtonText: "OK",
                allowOutsideClick: false,
                allowEscapeKey: false
            })
        }

    });
});

$("#voterForm").submit((e) => {
    e.preventDefault();
    let data = $(e.currentTarget).serializeArray();
    let login = postAjax("VoterLogin", data);

    login.done((res) => {
        if (res.status == "success") {
            location.reload();
        }

        if (res.status == "election closed") {
            window.location.href = "/electionClosed";
        }

        if (res.status == "not authenticated") {
            bootbox.prompt({
                title: '<b>NOVADECI STAFF AUTHENTICATION</b>',
                size: "small",
                inputType: 'password',
                placeholder: "ENTER PASSWORD",
                required: true,
                buttons: {
                    confirm: {
                        label: 'Authenticate',
                        className: 'btn-success btn-sm'
                    },
                    cancel: {
                        label: 'Cancel',
                        className: 'btn-danger btn-sm'
                    }
                },
                callback: function (password) {
                    if (password) {
                        $.LoadingOverlay("show");
                        $.ajax({
                            type: "POST",
                            url: "ElectionAuthentication",
                            data: { password: password },
                            success: (response) => {
                                $.LoadingOverlay("hide");
                                if (response.status == "success") {
                                    $.LoadingOverlay("show");
                                    data.push({
                                        name:"authenticated",
                                        value: true
                                    });
                                    $.ajax({
                                        type: "POST",
                                        url: "VoterLogin",
                                        data: data,
                                        success: (res) => {
                                            $.LoadingOverlay("hide");
                                            if(res.status == "success"){
                                                location.reload();
                                            }else{
                                                $(".error-text").text(res.message).removeClass("d-none");
                                                setTimeout(() => {
                                                    $(".error-text").addClass("d-none");
                                                },5000);
                                            }
                                        }
                                    })
                                } else {
                                    bootbox.alert({
                                        title: '<b>AUTHENTICATION ERROR</b>',
                                        message: "<p class='text-center font-weight-bold text-monospace text-danger m-0 p-0'>" + response.message + "</p>",
                                        size: "small",
                                        buttons: {
                                            ok: {
                                                label: 'OK',
                                                className: 'btn-primary btn-sm'
                                            }
                                        }
                                    });
                                }
                            }
                        });
                    }

                }
            });
        }

        if(res.status == "failed"){
            $(".error-text").text(res.message).removeClass("d-none");
            setTimeout(() => {
                $(".error-text").addClass("d-none");
            },5000);
        }
    });
});
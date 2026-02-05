$(document).ready(() => {
    // $("#voterForm")
    //     .find("input[name='Birthdate']")
    //     .datepicker({
    //         changeMonth: true,
    //         changeYear: true,
    //         minDate: new Date(1920, 0, 1),
    //         yearRange: "1920:+0",
    //     });

    let countdown;

    function formatTime(seconds) {
        const minutes = Math.floor(seconds / 60);
        const secs = seconds % 60;
        return minutes + ":" + (secs < 10 ? "0" : "") + secs;
    }

    function startTimer() {
        clearInterval(countdown);
        timeLeft = 300;
        $("#voterTimer").text(formatTime(timeLeft));

        countdown = setInterval(function () {
            timeLeft--;
            $("#voterTimer").text(formatTime(timeLeft));

            if (timeLeft <= 0) {
                clearInterval(countdown);
                $("#voterTimer").parent().addClass("d-none");
                $("#resendOtpBtn").removeClass("d-none");
            }
        }, 1000);
    }

    startTimer();

    $("#resendOtpBtn").click(() => {
        $.ajax({
            type: "POST",
            url: "ResendOtp",
            data: {
                voterId: $("#voterForm").find("input[name='VoterId']").val(),
            },
            success: (res) => {
                if (res.status == "success") {
                    $("#voterTimer").parent().removeClass("d-none");
                    $("#resendOtpBtn").addClass("d-none");
                    startTimer();
                } else {
                    Swal.fire({
                        title: "Resend OTP Failed",
                        text: res.message,
                        icon: "warning",
                        confirmButtonText: "OK",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                    });
                }
            },
        });
    });

    $("#voterForm").find("input[name='otp1']").focus();

    function updateHiddenOtp() {
        let otp = "";
        $("#voterForm")
            .find(".otp")
            .each(function () {
                otp += $(this).val();
            });
        $("#voterForm").find("#otp").val(otp);

        if (otp.length === 6) {
            $("#voterForm").submit();
        }
    }

    $("#voterForm")
        .find(".otp")
        .on("input", function () {
            const $this = $(this);
            $this.val($this.val().replace(/[^0-9]/g, ""));

            if ($this.val() !== "") {
                $this.next(".otp").focus();
            }

            updateHiddenOtp();
        });

    $("#voterForm")
        .find(".otp")
        .on("keydown", function (e) {
            if (e.key === "Backspace" && $(this).val() === "") {
                $(this).prev(".otp").focus();
            }
        });
});

$("#backToVerifierBtn").click(() => {
    window.location.href = "/";
});

$("#verifierForm").submit((e) => {
    e.preventDefault();
    let data = $(e.currentTarget).serializeArray();
    let verifymember = postAjax("Verifymember", data);

    verifymember.done((res) => {
        if (res.settingStatus.verifier == "CLOSED") {
            location.reload();
        }

        !$(".norecord-verifier").hasClass("d-none")
            ? $(".norecord-verifier").addClass("d-none")
            : "";
        $(".search-container-verifier").empty();
        if (res.status == "success") {
            res.data.forEach((data) => {
                let migs = {
                    status: "M I G S!",
                    color: "green",
                    canVote: true,
                };
                let membercard = $(".memcard-verifier").clone();

                membercard
                    .removeClass("memcard-verifier")
                    .removeClass("d-none");
                membercard.find(".memberName").text(data.name);
                membercard
                    .find(".pbno")
                    .text(data.pbno)
                    .css("color", data.pbno == "No Data" ? "gray" : "green");
                membercard
                    .find(".memberID")
                    .text(data.memid)
                    .css("color", data.memid == "No Data" ? "gray" : "green");

                if (data.status != "MIGS") {
                    migs.status = "N O N - M I G S!";
                    migs.color = "red";
                    migs.canVote = false;
                }

                membercard
                    .find(".status")
                    .text(migs.status)
                    .css("color", migs.color);

                if (migs.canVote) {
                    membercard
                        .find(".voteBtn")
                        .removeClass("d-none")
                        .css("color", "purple");
                } else {
                    membercard
                        .find(".nonMigs")
                        .parent()
                        .removeClass("d-none")
                        .addClass("d-flex")
                        .children()
                        .first()
                        .css("color", "purple")
                        .next()
                        .css("color", "blue");
                }

                if (res.settingStatus.election == "CLOSED") {
                    membercard.find(".voteBtn").remove();
                }

                membercard.find(".nonMigs").click((e) => {
                    $("#nonMigsForm")
                        .find(".nonmigs-membername")
                        .text(data.name);
                    $("#nonMigsForm").find("input[name='Id']").val(data.id);
                    $("#nonMigsModal").modal("show");
                });

                membercard.find(".voteBtn").click((e) => {
                    $.ajax({
                        type: "POST",
                        url: "SetVoterId",
                        data: { id: data.id },
                        success: (res) => {
                            if (res.status == "success") {
                                window.location.href = "/voter";
                            } else {
                                Swal.fire({
                                    title: "No Email Found",
                                    text: "There is no email registered on your account. Please contact NOVADECI support for assistance.",
                                    icon: "warning",
                                    confirmButtonText: "OK",
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                });
                            }
                        },
                    });
                });

                $(".search-container-verifier").append(membercard);
            });
        } else {
            $(".norecord-verifier").removeClass("d-none");
        }
    });
});

$("#nonMigsModal").on("shown.bs.modal", function (e) {
    $("#nonMigsForm").trigger("reset");
    $("#nonmigs-contact").focus();
});

$("#nonmigs-contact").on("input", function (e) {
    $(this).val(
        $(this)
            .val()
            .replace(/[^0-9]/g, ""),
    );
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
                allowEscapeKey: false,
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
                allowEscapeKey: false,
            });
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

        if (res.status == "failed") {
            $(".error-text").text(res.message).removeClass("d-none");
            setTimeout(() => {
                $(".error-text").addClass("d-none");
            }, 5000);
        }
    });
});

$("#voterForm")
    .find("#Birthdate")
    .keyup((e) => {
        let input = e.target.value;
        input = input.replace(/\D/g, "");
        if (input.length >= 2) input = input.slice(0, 2) + "/" + input.slice(2);
        if (input.length >= 5)
            input = input.slice(0, 5) + "/" + input.slice(5, 9);
        e.target.value = input;
    });

$(".tabLink").click((e) => {
    e.preventDefault();
    for (let key in intervalId) {
        clearInterval(intervalId[key]);
    }
    $(".tabLink").removeClass("active font-weight-bold");
    $(e.currentTarget).addClass("active font-weight-bold");

    let tabTitle = $(e.currentTarget).parent().find("p").text();
    $(".tabTitle").text(tabTitle.toUpperCase());

    let url = $(e.currentTarget).attr("href");
    $.LoadingOverlay("show");
    $(".content").load(url, (res, status, xhr) => {
        if (status == "success") {
            switch (tabTitle) {
                case "Maintenance":
                    MaintenanceTab();
                    break;

                case "User Account":
                    UseraccountTab();
                    break;

                case "Utility Dashboard":
                    UtilityDashboard();
                    break;

                case "Member Information":
                    MemberInfoTab();
                    break;

                case "Member Status":
                    MemberStatusTab();
                    break;

                case "Utility Verification":
                    UtilityVerification();
                    break;

                case "Election Dashboard":
                    ElectionDashboard();
                    break;

                case "Election Positions":
                    ElectionPositions();
                    break;

                case "Election Candidates":
                    ELectionCandidates();
                    break;

                case "Election Voting":
                    MemberVoting();
                    break;

                case "Tickets Printing":
                    ElectionTickets();
                break;

                case "Election Summary":
                    ElectionSummary();
                break;
                
                case "GA Items":
                    Supplies();
                break;

                case "F2F Election":
                    F2fElection();
                break;
            }
            $.LoadingOverlay("hide");
        }
    });
});
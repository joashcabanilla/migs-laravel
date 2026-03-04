$(document).ready(() => {
    for (let key in intervalId) {
        clearInterval(intervalId[key]);
    }

    intervalId.dashboard = setInterval(() => {
        $.ajax({
            type: "POST",
            url: "ElectionLiveData",
            success: (res) => {
                let voteTally = res.voteTally;
                let positions = res.positions;

                Object.entries(positions).forEach(([positionId, position]) => {
                    let tableBody = $(".card" + position.code).find("tbody");
                    voteTally[positionId].forEach((candidate, key) => {
                        tableBody
                            .find(".candidateCodeName" + key)
                            .text(candidate.codeName);

                        let percentageElement = tableBody.find(
                            ".candidatePercentage" + key,
                        );
                        if (parseFloat(candidate.percentage) > 0) {
                            percentageElement
                                .text(candidate.percentage + "%")
                                .removeClass(
                                    "position-absolute w-100 text-center text-dark",
                                )
                                .parent()
                                .attr("aria-valuenow", candidate.percentage)
                                .css("width", candidate.percentage + "%")
                                .parent()
                                .removeClass("position-relative");
                        } else {
                            percentageElement
                                .text("0%")
                                .addClass(
                                    "position-absolute w-100 text-center text-dark",
                                )
                                .parent()
                                .attr("aria-valuenow", 0)
                                .css("width", "0%")
                                .parent()
                                .addClass("position-relative");
                        }
                    });
                });
            },
        });
    }, 3000);

    intervalId.dashboard1 = setInterval(() => {
        location.reload();
    }, 600000);
});

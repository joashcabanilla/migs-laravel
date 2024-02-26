const MaintenanceTab = () => {
    let csvData = [];

    const insertData = (counter, total, status) => {
        let batchInsert = parseInt($("#batchInsert").val());
        let table = $("#databaseTable").val();
        let totalkeys = Object.keys(csvData[0]).length;

        let alert = {
            title: "Done Processing",
            icon: "success",
            error: {}
        };
        if (counter <= total && status == "success") {
            setTimeout(() => {
                let batchData = [];
                let batchCtr = counter;
                for (let ctr = 0; ctr < batchInsert; ctr++) {
                    if (csvData[batchCtr] != undefined && Object.keys(csvData[batchCtr]).length == totalkeys) {
                        batchData.push(csvData[batchCtr]);
                        batchCtr++;
                    }
                }

                let data = {
                    table: table,
                    insert: batchData
                };
                $.ajax({
                    type: "POST",
                    url: "admin/BatchInsertData",
                    data: data,
                    async: false,
                    success: (res) => {
                        if (res.status == "failed") {
                            alert.title = "Error Occurred";
                            alert.icon = "error";
                            alert.error = res.error;
                        }
                        let percent = parseInt((counter / total) * 100);
                        $(".container-progress").find("h4").text(counter + " / " + total);
                        $(".container-progress").find(".progress-bar").text(percent + "%").css("width", percent + "%");
                        insertData(counter + batchInsert, total, res.status);
                    }
                });
            }, 300);

        } else {
            if (alert.icon == "error") {
                console.log(alert);
            }
            $(".container-progress").find(".progress-bar").text("100%").css("width", "100%");
            Swal.fire({
                title: alert.title,
                icon: alert.icon,
                confirmButtonText: "OK",
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then((result) => {
                $("#databaseTable").attr("disabled", false);
                $("#batchInsert").attr("disabled", false);
                $("#tableFile").attr("disabled", false);
                $("#importDatabaseForm").find("button").attr("disabled", false).removeClass("btn-success").addClass("btn-primary").html("Submit");
                $("#tableFile").val("").next().text("Upload Excel File");
                $("#importDatabaseForm").find("button").addClass("d-none");
                $(".container-progress").addClass("d-none");
                $("#databaseTable").val("");
                $("#batchInsert").val("");
            });
        }
    }

    $("#tableFile").change((e) => {
        let file = e.target.files[0];
        if (file) {
            $(e.currentTarget).next().text(file.name);
            Papa.parse(file, {
                header: true,
                complete: function (results) {
                    csvData = results.data;
                    $("#importDatabaseForm").find("button").removeClass("d-none");
                    $(".container-progress").removeClass("d-none");
                    $(".container-progress").find("h4").text("0 / " + csvData.length);
                    $(".container-progress").find(".progress-bar").text("0%").css("width", "0%");
                }
            });
        } else {
            $(e.currentTarget).next().text("Upload Excel File");
            if (!$("#importDatabaseForm").find("button").hasClass("d-none")) {
                $("#importDatabaseForm").find("button").addClass("d-none");
            }
        }
    });

    $("#importDatabaseForm").submit((e) => {
        e.preventDefault();
        $("#databaseTable").attr("disabled", true);
        $("#batchInsert").attr("disabled", true);
        $("#tableFile").attr("disabled", true);
        $("#importDatabaseForm").find("button").attr("disabled", true).removeClass("btn-primary").addClass("btn-success").html("<i class='fa fa-spinner fa-spin text-warning'></i> Inserting Data...");
        insertData(0, csvData.length, "success");
    });
}

const UseraccountTab = () => {
    let userTable = $('#userTable').on('init.dt', function () {
        $(".dataTables_wrapper").prepend("<div class='dataTables_processing card font-weight-bold d-none' role='status'>Loading Please Wait...<i class='fa fa-spinner fa-spin text-warning'></i></div>");
    }).DataTable({
        ordering: false,
        serverSide: true,
        dom: 'rtip',
        columnDefs: [
            { targets: 0, width: '1%', className: "text-center font-weight-bold p-2" },
            { targets: 1, width: '10%', className: "text-left font-weight-bold p-2" },
            { targets: 2, width: '20%', className: "text-left font-weight-bold p-2" },
            { targets: 3, width: '20%', className: "text-center font-weight-bold p-2" },
            { targets: 4, width: '20%', className: "text-left font-weight-bold p-2" },
            { targets: 5, width: '20%', className: "text-left font-weight-bold p-2" },
            { targets: 6, width: '9%', className: "text-center font-weight-bold p-2" },
        ],
        ajax: {
            url: 'admin/UserDataTable',
            type: 'POST',
            data: function (d) {
                d.filterSearch = $("#userSearch").val();
                d.filterUserType = $("#userTypeFilter").val();
                d.filterBranch = $("#branchFilter").val();
            },
            beforeSend: () => {
                $(".dataTables_processing").removeClass("d-none");
            },
            complete: () => {
                $(".dataTables_processing").addClass("d-none");
            }
        }
    });

    $("#clearFilter").click((e) => {
        $("#userSearch").val("");
        $("#userTypeFilter").val("");
        $("#branchFilter").val("");
        userTable.draw();
    });

    $("#userSearch").keyup((e) => {
        userTable.draw();
    });

    $("#userTypeFilter,#branchFilter").change((e) => {
        userTable.draw();
    });

    $("#userAddBtn").click((e) => {
        $("#userModal").modal("show");
    });

    $("#showPassword").change((e) => {
        if ($(e.currentTarget).is(":checked")) {
            $("#addPassword").attr("type", "text");
        } else {
            $("#addPassword").attr("type", "password");
        }
    });

    $("#defaultPassword").change((e) => {
        if ($(e.currentTarget).is(":checked")) {
            $("#addPassword").attr("disabled", true);
            $("#addPassword").val("");
            $("#addPassword").attr("required", false);
        } else {
            $("#addPassword").attr("disabled", false);
            $("#addPassword").attr("required", true);
        }
    });

    $('#userModal').on('hidden.bs.modal', function (e) {
        $("#userModalLabel").text("Create New User");
        $("#userForm").find("input").val("").trigger("change").removeClass("is-invalid");
        $("#userForm").find("select").val("");
        $("#userForm").find("input[type='checkbox']").prop("checked", false);
        $("#addPassword").attr("disabled", false);
        $("#addPassword").attr("required", true);
        $("#addPassword").attr("type", "password");
    });

    $("#addFirstName,#addLastName,#addUsername,#addPassword").keyup((e) => {
        $(e.currentTarget).removeClass("is-invalid");
    });

    $("#userForm").submit((e) => {
        e.preventDefault();
        $.LoadingOverlay("show");
        $.ajax({
            type: "POST",
            url: "admin/CreateUpdateUser",
            data: $(e.currentTarget).serializeArray(),
            success: (res) => {
                $.LoadingOverlay("hide");
                if (res.status == "failed") {
                    let errorKey = Object.keys(res.error);
                    errorKey.forEach((key) => {
                        $("#userForm").find("input[name='" + key + "']").addClass("is-invalid").next().text(res.error[key][0]);
                    });
                }
                else {
                    $('#userModal').modal("hide");
                    Swal.fire({
                        title: "Successfully Saved.",
                        icon: res.status,
                        confirmButtonText: "OK",
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then((result) => {
                        userTable.ajax.reload(null, false);
                    });
                }
            }
        });
    });

    $('#userTable').on('click', '.editBtn', (e) => {
        let id = $(e.currentTarget).data("id");
        $("#addPassword").attr("required", false);
        $("#userModalLabel").text("Update User Data");
        $("#userForm").find("input[name='id']").val(id);
        $.LoadingOverlay("show");
        $.ajax({
            type: "POST",
            url: "admin/GetUser",
            data: { id: id },
            success: (res) => {
                $.LoadingOverlay("hide");
                $("#addUserType").val(res.UserType);
                $("#addFirstName").val(res.FirstName);
                $("#addMiddleName").val(res.MiddleName);
                $("#addLastName").val(res.LastName);
                $("#addBranch").val(res.Branch);
                $("#addUsername").val(res.username);
            }
        });
        $('#userModal').modal('show');
    });
}

const UtilityDashboard = () => {
    const clickUrl = (tabTitle) => {
        $(".nav-sidebar").find("p").each((key, element) => {
            if ($(element).text() == tabTitle) {
                $(element).parent().trigger("click");
            }
        });
    };

    $("#dashboardUrl").click((e) => {
        e.preventDefault();
        clickUrl("Utility Dashboard");
    });

    $("#memberInfoUrl").click((e) => {
        e.preventDefault();
        clickUrl("Member Information");
    });

    $("#memberStatusUrl").click((e) => {
        e.preventDefault();
        clickUrl("Member Status");
    });

    $("#verificationUrl").click((e) => {
        e.preventDefault();
        clickUrl("Utility Verification");
    });

    $("#verifiedUrl").click((e) => {
        e.preventDefault();
        clickUrl("Utility Verification");
    });

    intervalId.UtilityDashboard = setInterval(() => {
        $.ajax({
            type: "POST",
            url: "admin/GetUtilityDashboardData",
            success: (res) => {
                $(".totalMembers").text(res.totalMembers);
                $(".totalBirthdate").text(res.updatedBirthdate);
                $(".totalStatus").text(res.updateStatus);
                $(".totalVerification").text(res.forVerification);
                $(".totalVerified").text(res.verifiedStatus);
            }
        });
    }, 3000);
}

const MemberInfoTab = () => {
    let memberTable = $('#memberTable').on('init.dt', function () {
        $(".dataTables_wrapper").prepend("<div class='dataTables_processing card font-weight-bold d-none' role='status'>Loading Please Wait...<i class='fa fa-spinner fa-spin text-warning'></i></div>");
    }).DataTable({
        ordering: false,
        serverSide: true,
        dom: 'rtip',
        columnDefs: [
            { targets: 0, width: '1%', className: "text-center font-weight-bold p-2" },
            { targets: 1, width: '10%', className: "text-center font-weight-bold p-2" },
            { targets: 2, width: '10%', className: "text-center font-weight-bold p-2" },
            { targets: 3, width: '30%', className: "text-left font-weight-bold p-2" },
            { targets: 4, width: '15%', className: "text-center font-weight-bold p-2" },
            { targets: 5, width: '15%', className: "text-center font-weight-bold p-2" },
            { targets: 6, width: '10%', className: "text-center font-weight-bold p-2" },
            { targets: 7, width: '9%', className: "text-center font-weight-bold p-2" },
        ],
        ajax: {
            url: 'admin/MemberDataTable',
            type: 'POST',
            data: function (d) {
                d.filterSearch = $("#filterSearch").val();
                d.filterStatus = $("#filterStatus").val();
                d.filterBranch = $("#filterBranch").val();
            },
            beforeSend: () => {
                $(".dataTables_processing").removeClass("d-none");
            },
            complete: () => {
                $(".dataTables_processing").addClass("d-none");
            }
        }
    });

    $("#clearFilter").click((e) => {
        $("#filterSearch").val("");
        $("#filterBranch").val("");
        $("#filterStatus").val("");
        memberTable.draw();
    });

    $("#filterSearch").keyup((e) => {
        memberTable.draw();
    });

    $("#filterBranch,#filterStatus").change((e) => {
        memberTable.draw();
    });

    $("#memberAddBtn").click((e) => {
        $("#addMemberModal").modal("show");
    });

    $('#addMemberModal').on('hidden.bs.modal', function (e) {
        $("#addMemberForm").find("input").val("");
        $("#addMemberForm").find("select").val("");
    });

    $("#addMemberForm").submit((e) => {
        e.preventDefault();
        $.LoadingOverlay("show");
        $.ajax({
            type: "POST",
            url: "admin/AddMember",
            data: $(e.currentTarget).serializeArray(),
            success: (res) => {
                $.LoadingOverlay("hide");
                $('#addMemberModal').modal("hide");
                Swal.fire({
                    title: "Successfully Saved.",
                    icon: res.status,
                    confirmButtonText: "OK",
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then((result) => {
                    memberTable.ajax.reload(null, false);
                });
            }
        });
    });

    $('#memberTable').on('click', '.editBtn', (e) => {
        $('#updateMemberModal').modal("show");
        let id = $(e.currentTarget).data("id");
        $.LoadingOverlay("show");
        $.ajax({
            type: "POST",
            url: "admin/GetMember",
            data: { id: id },
            success: (res) => {
                $.LoadingOverlay("hide");
                for (let key in res) {
                    $("#updateMemberForm").find("input[name='" + key + "']").val(res[key]);
                }
            }
        });
    });

    $("#updateMemberForm").submit((e) => {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "admin/UpdateMember",
            data: $(e.currentTarget).serializeArray(),
            success: (res) => {
                $.LoadingOverlay("hide");
                $('#updateMemberModal').modal("hide");
                Swal.fire({
                    title: "Successfully Saved.",
                    icon: res.status,
                    confirmButtonText: "OK",
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then((result) => {
                    memberTable.ajax.reload(null, false);
                });
            }
        });
    });
}

const MemberStatusTab = () => {
    let memberTable = $('#memberTable').on('init.dt', function () {
        $(".dataTables_wrapper").prepend("<div class='dataTables_processing card font-weight-bold d-none' role='status'>Loading Please Wait...<i class='fa fa-spinner fa-spin text-warning'></i></div>");
    }).DataTable({
        ordering: false,
        serverSide: true,
        dom: 'rtip',
        columnDefs: [
            { targets: 0, width: '1%', className: "text-center font-weight-bold p-2" },
            { targets: 1, width: '10%', className: "text-center font-weight-bold p-2" },
            { targets: 2, width: '10%', className: "text-center font-weight-bold p-2" },
            { targets: 3, width: '35%', className: "text-left font-weight-bold p-2" },
            { targets: 4, width: '20%', className: "text-center font-weight-bold p-2" },
            { targets: 5, width: '15%', className: "text-center font-weight-bold p-2" },
            { targets: 6, width: '9%', className: "text-center font-weight-bold p-2" },
        ],
        ajax: {
            url: 'admin/MemberStatusDataTable',
            type: 'POST',
            data: function (d) {
                d.filterSearch = $("#filterSearch").val();
                d.filterStatus = $("#filterStatus").val();
                d.filterBranch = $("#filterBranch").val();
            },
            beforeSend: () => {
                $(".dataTables_processing").removeClass("d-none");
            },
            complete: () => {
                $(".dataTables_processing").addClass("d-none");
            }
        }
    });

    $("#clearFilter").click((e) => {
        $("#filterSearch").val("");
        $("#filterBranch").val("");
        $("#filterStatus").val("");
        memberTable.draw();
    });

    $("#filterSearch").keyup((e) => {
        memberTable.draw();
    });

    $("#filterBranch,#filterStatus").change((e) => {
        memberTable.draw();
    });

    $('#memberTable').on('click', '.editBtn', (e) => {
        $('#memberStatusModal').modal("show");
        let id = $(e.currentTarget).data("id");
        $.LoadingOverlay("show");
        $.ajax({
            type: "POST",
            url: "admin/GetMember",
            data: { id: id },
            success: (res) => {
                $.LoadingOverlay("hide");
                for (let key in res) {
                    $("#memberStatusForm").find("input[name='" + key + "']").val(res[key]);
                    $("#memberStatusForm").find("select[name='" + key + "']").val(res[key]);
                }
            }
        });
    });

    $("#memberStatusForm").submit((e) => {
        e.preventDefault();
        $.LoadingOverlay("show");
        $.ajax({
            type: "POST",
            url: "admin/UpdateMemberStatus",
            data: $(e.currentTarget).serializeArray(),
            success: (res) => {
                $.LoadingOverlay("hide");
                if (res.status == "success") {
                    $('#memberStatusModal').modal("hide");
                    Swal.fire({
                        title: "Successfully Saved.",
                        icon: res.status,
                        confirmButtonText: "OK",
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then((result) => {
                        memberTable.ajax.reload(null, false);
                    });
                } else {
                    Swal.fire({
                        title: "NOT VERIFIED",
                        text: res.message,
                        icon: "error",
                        confirmButtonText: "OK",
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    });
                }
            }
        });
    });
}

const UtilityVerification = () => {
    let memberTable = $('#memberTable').on('init.dt', function () {
        $(".dataTables_wrapper").prepend("<div class='dataTables_processing card font-weight-bold d-none' role='status'>Loading Please Wait...<i class='fa fa-spinner fa-spin text-warning'></i></div>");
    }).DataTable({
        ordering: false,
        serverSide: true,
        dom: 'rtip',
        columnDefs: [
            { targets: 0, width: '1%', className: "text-center font-weight-bold p-2" },
            { targets: 1, width: '10%', className: "text-center font-weight-bold p-2" },
            { targets: 2, width: '10%', className: "text-center font-weight-bold p-2" },
            { targets: 3, width: '20%', className: "text-left font-weight-bold p-2" },
            { targets: 4, width: '10%', className: "text-center font-weight-bold p-2" },
            { targets: 5, width: '10%', className: "text-center font-weight-bold p-2" },
            { targets: 6, width: '10%', className: "text-center font-weight-bold p-2" },
            { targets: 7, width: '15%', className: "text-center font-weight-bold p-2" },
            { targets: 8, width: '10%', className: "text-center font-weight-bold p-2" },
            { targets: 9, width: '5%', className: "text-center font-weight-bold p-2" },
        ],
        ajax: {
            url: 'admin/VerificationDataTable',
            type: 'POST',
            data: function (d) {
                d.filterSearch = $("#filterSearch").val();
                d.filterStatus = $("#filterStatus").val();
                d.filterBranch = $("#filterBranch").val();
            },
            beforeSend: () => {
                $(".dataTables_processing").removeClass("d-none");
            },
            complete: () => {
                $(".dataTables_processing").addClass("d-none");
            }
        }
    });

    $("#clearFilter").click((e) => {
        $("#filterSearch").val("");
        $("#filterBranch").val("");
        $("#filterStatus").val("");
        memberTable.draw();
    });

    $("#filterSearch").keyup((e) => {
        memberTable.draw();
    });

    $("#filterBranch,#filterStatus").change((e) => {
        memberTable.draw();
    });

    $("#memberAddBtn").click((e) => {
        $("#addModal").modal("show");
        setTimeout(() => {
            $("#findVoterId").trigger("focus");
        }, 300);
    });

    $("#findVoterId").keyup((e) => {
        $("#findVoterId").removeClass("is-invalid");
    });

    $("#findForm").submit((e) => {
        e.preventDefault();
        $.LoadingOverlay("show");
        $.ajax({
            type: "POST",
            url: "admin/GetMember",
            data: { id: $("#findVoterId").val() },
            success: (res) => {
                $.LoadingOverlay("hide");

                if (res != "") {
                    $("#findForm").find("input").val("");
                    $("#VoterId").val(res.Id);
                    $("#Pbno").val(res.Pbno);
                    $("#MemberId").val(res.MemberId);
                    $("#Name").val(`${res.FirstName} ${res.MiddleName} ${res.LastName}`);
                } else {
                    $("#findVoterId").addClass("is-invalid").next().text("Member Not Found.");
                    $("#addForm").find("input").val("");
                }
            }
        });
    });

    $('#addModal').on('hidden.bs.modal', function (e) {
        $("#findForm").find("input").val("").removeClass("is-invalid");
        $("#addForm").find("input").val("");
    });

    $("#addForm").submit((e) => {
        e.preventDefault();
        $.LoadingOverlay("show");
        let data = $(e.currentTarget).serializeArray();
        $.ajax({
            type: "POST",
            url: "admin/AddMemberVerification",
            data: data,
            success: (res) => {
                $.LoadingOverlay("hide");
                if (res.status == "success") {
                    $('#addModal').modal("hide");
                    Swal.fire({
                        title: "REQUEST FOR MIGS STATUS VERIFICATION",
                        text: res.message,
                        icon: "success",
                        confirmButtonText: "OK",
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then((result) => {
                        memberTable.ajax.reload(null, false);
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
            }
        });
    });

    $('#memberTable').on('click', '.editBtn', (e) => {
        let id = $(e.currentTarget).data("id");
        let pbno = $(e.currentTarget).data("pbno");
        let memberid = $(e.currentTarget).data("memberid");
        let name = $(e.currentTarget).data("name");
        let status = $(e.currentTarget).data("status");

        $("#updateForm").find("input[name='Id']").val(id);
        $("#updateForm").find("input[name='Pbno']").val(pbno);
        $("#updateForm").find("input[name='MemberId']").val(memberid);
        $("#updateForm").find("input[name='Name']").val(name);
        $("#updateForm").find("select[name='Status']").val(status);
        $("#updateModal").modal("show");
    });

    $("#updateForm").submit((e) => {
        e.preventDefault();
        $('#updateModal').modal("hide");
        $.ajax({
            type: "POST",
            url: "admin/UpdateMemberVerification",
            data: $(e.currentTarget).serializeArray(),
            success: (res) => {
                $.LoadingOverlay("hide");
                Swal.fire({
                    title: "Successfully Saved.",
                    icon: "success",
                    confirmButtonText: "OK",
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then((result) => {
                    memberTable.ajax.reload(null, false);
                });
            }
        });
    });
}

const ElectionPositions = () => {
    let dataTable = $('#dataTable').on('init.dt', function () {
        $(".dataTables_wrapper").prepend("<div class='dataTables_processing card font-weight-bold d-none' role='status'>Loading Please Wait...<i class='fa fa-spinner fa-spin text-warning'></i></div>");
    }).DataTable({
        ordering: false,
        serverSide: true,
        dom: 'rtip',
        columnDefs: [
            { targets: 0, width: '1%', className: "text-center font-weight-bold p-2" },
            { targets: 1, width: '30%', className: "text-center font-weight-bold p-2" },
            { targets: 2, width: '30%', className: "text-left font-weight-bold p-2" },
            { targets: 3, width: '30%', className: "text-center font-weight-bold p-2" },
            { targets: 4, width: '9%', className: "text-center font-weight-bold p-2" },
        ],
        ajax: {
            url: 'admin/ElectionPositionDataTable',
            type: 'POST',
            data: function (d) {
                d.filterSearch = $("#filterSearch").val();
            },
            beforeSend: () => {
                $(".dataTables_processing").removeClass("d-none");
            },
            complete: () => {
                $(".dataTables_processing").addClass("d-none");
            }
        }
    });

    $("#filterSearch").keyup((e) => {
        dataTable.draw();
    });

    $("#addBtn").click((e) => {
        $("#addModal").modal("show");
        setTimeout(() => {
            $("#PositionLevel").trigger("focus");
        }, 300);
    });

    $('#addModal').on('hidden.bs.modal', function (e) {
        $("#addModalLabel").text("Add Position");
        $("#addForm").find("input").val("");
        $("#PositionLevel").attr("disabled", false);
    });

    $("#addForm").submit((e) => {
        e.preventDefault();
        $.LoadingOverlay("show");
        $.ajax({
            type: "POST",
            url: "admin/AddUpdateElectionPosition",
            data: $(e.currentTarget).serializeArray(),
            success: (res) => {
                $.LoadingOverlay("hide");
                if (res.status == "success") {
                    $("#addModal").modal("hide");
                    Swal.fire({
                        title: "Successfully Saved.",
                        icon: "success",
                        confirmButtonText: "OK",
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then((result) => {
                        dataTable.ajax.reload(null, false);
                    });
                } else {
                    Swal.fire({
                        title: "The position level has already been used.",
                        icon: "error",
                        confirmButtonText: "OK",
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    });
                }
            }
        });
    });

    $('#dataTable').on('click', '.editBtn', (e) => {
        e.preventDefault();
        let id = $(e.currentTarget).data("id");
        $.LoadingOverlay("show");
        $.ajax({
            type: "POST",
            url: "admin/GetElectionPosition",
            data: { id: id },
            success: (res) => {
                $.LoadingOverlay("hide");
                for (let key in res) {
                    $("#" + key).val(res[key]);
                }
                $("#addModalLabel").text("Update Position");
                $("#PositionLevel").attr("disabled", true);
                $("#addForm").find("input[name='Id']").val(id);
                $("#addModal").modal("show");
                setTimeout(() => {
                    $("#VoteLimit").trigger("focus");
                }, 300);
            }
        });
    });
}

const ELectionCandidates = () => {
    let dataTable = $('#dataTable').on('init.dt', function () {
        $(".dataTables_wrapper").prepend("<div class='dataTables_processing card font-weight-bold d-none' role='status'>Loading Please Wait...<i class='fa fa-spinner fa-spin text-warning'></i></div>");
    }).DataTable({
        ordering: false,
        serverSide: true,
        dom: 'rtip',
        pageLength: 5,
        columnDefs: [
            { targets: 0, width: '1%', className: "text-center align-middle font-weight-bold p-2" },
            { targets: 1, width: '1%'},
            { targets: 2, width: '30%', className: "text-center align-middle font-weight-bold p-2" },
            { targets: 3, width: '30%', className: "text-center align-middle font-weight-bold p-2" },
            { targets: 4, width: '9%', className: "text-center align-middle font-weight-bold p-2" },
        ],
        ajax: {
            url: 'admin/ElectionCandidateDataTable',
            type: 'POST',
            data: function (d) {
                d.filterSearch = $("#filterSearch").val();
                d.filterPosition = $("#filterPosition").val();
            },
            beforeSend: () => {
                $(".dataTables_processing").removeClass("d-none");
            },
            complete: () => {
                $(".dataTables_processing").addClass("d-none");
            }
        }
    });

    $("#filterSearch").keyup((e) => {
        dataTable.draw();
    });

    $("#filterPosition").change((e) => {
        dataTable.draw();
    });

    $("#addBtn").click((e) => {
        $("#addModal").modal("show");
    });

    $('#addModal').on('hidden.bs.modal', function (e) {
        $("#addForm").find("input").val("");
        $("#addForm").find("select").val("");
        $("#CandidatePicture").attr("src", defaultPicture).removeClass("picture");
        $("#Picture").removeClass("is-invalid").next().text("Upload Picture");
        $(".candidatePictureInvalid").text("").css("display", "none");
        $("#Picture").attr("required", true);
    });

    $("#Picture").change((e) => {
        $(e.currentTarget).removeClass("is-invalid").next().text("Upload Picture");
        $(".candidatePictureInvalid").text("").css("display", "none");
        let file = e.currentTarget.files[0];
        let type = file.type.split("/");
        if (type[1] == "jpeg" || type[1] == "png" || type[1] == "jpg") {
            let reader = new FileReader();
            reader.onload = (data) => {
                $("#CandidatePicture").attr("src", data.target.result).addClass("picture");
                $(e.currentTarget).next().text(file.name);
            };
            reader.readAsDataURL(file);
        } else {
            $(e.currentTarget).val("");
            $("#CandidatePicture").attr("src", defaultPicture).removeClass("picture");
            $(e.currentTarget).next().text("Upload Picture");
            $(e.currentTarget).addClass("is-invalid");
            $(".candidatePictureInvalid").css("display", "block").text(`Invalid file type ${file.name}`);
        }
    });

    $("#addForm").submit((e) => {
        e.preventDefault();
        $.LoadingOverlay("show");
        let formData = new FormData(e.currentTarget);
        $.ajax({
            type: "POST",
            url: "admin/AddUpdateElectionCandidate",
            data: formData,
            processData: false,
            contentType: false,
            success: (res) => {
                $.LoadingOverlay("hide");
                $("#addModal").modal("hide");
                Swal.fire({
                    title: "Successfully Saved.",
                    icon: "success",
                    confirmButtonText: "OK",
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then((result) => {
                    dataTable.ajax.reload(null, false);
                });
            }
        });
    });

    $('#dataTable').on('click', '.editBtn', (e) => {
        e.preventDefault();
        let id = $(e.currentTarget).data("id");
        $("#Picture").attr("required", false);
        $.LoadingOverlay("show");
        $.ajax({
            type: "POST",
            url: "admin/GetElectionCandidate",
            data: { id: id },
            success: (res) => {
                $.LoadingOverlay("hide");
                $("#CandidatePicture").attr("src", res.Picture).addClass("picture");
                $("#FirstName").val(res.FirstName);
                $("#MiddleName").val(res.MiddleName);
                $("#LastName").val(res.LastName);
                $("#Position").val(res.Position);
                $("#addModalLabel").text("Update Candidate");
                $("#addForm").find("input[name='Id']").val(id);
                $("#addModal").modal("show");
            }
        });
    });
}
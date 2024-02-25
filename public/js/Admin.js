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
            { targets: 3, width: '35%', className: "text-left font-weight-bold p-2" },
            { targets: 4, width: '20%', className: "text-center font-weight-bold p-2" },
            { targets: 5, width: '15%', className: "text-center font-weight-bold p-2" },
            { targets: 6, width: '9%', className: "text-center font-weight-bold p-2" },
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
} 
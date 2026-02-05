<div class="modal fade" id="updateMemberModal" tabindex="-1" role="dialog" aria-labelledby="updateMemberModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="updateMemberModalLabel">Update Member</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="modal-closeIcon" aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="updateMemberForm" method="POST">
                <input type="hidden" name="Id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <label for="update-pbno">Pb No</label>
                            <div class="form-group">
                                <input type="text" class="form-control" id="update-pbno" name="Pbno" autocomplete="false" {{Auth::user()->UserType == 1 ?: "readonly"}}>
                            </div>
                        </div>

                        <div class="col-6">
                            <label for="update-memberId">MemberID</label>
                            <div class="form-group">
                                <input type="text" class="form-control" id="update-memberId" name="MemberId" autocomplete="false" {{Auth::user()->UserType == 1 ?: "readonly"}}>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="update-firstname">First Name</label>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="First Name *" id="update-firstname" name="FirstName" autocomplete="false" required>
                                <div class="invalid-feedback font-weight-bold"></div>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="update-middlename">Middle Name</label>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Middle Name" id="update-middlename" name="MiddleName" autocomplete="false">
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="update-lastname">Last Name</label>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Last Name *" id="update-lastname" name="LastName" autocomplete="false" required>
                                <div class="invalid-feedback font-weight-bold"></div>
                            </div>
                        </div>

                        <div class="col-6">
                            <label for="update-branch">Branch</label>
                            <div class="form-group">
                                <input type="text" class="form-control" id="update-branch" name="Branch" autocomplete="false" readonly>
                            </div>
                        </div>

                        <div class="col-6">
                            <label for="update-status">Status</label>
                            <div class="form-group">
                                <input type="text" class="form-control" id="update-status" name="Status" autocomplete="false" readonly>
                            </div>
                        </div>


                        <div class="col-6">
                            <label for="update-membershipdate">Membership Date</label>
                            <div class="form-group">
                                <input type="text" class="form-control" id="update-membershipdate" name="MembershipDate" autocomplete="false" readonly>
                            </div>
                        </div>

                        <div class="col-6">
                            <label for="update-birthdate">Birthdate</label>
                            <div class="form-group">
                                <input type="date" class="form-control" id="update-birthdate" name="Birthdate" autocomplete="false" required>
                                <div class="invalid-feedback font-weight-bold"></div>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="update-contact">Contact No</label>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="ex:09123456" id="update-contact" name="Contact" autocomplete="false" maxlength="11">
                                <div class="invalid-feedback font-weight-bold"></div>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="update-email">Email</label>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Email Address" id="update-email" name="Email" autocomplete="false">
                                <div class="invalid-feedback font-weight-bold"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary font-weight-bold">Submit</button>
                    <a type="button" class="btn btn-secondary font-weight-bold" data-dismiss="modal">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
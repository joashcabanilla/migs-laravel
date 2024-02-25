<div class="modal fade" id="memberStatusModal" tabindex="-1" role="dialog" aria-labelledby="memberStatusModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="memberStatusModalLabel">Update Member</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="modal-closeIcon" aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="memberStatusForm" method="POST">
                <input type="hidden" name="Id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <label for="update-pbno">Pb No</label>
                            <div class="form-group">
                                <input type="text" class="form-control" id="update-pbno" name="Pbno" autocomplete="false" readonly>
                            </div>
                        </div>

                        <div class="col-6">
                            <label for="update-memberId">MemberID</label>
                            <div class="form-group">
                                <input type="text" class="form-control" id="update-memberId" name="MemberId" autocomplete="false" readonly>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="update-firstname">First Name</label>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="First Name *" id="update-firstname" name="FirstName" autocomplete="false" readonly>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="update-middlename">Middle Name</label>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Middle Name" id="update-middlename" name="MiddleName" autocomplete="false" readonly>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="update-lastname">Last Name</label>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Last Name *" id="update-lastname" name="LastName" autocomplete="false" readonly>
                                <div class="invalid-feedback font-weight-bold"></div>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="update-branch">Branch</label>
                            <div class="form-group">
                                <input type="text" class="form-control" id="update-branch" name="Branch" autocomplete="false" readonly>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="update-status">Status</label>
                            <div class="form-group">
                                <select class="form-control" id="update-status" name="Status" required>
                                    <option value=""> -- Select Status -- </option>
                                    @if(!isset($verificationStatus))
                                        @foreach($status as $value)
                                            <option value="{{$value->Status}}">{{$value->Status == "MIGS" ?strtoupper($value->Status) : "NON-MIGS"}}</option>
                                        @endforeach
                                    @endif
                                </select>
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
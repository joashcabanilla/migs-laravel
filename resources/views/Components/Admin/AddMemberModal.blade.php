<div class="modal fade" id="addMemberModal" tabindex="-1" role="dialog" aria-labelledby="addMemberModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="addMemberModalLabel">Add Member</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="modal-closeIcon" aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addMemberForm" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <label for="pbno">Pb No</label>
                            <div class="form-group">
                                <input type="text" class="form-control" id="pbno" name="Pbno" autocomplete="false" placeholder="PbNo">
                            </div>
                        </div>

                        <div class="col-6">
                            <label for="memberId">MemberID</label>
                            <div class="form-group">
                                <input type="text" class="form-control" id="memberId" name="MemberId" autocomplete="false" placeholder="MemberID *" required>
                                <div class="invalid-feedback font-weight-bold"></div>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="firstname">First Name</label>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="First Name *" id="firstname" name="FirstName" autocomplete="false" required>
                                <div class="invalid-feedback font-weight-bold"></div>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="middlename">Middle Name</label>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Middle Name" id="middlename" name="MiddleName" autocomplete="false">
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="lastname">Last Name</label>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Last Name *" id="lastname" name="LastName" autocomplete="false" required>
                                <div class="invalid-feedback font-weight-bold"></div>
                            </div>
                        </div>

                        <div class="col-6">
                            <label for="branch">Branch</label>
                            <div class="form-group">
                                <select class="form-control" id="branch" name="Branch" required autocomplete="false">
                                    <option value=""> -- Select Branch -- </option>
                                    @foreach($branch as $value)
                                        <option value="{{$value->Branch}}">{{strtoupper($value->Branch)}}</option>
                                    @endforeach  
                                </select>
                            </div>
                        </div>

                        <div class="col-6">
                            <label for="status">Status</label>
                            <div class="form-group">
                                <select class="form-control" id="status" name="Status" required autocomplete="false">
                                    <option value=""> -- Select Status -- </option>
                                    @foreach($status as $value)
                                        <option value="{{$value->Status}}">{{$value->Status != "MIGS" ?"NON-MIGS" : strtoupper($value->Status)}}</option>
                                    @endforeach  
                                </select>
                            </div>
                        </div>


                        <div class="col-6">
                            <label for="membershipdate">Membership Date</label>
                            <div class="form-group">
                                <input type="date" class="form-control" id="membershipdate" name="MembershipDate" autocomplete="false" required>
                                <div class="invalid-feedback font-weight-bold"></div>
                            </div>
                        </div>

                        <div class="col-6">
                            <label for="birthdate">Birthdate</label>
                            <div class="form-group">
                                <input type="date" class="form-control" id="birthdate" name="Birthdate" autocomplete="false" required>
                                <div class="invalid-feedback font-weight-bold"></div>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="contact">Contact No</label>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="ex:09123456" id="contact" name="Contact" autocomplete="false" maxlength="11">
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
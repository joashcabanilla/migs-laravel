<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="userModalLabel">Create New User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="modal-closeIcon" aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="userForm" method="POST">
                <input type="hidden" name="id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <label for="addUserType">User Type</label>
                            <div class="form-group">
                                <select class="form-control" id="addUserType" name="userType" required autocomplete="false">
                                    <option value=""> -- Select User Type -- </option>
                                    @foreach($usertype as $value)
                                        @if($value->Id != 5)
                                            <option value="{{$value->Id}}">{{ucwords($value->UserType)}}</option>
                                        @endif
                                    @endforeach  
                                </select>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="addFirstName">First Name</label>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="First Name *" id="addFirstName" name="firstname" autocomplete="false" required>
                                <div class="invalid-feedback font-weight-bold"></div>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="addMiddleName">Middle Name</label>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Middle Name" id="addMiddleName" name="middlename" autocomplete="false">
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="addLastName">Last Name</label>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Last Name *" id="addLastName" name="lastname" autocomplete="false" required>
                                <div class="invalid-feedback font-weight-bold"></div>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="addBranch">Branch</label>
                            <div class="form-group">
                                <select class="form-control" id="addBranch" name="branch" required autocomplete="false">
                                    <option value=""> -- Select Branch -- </option>
                                    @foreach($branch as $value)
                                        <option value="{{$value->Branch}}">{{strtoupper($value->Branch)}}</option>
                                    @endforeach  
                                </select>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="addUsername">Username</label>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Username *" id="addUsername" name="username" autocomplete="false" required>
                                <div class="invalid-feedback font-weight-bold"></div>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="addPassword">Password</label>
                            <div class="form-group mb-0">
                                <input type="password" class="form-control" placeholder="Password *" id="addPassword" name="password" autocomplete="false" required>
                                <div class="invalid-feedback font-weight-bold"></div>
                            </div>
                            <div class="row p-0 mt-1">
                                <div class="col-6">
                                    <div class="icheck-success">
                                        <input type="checkbox" id="showPassword" name="showpassword">
                                        <label for="showPassword">Show password</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="icheck-success">
                                        <input type="checkbox" id="defaultPassword" name="defaultpassword" value="nvdc1976">
                                        <label for="defaultPassword">Default Password</label>
                                    </div>
                                </div>
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
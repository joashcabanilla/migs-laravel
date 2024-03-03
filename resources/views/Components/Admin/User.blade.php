<div class="container-fluid">
    <div class="card card-primary card-outline elevation-2 p-3">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12">
                <label for="userTypeFilter">User Type</label>
                <div class="form-group">
                    <select class="form-control" id="userTypeFilter" name="userType">
                        <option value=""> -- Select User Type -- </option>
                        @foreach($usertype as $value)
                            <option value="{{$value->Id}}">{{ucwords($value->UserType)}}</option>
                        @endforeach  
                    </select>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-12">
                <label for="branchFilter">Branch</label>
                <div class="form-group">
                    <select class="form-control" id="branchFilter" name="branch">
                        <option value=""> -- Select Branch -- </option>
                        @foreach($branch as $value)
                            <option value="{{$value->Branch}}">{{strtoupper($value->Branch)}}</option>
                        @endforeach  
                    </select>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-12">
                <label for="clearFilter"> &nbsp;</label>
                <div class="form-group">
                    <button class="btn btn-sm btn-primary font-weight-bold" id="clearFilter"><i class="fas fa-filter"></i> Clear Filter</button>
                </div> 
            </div>
        </div>
    </div>

    <div class="card card-primary card-outline elevation-2 p-3">
        <div class="row mt-1">
            <div class="col-lg-7 col-sm-12">
                <div class="form-group">
                    <div class="input-group input-group-lg">
                        <input type="text" class="form-control" id="userSearch"  placeholder="Search">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-lg btn-default" id="userSearchBtn">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-sm-12">
                <button type="submit" class="btn btn-lg btn-primary float-lg-right font-weight-bold" id="userAddBtn">
                    <i class="fa fa-plus" aria-hidden="true"></i> Add User
                </button>
            </div>
        </div>
        <div class="table-responsive">
            <table id="userTable" class="table table-hover table-bordered dataTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User Type</th>
                        <th>Name</th>
                        <th>Branch</th>
                        <th>Last Login</th>
                        <th>Ip Address</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@include('Components.Admin.UserModal')
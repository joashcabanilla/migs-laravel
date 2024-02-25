<div class="container-fluid">
    @include('Components.Admin.UtilityFilter')

    <div class="card card-primary card-outline elevation-2 p-3">
        <div class="row mt-1">
            <div class="col-lg-7 col-sm-12">
                <div class="form-group">
                    <div class="input-group input-group-lg">
                        <input type="text" class="form-control" id="filterSearch"  placeholder="Search">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-lg btn-default" id="userSearchBtn">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @if(Auth::user()->UserType == 1)
                <div class="col-lg-5 col-sm-12">
                    <button type="submit" class="btn btn-lg btn-primary float-lg-right font-weight-bold" id="memberAddBtn">
                        <i class="fa fa-plus" aria-hidden="true"></i> Add Member
                    </button>
                </div>
            @endif
        </div>
        <div class="table-responsive">
            <table id="memberTable" class="table table-hover table-bordered dataTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Pb No</th>
                        <th>Member ID</th>
                        <th>Name</th>
                        <th>Branch</th>
                        <th>Birthdate</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@include('Components.Admin.AddMemberModal')
@include('Components.Admin.UpdateMemberModal')

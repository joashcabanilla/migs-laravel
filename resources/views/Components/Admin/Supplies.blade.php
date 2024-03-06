<div class="container-fluid">
    @include('Components.Admin.UtilityFilter',["Supplies" => true])
    
    <div class="card card-primary card-outline elevation-2 p-3">
        <div class="row mt-1">
            <div class="col-lg-7 col-md-7 col-sm-12">
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
            <div class="col-lg-2 col-md-2 col-sm-12">
                <div class="form-group">
                    <button type="submit" class="btn btn-lg btn-primary font-weight-bold" id="printBtn">
                        <i class="fas fa-print"></i> Generate Report
                    </button>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12">
                <h5 class="font-weight-bold text-right mb-0">COUNTER: <b class="text-danger gaCounter">{{$counter}}</b></h5>
            </div>
        </div>
        <div class="table-responsive">
            <table id="dataTable" class="table table-hover table-bordered dataTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Pb No</th>
                        <th>Member ID</th>
                        <th>Name</th>
                        <th>Registered By</th>
                        <th>Date</th>
                        <th>Vote Method</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@include('Components.Admin.SuppliesModal')
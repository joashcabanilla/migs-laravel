@if($electionStatus == "OPEN") 
    <div class="container-fluid">
        @include('Components.Admin.UtilityFilter')

        <div class="card card-primary card-outline elevation-2 p-3">
            <div class="row mt-1">
                <div class="col-lg-6 col-sm-12">
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
                <div class="col-lg-4 col-md-4 col-sm-12">
                    @if(Auth::user()->UserType == 1)
                        <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-primary font-weight-bold" id="printBtn">
                                <i class="fas fa-print"></i> Generate Report
                            </button>
                        </div>
                    @endif
                </div>
                
                <div class="col-lg-2 col-md-2 col-sm-12">
                    <h5 class="font-weight-bold text-right mb-0">COUNTER: <b class="text-danger gaCounter">{{$counter}}</b></h5>
                </div>
            </div>
            <div class="table-responsive">
                <table id="memberTable" class="table table-hover table-bordered dataTable">
                    <thead>
                        <tr>
                            <th>Voter ID</th>
                            <th>Pb No</th>
                            <th>Member ID</th>
                            <th>Name</th>
                            <th>Branch</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@else
    <div class="container-fluid">
        <div class="card elevation-3">
            <div class="card-body">
                <h1 class="font-weight-bolder text-monospace text-center text-red">THE ELECTION IS TEMPORARILY CLOSED.</h1> 
            </div>
        </div>
    </div>
@endif

<form method="POST" id="f2fPrintForm" target="_blank" action="{{route("print.f2f")}}">
    @csrf    
</form>
<div class="container-fluid">
    <div class="card card-primary card-outline elevation-2 p-3">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-12">
                <div class="form-group">
                    <label for="filterPosition">Position</label>
                    <select class="form-control" id="filterPosition" name="filterPosition">
                        <option value=""> -- Select Position -- </option>
                        @foreach($positions as $position)
                            <option value="{{$position->Id}}">{{strtoupper($position->Description)}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12">
                <div class="form-group">
                    <label for="filterCandidate">Candidate</label>
                    <select class="form-control" id="filterCandidate" name="filterCandidate">
                        <option value=""> -- Select Candidate -- </option>
                        @foreach($candidates as $candidate)
                            <option value="{{$candidate["Id"]}}">{{strtoupper($candidate["FirstName"]." ".$candidate["MiddleName"]." ".$candidate["LastName"])}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12">
                <label for="clearFilter">&nbsp;</label>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary font-weight-bold" id="clearFilter">
                        <i class="fas fa-filter"></i> Clear Filter
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-primary card-outline elevation-2 p-3">
        <div class="row mt-1">
            <div class="col-lg-8 col-md-8 col-sm-12">
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
                <div class="form-group">
                    <button type="submit" class="btn btn-lg btn-primary float-lg-right font-weight-bold" id="printBtn">
                        <i class="fas fa-print"></i> Print Votes Tally
                    </button>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table id="dataTable" class="table table-hover table-bordered dataTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Voter ID</th>
                        <th>Position</th>
                        <th>Candidate</th>
                        <th>Vote Method</th>
                        <th>Date Voted</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

{{-- PRINT TICKETS FORM --}}
<form method="POST" id="printSummaryForm" target="_blank" action="{{route('print.summary')}}">
    @csrf
    <input type="hidden" name="filterPosition">
    <input type="hidden" name="filterCandidate">
    <input type="hidden" name="filterSearch">
</form>
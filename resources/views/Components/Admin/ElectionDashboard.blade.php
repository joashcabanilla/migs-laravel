<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="small-box bg-gradient-orange card card-primary elevation-3">
                <div class="inner">
                    <h3 class="font-weight-bold text-white totalMembers">0</h3>
                    <h5 class="font-weight-bold text-white">Total Members</h5>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="small-box bg-gradient-teal card card-primary elevation-3">
                <div class="inner">
                    <h3 class="font-weight-bold text-white totalMigs">0</h3>
                    <h5 class="font-weight-bold text-white">Total MIGS</h5>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="small-box bg-gradient-success card card-primary elevation-3">
                <div class="inner">
                    <h3 class="font-weight-bold text-white totalVoted">0</h3>
                    <h5 class="font-weight-bold text-white">Voted Voters</h5>
                </div>
                <div class="icon">
                    <i class="fas fa-vote-yea"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="small-box bg-gradient-danger card card-primary elevation-3">
                <div class="inner">
                    <h3 class="font-weight-bold text-white totalNonVoting">0</h3>
                    <h5 class="font-weight-bold text-white">Non-voting Voters</h5>
                </div>
                <div class="icon">
                    <i class="far fa-file"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="small-box bg-gradient-info card card-primary elevation-3">
                <div class="inner">
                    <h3 class="font-weight-bold text-white totalQuorum">0</h3>
                    <h5 class="font-weight-bold text-white">Quorum</h5>
                </div>
                <div class="icon">
                    <i class="fas fa-percent"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="small-box bg-gradient-indigo card card-primary elevation-3">
                <div class="inner">
                    <h3 class="font-weight-bold text-white totalPositions">0</h3>
                    <h5 class="font-weight-bold text-white">No Of Positions</h5>
                </div>
                <div class="icon">
                    <i class="fas fa-poll-h"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="small-box bg-gradient-maroon card card-primary elevation-3">
                <div class="inner">
                    <h3 class="font-weight-bold text-white totalCandidates">0</h3>
                    <h5 class="font-weight-bold text-white">No Of Candidates</h5>
                </div>
                <div class="icon">
                    <i class="fas fa-poll-h"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3 mb-2">
        <div class="col-12">
            <h4 class="font-weight-bold">VOTES TALLY</h4>
        </div>
    </div>
    <div class="row voteTally">
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="card card-primary card-outline elevation-2 p-2">
                <div class="row">
                    <div class="col-12">
                        <h5 class="font-weight-bold">PER BRANCH</h5>
                    </div>
                    <div class="col-12">
                        <div class="chart mt-3">
                            <canvas class="voteTallyBranch" style="width: 100%; height: 300px;"></canvas>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
        @foreach($positionList as $position)
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="card card-primary card-outline elevation-2 p-2">
                    <div class="row">
                        <div class="col-12">
                            <h5 class="font-weight-bold">{{strtoupper($position->Description)}}</h5>
                        </div>
                        <div class="col-12">
                            <div class="chart mt-3">
                                <canvas class="votePositionTally{{$position->Id}}" style="width: 100%; height: 300px;"></canvas>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        @endforeach
    </div>
</div>
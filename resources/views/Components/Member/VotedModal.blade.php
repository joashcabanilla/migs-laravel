<!-- Modal -->
<div class="modal fade" id="voteModal" tabindex="-1" role="dialog" aria-labelledby="voteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="voteModalLabel">SUMMARY OF VOTES</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="modal-closeIcon" aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @foreach ($candidateList as $position => $candidates)
                    <div class="row d-none">
                        <div class="col-12 mt-0 mb-2">
                            <h5 class="font-weight-bold bg-warning text-center p-2 mb-0">{{$position}}</h5>
                        </div>
                        @foreach($candidates as $candidate)
                            @if($currentPage == "voted")
                                @if(in_array($candidate["Id"],$votedCandidatesList))
                                    <div class="col-12 mt-0 mb-0 showVotedCandidate">
                                        <div class="row">
                                            <div class="col-12">
                                                <h5 class="font-weight-bold ml-2"><i class="fas fa-chevron-right" style="font-size:0.9rem !important;"></i> {{$candidate["FirstName"]." ".$candidate["MiddleName"]." ".$candidate["LastName"]}}</h5>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div class="col-12 mt-0 mb-0 d-none candidateVoted-{{$candidate["Id"]}}">
                                    <div class="row">
                                        <div class="col-12">
                                            <h5 class="font-weight-bold ml-2"><i class="fas fa-chevron-right" style="font-size:0.9rem !important;"></i> {{$candidate["FirstName"]." ".$candidate["MiddleName"]." ".$candidate["LastName"]}}</h5>
                                        </div>
                                    </div>
                                </div>
                            @endif   
                        @endforeach
                    </div>
                @endforeach
            </div>
            <div class="modal-footer">
                @if($currentPage == "voted")
                    <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                @else
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="voteConfirmBtn">Confirm</button>
                @endif
            </div>
        </div>
    </div>
</div>
@if($currentPage == "voted")
    <script>
        $(document).ready((e) => {
            $(".tabTitle").remove();
        });
    </script>
@endif
<div class="container-fluid">
    @if(!empty($ticketNo))
        <div class="row">
            <div class="col-12">
                <h3 class="font-weight-bold text-monospace text-center">THIS IS YOUR RAFFLE TICKET</h3>
            </div>
            <div class="col-12 d-flex justify-content-center">
                <div class="card card-primary img-fluid elevation-3 mt-2 TicketPicture">
                    <img class="TicketPictureSrc" src="{{asset('image/ticket.jpg')}}" alt="Picture" width="100" height="100">
                    <p class="text-monospace text-danger font-weight-bold m-0 ticketNoLabel">{{$ticketNo}}</p>
                </div>
            </div>
        </div>
    @endif    
    
    @if($f2f == "YES")
        <div class="row mb-3 mt-5">
            <div class="col-12">
                <h3 class="font-weight-bold text-monospace text-center">{{strtoupper("You have already voted for this election.")}}</h3>
            </div>
        </div>
    @endif

    @if(!empty($votedCandidatesList))
        {{-- <div class="row">
            <div class="col-12 d-flex justify-content-center align-items-center">
                <button style="width: 250px; font-size: 1.2rem !important;" class="btn btn-lg btn-primary font-weight-bold" id="viewVote">VIEW SUMMARY OF VOTES</button>
            </div>
        </div> --}}
    @endif

    @if($f2f == "NO")
        <div class="row mt-3">
            <div class="col-12">
                <p class="text-center text-indigo text-monospace mb-0">Here's your <a class="text-indigo text-monospace font-weight-bold">Zoom Credentials</a> for the 50th General Assembly Virtual Meeting to be held on</p>
                <p class="text-center text-indigo text-monospace font-weight-bold mb-1">{{$gaDate}}</p>
                <p class="text-center text-monospace font-weight-bold mb-0">TIME</p>
                <p class="text-center text-monospace font-weight-bold">{{$gaSched}}</p>
            </div>
        </div>
        <div class="row d-flex justify-content-center align-items-center flex-column mb-5">
            <div class="col-lg-4 col-md-6 col-sm-12 mb-2">
                <div class="input-group">
                    <label for="meetingID" class="mt-1">Meeting ID</label>
                    <input type="text" class="form-control bg-white ml-2 mr-2 font-weight-bold" id="meetingID" name="meetingID" autocomplete="false" value="{{$meetingID}}" readonly>
                    <button class="btn btn-info copyBtn">COPY</button>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="input-group">
                    <label for="passCode" class="mt-1">Passcode &nbsp;&nbsp;</label>
                    <input type="text" class="form-control bg-white ml-2 mr-2 font-weight-bold" id="passCode" name="passCode" autocomplete="false" value="{{$meetingPass}}" readonly>
                    <button class="btn btn-info copyBtn">COPY</button>
                </div>
            </div>
        </div>
    @endif
</div>
@include('Components.Member.VotedModal')
<div class="container-fluid">
    <form id="voteForm" method="POST" enctype="multipart/form-data">
        @foreach ($candidateList as $position => $candidates)
            @php
                shuffle($candidates);
                $trimPosition = str_replace(' ', '', $position);
                $limit = $voteLimit[$trimPosition];
            @endphp
            <div class="card card-primary card-outline elevation-2 p-3">
                <div class="row">
                    <div class="col-12">
                        <h3 class="font-weight-bold">{{$position}}</h3>
                        <h5 class="font-weight-bold text-monospace text-danger">You may select up to {{$limit}} candidates</h5>
                    </div>
                    @foreach($candidates as $candidate)
                        <div class="col-lg-6 col-md-6 col-sm-12 mt-3 mb-3">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 d-flex justify-content-center align-items-center">
                                    <div class="row d-flex justify-content-center align-items-center">
                                        <div class="col-2">
                                            <div class="icheck-success candidateCheckbox">
                                                <input type="checkbox" id="candidateId-{{$candidate["Id"]}}" name="candidateId[]" value="{{$candidate["Id"]}}" data-position="{{$position}}" data-votelimit="{{$limit}}">
                                                <label for="candidateId-{{$candidate["Id"]}}"></label>
                                            </div>
                                        </div>
                                        <div class="col-10">
                                            <div class="img-fluid elevation-2 CandidatePictureTable float-center">
                                                <img class="picture"  src="{{$candidate["Picture"]}}" alt="Picture" width="100" height="100">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 mt-lg-0 mt-md-0 mt-3 d-flex align-items-center justify-content-lg-start justify-content-md-start justify-content-center">
                                    <h5 class="font-weight-bold">{{$candidate["FirstName"]." ".$candidate["MiddleName"]." ".$candidate["LastName"]}}</h5>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
        <div class="row mb-5 mt-4">
            <div class="col-12 d-flex justify-content-center align-items-center">
                <button type="submit" style="width: 250px; font-size: 1.5rem !important;" class="btn btn-lg btn-primary font-weight-bold" id="voteBtn">SUBMIT VOTE</button>
            </div>
        </div>
    </form>
</div>

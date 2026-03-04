@extends('Layouts.Result')
@section('content')
<div class="mt-1 m-4">
    <div class="card elevation-2">
        <div class="card-header d-flex align-items-center flex-wrap">
            <img src="{{asset('image/1.png')}}" alt="logo" width="250" />
            <h2 class="font-weight-bold text-dark text-center ml-4">50th GA Election Vote Tally</h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-6 cardBOD">
                    {{-- BOD TABLE --}}
                    @include("Components.Guest.ElectionLiveCard", [
                        "positionDescription" => $result["positions"][1]["description"],
                        "positionId" => 1,
                        "result" => $result
                    ])
                </div>
                <div class="col-12 col-md-12 col-lg-6">
                    <div class="row">
                        <div class="col-12 cardAC">
                            {{-- AC TABLE --}}
                            @include("Components.Guest.ElectionLiveCard", [
                                "positionDescription" => $result["positions"][2]["description"],
                                "positionId" => 2,
                                "result" => $result
                            ])
                        </div>
                        <div class="col-12 mt-2 cardEC">
                            {{-- EC TABLE --}}
                            @include("Components.Guest.ElectionLiveCard", [
                                "positionDescription" => $result["positions"][3]["description"],
                                "positionId" => 3,
                                "result" => $result
                            ])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

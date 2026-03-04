<div class="card elevation-1">
    <div class="card-header bg-primary p-2 m-0">
        <h4 class="font-weight-bolder">{{$positionDescription}}</h4>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table m-0">
                <thead>
                    <tr>
                        <th class="p-2 text-center align-middle" style="width: 30%;">
                            <h4 class="font-weight-bold m-0 p-0">CANDIDATES</h4>
                        </th>
                        <th class="p-2 text-center align-middle" style="width: 70%;">
                            <h4 class="font-weight-bold m-0 p-0">VOTES</h4>
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($result["voteTally"][$positionId] as $key => $candidate)
                        <tr>
                            <td class="p-2 text-center align-middle">
                                <h4 class="font-weight-bold m-0 p-0 candidateCodeName{{$key}}">{{$candidate["codeName"]}}</h4>
                            </td>
                            <td class="p-2 align-middle">
                                <div class="progress rounded-pill {{(float)$candidate["percentage"] > 0 ?: 'position-relative'}}" style="height: 40px;">
                                    <div class="bg-success progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width:{{$candidate["percentage"]}}%" aria-valuenow="{{$candidate["percentage"]}}" aria-valuemin="0" aria-valuemax="100">
                                        <h5 class="candidatePercentage{{$key}} font-weight-bold m-0 p-1 {{(float)$candidate["percentage"] > 0 ?: 'position-absolute w-100 text-center text-dark'}}">{{(float)$candidate["percentage"] > 0 ? $candidate["percentage"] . '%' : '0%'}}</h5>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
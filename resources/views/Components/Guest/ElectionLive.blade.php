@extends('Layouts.Result')
@section('content')
<div class="hold-transition mt-1 m-4">
    <div class="card elevation-2">
        <div class="card-header d-flex align-items-center">
            <img src="{{asset('image/1.png')}}" alt="logo" width="250" />
            <h2 class="font-weight-bold text-dark text-center ml-4">Tentative 50th GA Election Results</h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-6"> 
                    <div class="table-responsive">
                        <table id="bodTable" class="table table-bordered table-striped m-0">
                            <thead>
                                <tr class="bg-primary">
                                    <th colspan="3" class="p-2 text-center align-middle">
                                        <h3 class="font-weight-bolder m-0 p-0">BOARD OF DIRECTORS</h3>
                                    </th>
                                </tr>
                                <tr class="bg-primary">
                                    <th class="p-2 text-center align-middle" style="width: 10%;">
                                        <h3 class="font-weight-bolder m-0 p-0">RANK</h3>
                                    </th>
                                    <th class="p-2 text-center align-middle" style="width: 45%;">
                                        <h3 class="font-weight-bolder m-0 p-0">CANDIDATES</h3>
                                    </th>

                                    <th class="p-2 text-center align-middle" style="width: 45%;">
                                        <h3 class="font-weight-bolder m-0 p-0">VOTES</h3>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="bodTableBody">
                                <tr class="table-success">
                                    <td class="p-2 text-center align-middle">
                                        <h3 class="font-weight-bolder m-0 p-0">1</h3>
                                    </td>
                                    <td class="p-2 text-center align-middle">
                                        <h3 class="font-weight-bolder m-0 p-0">BOD 1</h3>
                                    </td>
                                    <td class="p-2 text-center align-middle">
                                        <h3 class="font-weight-bolder m-0 p-0">1,000</h3>
                                    </td>
                                </tr>
                                                            <tr class="table-success">
                                    <td class="p-2 text-center align-middle">
                                        <h3 class="font-weight-bolder m-0 p-0">2</h3>
                                    </td>
                                    <td class="p-2 text-center align-middle">
                                        <h3 class="font-weight-bolder m-0 p-0">BOD 2</h3>
                                    </td>
                                    <td class="p-2 text-center align-middle">
                                        <h3 class="font-weight-bolder m-0 p-0">900</h3>
                                    </td>
                                </tr>
                                                            <tr class="table-success">
                                    <td class="p-2 text-center align-middle">
                                        <h3 class="font-weight-bolder m-0 p-0">3</h3>
                                    </td>
                                    <td class="p-2 text-center align-middle">
                                        <h3 class="font-weight-bolder m-0 p-0">BOD 3</h3>
                                    </td>
                                    <td class="p-2 text-center align-middle">
                                        <h3 class="font-weight-bolder m-0 p-0">800</h3>
                                    </td>
                                </tr>
                                                        
                                                            
                                
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-6"> 
                    <div class="table-responsive">
                        <table id="bodTable" class="table table-bordered table-striped m-0">
                            <thead>
                                <tr class="bg-primary">
                                    <th colspan="3" class="p-2 text-center align-middle">
                                        <h3 class="font-weight-bolder m-0 p-0">BOARD OF DIRECTORS</h3>
                                    </th>
                                </tr>
                                <tr class="bg-primary">
                                    <th class="p-2 text-center align-middle" style="width: 10%;">
                                        <h3 class="font-weight-bolder m-0 p-0">RANK</h3>
                                    </th>
                                    <th class="p-2 text-center align-middle" style="width: 45%;">
                                        <h3 class="font-weight-bolder m-0 p-0">CANDIDATES</h3>
                                    </th>

                                    <th class="p-2 text-center align-middle" style="width: 45%;">
                                        <h3 class="font-weight-bolder m-0 p-0">VOTES</h3>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="bodTableBody">
                                <tr class="table-success">
                                    <td class="p-2 text-center align-middle">
                                        <h3 class="font-weight-bolder m-0 p-0">4</h3>
                                    </td>
                                    <td class="p-2 text-center align-middle">
                                        <h3 class="font-weight-bolder m-0 p-0">BOD 4</h3>
                                    </td>
                                    <td class="p-2 text-center align-middle">
                                        <h3 class="font-weight-bolder m-0 p-0">700</h3>
                                    </td>
                                </tr>
                                <tr class="table-success">
                                    <td class="p-2 text-center align-middle">
                                        <h3 class="font-weight-bolder m-0 p-0">5</h3>
                                    </td>
                                    <td class="p-2 text-center align-middle">
                                        <h3 class="font-weight-bolder m-0 p-0">BOD 5</h3>
                                    </td>
                                    <td class="p-2 text-center align-middle">
                                        <h3 class="font-weight-bolder m-0 p-0">600</h3>
                                    </td>
                                </tr>
                                <tr class="table-success">
                                    <td class="p-2 text-center align-middle">
                                        <h3 class="font-weight-bolder m-0 p-0">6</h3>
                                    </td>
                                    <td class="p-2 text-center align-middle">
                                        <h3 class="font-weight-bolder m-0 p-0">BOD 6</h3>
                                    </td>
                                    <td class="p-2 text-center align-middle">
                                        <h3 class="font-weight-bolder m-0 p-0">500</h3>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-6 mt-4"> 
                    <div class="table-responsive">
                        <table id="bodTable" class="table table-bordered table-striped m-0">
                            <thead>
                                <tr class="bg-primary">
                                    <th colspan="3" class="p-2 text-center align-middle">
                                        <h3 class="font-weight-bolder m-0 p-0">AUDIT COMMITTEE</h3>
                                    </th>
                                </tr>
                                <tr class="bg-primary">
                                    <th class="p-2 text-center align-middle" style="width: 10%;">
                                        <h3 class="font-weight-bolder m-0 p-0">RANK</h3>
                                    </th>
                                    <th class="p-2 text-center align-middle" style="width: 45%;">
                                        <h3 class="font-weight-bolder m-0 p-0">CANDIDATES</h3>
                                    </th>

                                    <th class="p-2 text-center align-middle" style="width: 45%;">
                                        <h3 class="font-weight-bolder m-0 p-0">VOTES</h3>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="bodTableBody">
                                <tr class="table-success">
                                    <td class="p-2 text-center align-middle">
                                        <h3 class="font-weight-bolder m-0 p-0">1</h3>
                                    </td>
                                    <td class="p-2 text-center align-middle">
                                        <h3 class="font-weight-bolder m-0 p-0">AC 1</h3>
                                    </td>
                                    <td class="p-2 text-center align-middle">
                                        <h3 class="font-weight-bolder m-0 p-0">1,000</h3>
                                    </td>
                                </tr>
                                                            <tr class="table-success">
                                    <td class="p-2 text-center align-middle">
                                        <h3 class="font-weight-bolder m-0 p-0">2</h3>
                                    </td>
                                    <td class="p-2 text-center align-middle">
                                        <h3 class="font-weight-bolder m-0 p-0">AC 2</h3>
                                    </td>
                                    <td class="p-2 text-center align-middle">
                                        <h3 class="font-weight-bolder m-0 p-0">900</h3>
                                    </td>
                                </tr>
                                <tr class="table-success">
                                    <td class="p-2 text-center align-middle">
                                        <h3 class="font-weight-bolder m-0 p-0">3</h3>
                                    </td>
                                    <td class="p-2 text-center align-middle">
                                        <h3 class="font-weight-bolder m-0 p-0">AC 3</h3>
                                    </td>
                                    <td class="p-2 text-center align-middle">
                                        <h3 class="font-weight-bolder m-0 p-0">800</h3>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-6 mt-4"> 
                    <div class="table-responsive">
                        <table id="bodTable" class="table table-bordered table-striped m-0">
                            <thead>
                                <tr class="bg-primary">
                                    <th colspan="3" class="p-2 text-center align-middle">
                                        <h3 class="font-weight-bolder m-0 p-0">ELECTION COMMITTEE</h3>
                                    </th>
                                </tr>
                                <tr class="bg-primary">
                                    <th class="p-2 text-center align-middle" style="width: 10%;">
                                        <h3 class="font-weight-bolder m-0 p-0">RANK</h3>
                                    </th>
                                    <th class="p-2 text-center align-middle" style="width: 45%;">
                                        <h3 class="font-weight-bolder m-0 p-0">CANDIDATES</h3>
                                    </th>

                                    <th class="p-2 text-center align-middle" style="width: 45%;">
                                        <h3 class="font-weight-bolder m-0 p-0">VOTES</h3>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="bodTableBody">
                                <tr class="table-success">
                                    <td class="p-2 text-center align-middle">
                                        <h3 class="font-weight-bolder m-0 p-0">1</h3>
                                    </td>
                                    <td class="p-2 text-center align-middle">
                                        <h3 class="font-weight-bolder m-0 p-0">EC 1</h3>
                                    </td>
                                    <td class="p-2 text-center align-middle">
                                        <h3 class="font-weight-bolder m-0 p-0">1,000</h3>
                                    </td>
                                </tr>
                                <tr class="table-success">
                                    <td class="p-2 text-center align-middle">
                                        <h3 class="font-weight-bolder m-0 p-0">2</h3>
                                    </td>
                                    <td class="p-2 text-center align-middle">
                                        <h3 class="font-weight-bolder m-0 p-0">EC 2</h3>
                                    </td>
                                    <td class="p-2 text-center align-middle">
                                        <h3 class="font-weight-bolder m-0 p-0">900</h3>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
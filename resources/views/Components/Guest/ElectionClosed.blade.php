@extends('Layouts.Guest')
@section('content')
    <div class="hold-transition d-flex justify-content-center mt-5 m-3">
        <div class="card elevation-3">
            <div class="card-header text-center">
                <img src="{{asset('image/1.png')}}" alt="logo" width="350" />
            </div>
            @if(config('app.F2F_ELECTION') == "NO")
                <div class="card-body">
                    <h1 class="font-weight-bold text-monospace text-center">The 48th GA Registration and Voting System</h1>
                    <h1 class="font-weight-bold text-monospace text-center" style="color:purple">ONLINE REGISTRATION AND ELECTION ARE NOW CLOSED!</h1> 
                </div>
            @else
                <div class="card-body">
                    <h1 class="font-weight-bold text-monospace text-center">The 48th GA Registration and Voting System</h1>
                    <h1 class="font-weight-bold text-monospace text-center" style="color:purple">CLOSED!</h1> 
                </div>
            @endif

        </div>
    </div>
@endsection
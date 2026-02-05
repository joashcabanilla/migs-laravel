@extends('Layouts.Guest')
@section('content')
    <div class="container-login hold-transition login-page">
        <div class="login-box">
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <img src="{{asset('image/1.png')}}" alt="logo" width="250" />
                    <div class="alert alert-danger mt-2 mb-0 error-text d-none font-weight-bold" role="alert">
                        text message error
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="mb-2"><b>Sign into your account</b></h5>
                    <p class="text-muted">An One-Time Password (OTP) has been sent to your registered email address: <b>{{ !empty($email) ? $email : 'No Email Found' }}</b></p>
                    <form id="voterForm" method="POST">
                        <input type="hidden" name="VoterId" value="{{$VoterId}}">
                        <input type="hidden" name="otp" id="otp">
                        <div class="d-flex justify-content-between otp-inputs mb-3">
                            <input type="text" name="otp1" class="form-control mr-2 text-center border-primary otp" maxlength="1">
                            <input type="text" name="otp2" class="form-control mr-2 text-center border-primary otp" maxlength="1">
                            <input type="text" name="otp3" class="form-control mr-2 text-center border-primary otp" maxlength="1">
                            <input type="text" name="otp4" class="form-control mr-2 text-center border-primary otp" maxlength="1">
                            <input type="text" name="otp5" class="form-control mr-2 text-center border-primary otp" maxlength="1">
                            <input type="text" name="otp6" class="form-control text-center border-primary otp" maxlength="1">
                        </div>
                        <button type="submit" class="d-none">Verify OTP</button>
                    </form>
                    
                    <div class="d-flex justify-content-center">
                        <p class="text-muted text-center">
                            Resend OTP in <span id="voterTimer">5:00</span>
                        </p>
                        <button id="resendOtpBtn" class="btn btn-primary font-weight-bold rounded d-none">
                            RESEND
                        </button>
                    </div>

                    <button id="backToVerifierBtn" class="btn btn-primary rounded mt-3 btn-block">
                        <i class="fas fa-arrow-left mr-2"></i> Back to Verifier Page
                    </button>

                </div>
            </div>
        </div>
    </div>
@endsection
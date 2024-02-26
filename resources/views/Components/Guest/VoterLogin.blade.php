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
                    <h5 class="mb-3"><b>Sign into your account</b></h5>
                    <form id="voterForm" method="POST">
                        <label for="username">Pb No / Member Id</label>
                        <div class="input-group mb-3">
                            <input type="hidden" name="VoterId" value="{{$VoterId}}">
                            <input type="text" class="form-control font-weight-bold" placeholder="Username" id="username" name="username" autocomplete="false" value="{{$Pbno}}" disabled>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>

                        <label for="Birthdate">Birthdate</label>
                        <div class="input-group mb-3">
                            <input type="date" class="form-control" id="Birthdate" name="Birthdate" autocomplete="false" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-12">
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <button type="submit" class="btn btn-primary btn-block font-weight-bold">Sign In</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
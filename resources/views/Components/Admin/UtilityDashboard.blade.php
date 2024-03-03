<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="small-box bg-gradient-orange card card-primary elevation-3">
                <div class="inner">
                    <h3 class="font-weight-bold text-white totalMembers">{{$totalMembers}}</h3>
                    <h5 class="font-weight-bold text-white">Total Members</h5>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="" class="small-box-footer" id ="dashboardUrl">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="small-box bg-gradient-info card card-primary elevation-3">
                <div class="inner">
                    <h3 class="font-weight-bold text-white totalBirthdate">{{$updatedBirthdate}}</h3>
                    <h5 class="font-weight-bold text-white">Updated Birthdate</h5>
                </div>
                <div class="icon">
                    <i class="fas fa-book"></i>
                </div>
                <a href="" class="small-box-footer" id="memberInfoUrl">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="small-box bg-gradient-success card card-primary elevation-3">
                <div class="inner">
                    <h3 class="font-weight-bold text-white totalStatus">{{$updateStatus}}</h3>
                    <h5 class="font-weight-bold text-white">Updated Status</h5>
                </div>
                <div class="icon">
                    <i class="fas fa-book"></i>
                </div>
                <a href="" class="small-box-footer" id="memberStatusUrl">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="small-box bg-gradient-danger card card-primary elevation-3">
                <div class="inner">
                    <h3 class="font-weight-bold text-white totalVerification">{{$forVerification}}</h3>
                    <h5 class="font-weight-bold text-white">For Verification</h5>
                </div>
                <div class="icon">
                    <i class="fas fa-book"></i>
                </div>
                <a href="" class="small-box-footer" id="verificationUrl">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="small-box bg-gradient-success card card-primary elevation-3">
                <div class="inner">
                    <h3 class="font-weight-bold text-white totalVerified">{{$verifiedStatus}}</h3>
                    <h5 class="font-weight-bold text-white">Verified Status</h5>
                </div>
                <div class="icon">
                    <i class="fas fa-book"></i>
                </div>
                <a href="" class="small-box-footer" id="verifiedUrl">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="{{asset('js/Admin.js')}}"></script>
    <script src="{{asset('js/Sidebar.js')}}"></script>
@endpush
@extends('Layouts.Guest')
@section('content')
    <div class="container-verifier container-fluid d-flex justify-content-center hold-transition">
        <div class="card elevation-2 p-3 mt-4 main-card">
            <div class="row">
                <div class="col-12">
                    <img src="{{asset('image/1.png')}}" width="200"/>
                </div>
                <div class="col-12 mt-3">
                    <h3 class="text-center font-weight-bold mb-0">49th General Assembly</h3>
                    <h2 class="text-center font-weight-bold text-light">MIGS VERIFICATION</h2>
                </div>
                <div class="col-12 d-flex justify-content-center">
                    <h6 class="font-weight-bold text-warning m-0 mr-2 mt-1">MEMBERSHIP CUT OFF DATE:</h6>
                    <h6 class="font-weight-bold m-0 bg-info rounded p-1">DECEMBER 28, 2024</h6>
                </div>
                <div class="col-12 d-flex justify-content-center mt-2">
                    <h6 class="font-weight-bold text-warning m-0 mr-2 mt-1">MIGS CUT OFF DATE:</h6>
                    <h6 class="font-weight-bold m-0 bg-info rounded p-1">MARCH 1, 2025</h6>
                </div>
                <div class="col-12 mt-4">
                    <h5 class="font-weight-bold text-warning">PAALALA:</h5>
                    {{-- <h5 class="text-light">PARA SA MGA KAMAY-ARI NA BUMOTO AT NAGPA-REHISTRO ONLINE ANG INYONG MGA <b class="text-warning">GA ITEMS</b> AY MAAARING I-CLAIM  MULA <b class="text-warning">MARCH 5, 2024</b> HANGGANG <b class="text-warning">MARCH 15, 2024</b> LAMANG.</h5> --}}
                    <h5 class="text-light">Siguraduhing mapanatili ang inyong MIGS status hanggang sa ika-1 ng Marso upang matiyak na nasa magandang katayuan ang inyong status sa darating na General Assembly.</h5>
                    <h5 class="text-light">Para naman po sa mga bagong nag ayos ng kanilang mga account, mangyaring hintayin ang susunod na update upang maipakita ang pinakabagong status.</h5>
                </div>
                <div class="col-12 mt-2">
                    {{-- <h5 class="text-light">PARA NAMAN SA MGA KASAPI NA NASA IBANG LUGAR O HINDI MAKAKAPUNTA, MAAARING IPAKUHA ANG INYONG MGA <b class="text-warning">GA ITEMS.</b> MAGDALA LAMANG NG <b class="text-warning">AUTHORIZATION LETTER</b> AT <b class="text-warning">PHOTO COPY</b> NG INYONG VALID ID. MAAARI DIN I-CLAIM HANGGANG <b class="text-warning">MARCH 15, 2024</b> LAMANG.</h5> --}}

                    <h5 class="text-warning font-weight-bold mb-0">MIGS Verifier Records as of February 27, 2025.</h5>
                </div>
                <div class="col-12">
                    <hr class="bg-light" />
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <form method="POST" id="verifierForm">
                        <label for="verifierSearch" class="text-light font-weight-bold">MEMBER ID / PB#</label>
                        <div class="form-group row">
                            <div class="col-lg-6 col-md-12 col-sm-12 m-lg-0 m-md-1 m-1">
                                <input type="text" class="form-control form-control-lg" placeholder="Type here..." name="search" id="verifierSearch" autocomplete="true" required autofocus>
                            </div>
                            <div class="col-lg-2 col-md-12 col-sm-12 m-lg-0 m-md-1 m-1">
                                <button class="font-weight-bold btn btn-success form-control form-control-lg" style="width: 150px;"><i class="fas fa-search"></i> Verify</button>   
                            </div>
                            <div class="col-12 mt-3">
                                <h4 class="text-warning"><i class="text-light">Example format for</i> PB number "001234" no Dash(-), kapag may letra naman "N001234" <br /><i class="text-light">at kung</i> Member ID "0010000000123456",<br /><i class="text-light"> ang i lalagay lang ang</i> 123456</h4>

						        <h5 class="text-light font-weight-bold">Note:Priority ang Old Passbook sa pag verify</h5>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card elevation-2 p-2 bg-light memcard memcard-verifier d-none">
                <h3 class="text-center font-weight-bold memberName">JOASH FLORENTINO CABANILLA</h3>
                <div class="d-flex justify-content-center mt-2">
                    <div class="d-md-flex d-lg-flex">
                        <h3 class="font-weight-bold mr-2 black">PB#:</h3>
                        <h3 class="font-weight-bold mr-3 pbno"></h3>
                    </div>
                    <div class="d-md-flex d-lg-flex">
                        <h3 class="font-weight-bold mr-2 black">Member ID:</h4>
                        <h3 class="font-weight-bold memberID"></h3>
                    </div>

                </div>
                <h3 class=" text-center font-weight-bold status"></h3>
                <h3 class='text-center font-weight-bold voteBtn d-none'>>>> Click here to VOTE <<<</h3>  
                <div class="d-none justify-content-center">
                    <h5 class="font-weight-bold mr-2">Makipag ugnayan sa inyong account officer(AO)</h5>
                    <h5 class="font-weight-bold nonMigs">>> Please click here <<</h5>
                </div>
            </div>

            <div class="card elevation-2 p-2 bg-light norecord-verifier d-none">
                <h3 class="text-center text-danger font-weight-bold">NO RECORD FOUND!</h3>
                <h5 class="text-center purple font-weight-bold"><u>Please Call these Hotline:</u></h5>
                <div class="d-flex justify-content-center">
                    <div class="card elevation-1 p-3">
                        @foreach($branchContact as $value)
                            <p class="text-center text-monospace font-weight-bold black m-0 mb-1">{{$value}}</p>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="search-container-verifier"></div>
        </div>
    </div>
    @include('Components.Guest.NonmigsModal')
@endsection
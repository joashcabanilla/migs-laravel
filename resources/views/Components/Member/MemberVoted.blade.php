@if($currentPage == "voted")
    <script>
        $(document).ready((e) => {
            $(".tabTitle").remove();
        });
    </script>
@endif
<div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h3 class="font-weight-bold text-monospace text-center">THIS IS YOUR RAFFLE TICKET</h3>
            </div>
            <div class="col-12 d-flex justify-content-center">
                <div class="card card-primary img-fluid elevation-3 mt-2 TicketPicture">
                    <img class="TicketPictureSrc" id="CandidatePicture" src="{{asset('image/ticket.jpg')}}" alt="Picture" width="100" height="100">
                </div>
            </div>
        </div>
</div>

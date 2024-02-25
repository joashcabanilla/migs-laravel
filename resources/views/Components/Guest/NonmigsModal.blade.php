<div class="modal fade" id="nonMigsModal" tabindex="-1" role="dialog" aria-labelledby="nonMigsModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title font-weight-bold" id="nonMigsModalLabel">REQUEST FOR MIGS STATUS VERIFICATION</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span class="modal-closeIcon" aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="nonMigsForm" method="POST">
            <input type="hidden" name="Id">
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <h4 class="font-weight-bold text-center text-success text-uppercase nonmigs-membername"></h4>
                        <hr class="bg-light" />
                    </div>
                
                    <div class="col-12">
                        <div class="form-group">
                            <label for="nonmigs-contact">Please type in your mobile number (ex.0966587XXXX)</label>
                            <input type="text" class="form-control font-weight-bold" placeholder="" id="nonmigs-contact" name="contact" autocomplete="false" required maxlength="11">
                        </div>
                    </div>

                    <div class="col-12">
                        <h5 class="font-weight-bold text-center">You may Call these Hotlines:</h5>
                    </div>

                    <div class="col-12">
                        <div class="d-flex justify-content-center align-items-center bg-info">
                            <div class="card elevation-1 p-2 m-2">
                                @foreach($branchContact as $value)
                                    <small class="text-center text-monospace font-weight-bold black m-0 mb-1">{{$value}}</small>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-success font-weight-bold">Submit</button>
              <a type="button" class="btn btn-secondary font-weight-bold" data-dismiss="modal">Cancel</a>
            </div>
        </form>
        
      </div>
    </div>
</div>